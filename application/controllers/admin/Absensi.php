<?php

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_admin');
        $this->load->model('Admin');
        $this->load->model('Absensi_Model');
        $this->load->library('pagination');
        // Pemeriksaan apakah pengguna telah login
        $current_user = $this->Auth_admin->current_user();
        if (!$current_user) {
            // Simpan URL halaman sebelumnya
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginadmin');
        }

        // Pemeriksaan apakah pengguna memiliki peran 'admin'
        if ($current_user->role != 'admin') {
            // Mengarahkan pengguna ke halaman kesalahan kustom
            $error_msg = 'Anda tidak diizinkan mengakses resources ini';
            show_error($error_msg, 403, 'Akses Ditolak');
        }
    }




    // FUNGSI ABSENSI MANUAL
    public function manual()
    {
        $logo_data              = $this->Admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->Auth_admin->current_user();
        $data['profilsekolah']  = $this->Admin->get_profilsekolah_data();
        $data['absensimanual']  = $this->Absensi_Model->get_absensimanual();

        $this->load->view('admin/absensi/absensimanual', $data);
    }


    public function rekapsiswa()
    {
        $logo_data = $this->Admin->get_logo();
        $data['logo'] = $logo_data['logo'];
        $data['current_user'] = $this->Auth_admin->current_user();
        $data['profilsekolah'] = $this->Admin->get_profilsekolah_data();

        // Ambil nilai dari query string jika ada
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $kelas_id = $this->input->get('kelas');

        // Set default tanggal jika tidak ada
        $start_date = empty($start_date) ? date('Y-m-d') : $start_date;

        // Panggil model untuk mengambil data absensi
        $data['absensionline'] = $this->Absensi_Model->get_absensionline($start_date, $kelas_id);

        // Panggil model untuk mengambil list kelas
        $data['list_kelas'] = $this->Absensi_Model->get_list_kelas();

        // Simpan nilai tanggal untuk dikirim kembali ke form
        $data['start_date'] = $start_date;
        $data['selected_kelas'] = $kelas_id;

        // Load view dengan data yang sudah disiapkan
        $this->load->view('admin/absensi/rekapabsensisiswa', $data);
    }


    

    // FUNGSI ABSENSI MANUAL
    public function izinsiswa()
    {
        $logo_data              = $this->Admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->Auth_admin->current_user();
        $data['profilsekolah']  = $this->Admin->get_profilsekolah_data();
        $data['izinabsensi']    = $this->Absensi_Model->get_izinsiswa();
        $data['siswaaktive']    = $this->Absensi_Model->get_siswaactive();

        $this->load->view('admin/absensi/izinsiswa', $data);
    }


    public function simpan_izinsiswa()
    {
        // Ambil data yang dikirimkan dari form
        $id_siswa           = $this->input->post('id_siswa');
        $timestamp          = $this->input->post('timestamp');
        $absen              = $this->input->post('absen');


        // Simpan data ke dalam database
        $insert_data = array(
            'id_siswa'          => $id_siswa,
            'timestamp'         => $timestamp,
            'absen'             => $absen
            // Tambahkan data lain yang perlu disimpan
        );

        $insert_result = $this->Absensi_Model->simpan_izinsiswa($insert_data);

        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Izin berhasil disimpan');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Izin');
        }

        redirect('admin/absensi/izinsiswa'); // Redirect kembali ke halaman pelanggaran
    }


    public function cari_siswa()
    {
        $term = $this->input->get('term'); // Ambil kata kunci pencarian dari Ajax

        // Panggil model untuk mencari siswa berdasarkan nama
        $results = $this->Absensi_Model->cari_siswa($term);

        // Format data untuk autocomplete
        $data = array();
        foreach ($results as $row) {
            $nama_siswa = $row['nama_siswa'];
            $nama_kelas = !empty($row['nama_kelas']) ? $row['nama_kelas'] : '';

            // Menggabungkan nama siswa dan nama kelas di satu baris
            $value = $nama_siswa . ($nama_kelas ? ' - ' . $nama_kelas : '');

            $data[] = array(
                'id' => $row['id_siswa'],
                'value' => $value,
            );
        }

        echo json_encode($data); // Mengirimkan data dalam format JSON
    }






    // FUNGSI ABSENSI ONLINE

    public function settingabsen()
    {
        $data['current_user'] = $this->Auth_admin->current_user();
        $data['logo'] = $this->Admin->get_logo()['logo'];
        $data['logopemerintah'] = $this->Admin->get_logopemerintah()['logopemerintah'];
        $data['profilsekolah'] = $this->Admin->get_profilsekolah_data();
        $data['templateabsen'] = $this->Absensi_Model->get_settingabsensi();

        if ($this->input->post()) {
            $profilsekolah_data = array(
                'judul_absensi'             => $this->input->post('judul_absensi'),
                'start_tahun'               => $this->input->post('start_tahun'),
                'end_tahun'                 => $this->input->post('end_tahun'),
                'bulan_absensi'             => $this->input->post('bulan_absensi'),
                'latitude'                  => $this->input->post('latitude'),
                'longitude'                 => $this->input->post('longitude'),
                'radius_absen'              => $this->input->post('radius_absen'),
                'batas_waktu_absen_masuk'   => $this->input->post('batas_waktu_absen_masuk'),
                'batas_waktu_absen_pulang'  => $this->input->post('batas_waktu_absen_pulang')

            );

            $update_result = $this->Absensi_Model->update_settingabsensi($profilsekolah_data);
            if ($update_result) {
                $this->session->set_flashdata('toast_message', 'Setting Absensi berhasil diperbarui');
            } else {
                $this->session->set_flashdata('toast_message', 'Tidak ada data yang diperbarui');
            }
            redirect('admin/absensi/settingabsen');
        }

        // Memuat skrip CKEditor
        $ckeditor_script = '
        <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector("#dasar_skl"))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector("#isi_skl"))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector("#penutup_skl"))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    ';

        $data['ckeditor_script'] = $ckeditor_script;
        $this->load->view('admin/absensi/setting_absensi', $data);
    }





    public function cetak_leger_absensi($kode_kelas)
    {
        require_once APPPATH . 'third_party/tcpdf/tcpdf.php';

        // Memuat model-model yang diperlukan
        $this->load->model('Absensi_Model');
        $this->load->model('Admin');

        // Mengambil daftar siswa berdasarkan kode kelas yang diberikan

        $lembaga                = $this->Admin->get_profilsekolah_data();
        $logo_data              = $this->Admin->get_logo();
        $settingabsensi         = $this->Absensi_Model->get_settingabsensi();
        $data['logo']           = base_url('assets/web/' . $logo_data['logo']);
        $data['logopemerintah'] = base_url('assets/pemerintah/' . $logo_data['logopemerintah']);
        $siswa                  = $this->Absensi_Model->get_siswa_by_kelas($kode_kelas);

        if (empty($siswa)) {
            echo "Tidak ada siswa yang ditemukan untuk kelas tersebut.";
            return;
        }

        $nama_kelas = $this->Absensi_Model->get_nama_kelas($kode_kelas);

        // Memuat konten view ke dalam sebuah variabel
        $pdfContent = $this->load->view('admin/cetak/leger_absensi_manual', ['siswa' => $siswa, 'nama_kelas' => $nama_kelas,  'lembaga' => $lembaga, 'settingabsensi' => $settingabsensi, 'data' => $data], true);
        $pdf = new TCPDF('P', 'pt', 'LEGAL', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nama Anda');
        $pdf->SetTitle('Leger Absensi');
        $pdf->SetSubject('Leger Absensi');
        $pdf->SetKeywords('Absensi, Leger, PDF');
        $pdf->SetPrintHeader(false);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML($pdfContent, true, false, true, false, '');
        $pdf->Output('leger_absensi.pdf', 'I');
    }

    





    public function cetak_pdf_absensi_guru()
    {
        require_once APPPATH . 'third_party/tcpdf/tcpdf.php';

        // Memuat model-model yang diperlukan
        $this->load->model('Absensi_Model');
        $this->load->model('Admin');

        // Ambil parameter dari URL
        $start_date = $this->input->get('start_date');

        // Set default tanggal jika kosong
        if (empty($start_date)) {
            $start_date = date('Y-m-d'); // Atau sesuaikan dengan tanggal default yang diinginkan
        }

        // Ambil data dari model
        $lembaga                = $this->Admin->get_profilsekolah_data();
        $logo_data              = $this->Admin->get_logo();
        $settingabsensi         = $this->Absensi_Model->get_settingabsensi();
        $data['logo']           = base_url('assets/web/' . $logo_data['logo']);
        $data['logopemerintah'] = base_url('assets/pemerintah/' . $logo_data['logopemerintah']);

        // Ambil data absensi berdasarkan tanggal
        $absensionline = $this->Absensi_Model->get_absensiguru($start_date);

        if (empty($absensionline)) {
            echo "Tidak ada data absensi yang ditemukan untuk tanggal tersebut.";
            return;
        }

        // Memuat konten view ke dalam sebuah variabel
        $pdfContent = $this->load->view('admin/cetak/leger_absensi_guru', [
            'absensionline'     => $absensionline,
            'lembaga'           => $lembaga,
            'settingabsensi'    => $settingabsensi,
            'data'              => $data,
            'start_date'        => $start_date,
        ], true);

        // Konfigurasi PDF
        $pdf = new TCPDF('P', 'pt', 'LEGAL', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('REKAP ABSENSI');
        $pdf->SetTitle('Laporan Absensi Guru');
        $pdf->SetSubject('Laporan Absensi Guru');
        $pdf->SetKeywords('Absensi, Guru, PDF');
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML($pdfContent, true, false, true, false, '');
        $pdf->Output('laporan_absensi_guru.pdf', 'I');
    }
}
