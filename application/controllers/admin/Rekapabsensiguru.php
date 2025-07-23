<?php

class Rekapabsensiguru extends CI_Controller
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





    // REKAP HARIAN  ABSENSI GURU
    public function rekapharianguru()
    {
        // Ambil logo dan data profil sekolah
        $logo_data              = $this->Admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->Auth_admin->current_user();
        $data['profilsekolah']  = $this->Admin->get_profilsekolah_data();

        // Ambil nilai dari form jika ada
        $start_date = $this->input->get('start_date');

        // Set default tanggal jika kosong
        if (empty($start_date)) {
            $start_date = date('Y-m-d');
        }

        // Panggil model untuk mengambil data absensi
        $data['absensionline'] = $this->Absensi_Model->get_absensiguru($start_date);

        // Simpan nilai tanggal untuk dikirim kembali ke form
        $data['start_date'] = $start_date;

        // Load view dengan data yang sudah disiapkan
        $this->load->view('admin/absensi/rekapabsensiguru', $data);
    }

    // REKAP BULANAN ABSENSI GURU
    public function rekapbulananguruaa()
    {
        // Ambil logo dan data profil sekolah
        $logo_data              = $this->Admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->Auth_admin->current_user();
        $data['profilsekolah']  = $this->Admin->get_profilsekolah_data();

        // Ambil nilai dari form jika ada
        $start_date = $this->input->get('start_date');

        // Set default tanggal jika kosong
        if (empty($start_date)) {
            $start_date = date('Y-m-d');
        }

        // Panggil model untuk mengambil data absensi
        $data['absensionline'] = $this->Absensi_Model->get_absensiguru($start_date);

        // Simpan nilai tanggal untuk dikirim kembali ke form
        $data['start_date'] = $start_date;

        // Load view dengan data yang sudah disiapkan
        $this->load->view('admin/absensi/rekapabsensiguru', $data);
    }




    public function rekapbulanguru()
{
    // Ambil logo dan data profil sekolah
    $logo_data              = $this->Admin->get_logo();
    $data['logo']           = $logo_data['logo'];
    $data['current_user']   = $this->Auth_admin->current_user();
    $data['profilsekolah']  = $this->Admin->get_profilsekolah_data();

    // Ambil nilai dari form jika ada
    $month = $this->input->get('month');
    $year = $this->input->get('year');

    // Set default bulan dan tahun jika kosong
    if (empty($month) || empty($year)) {
        $month = date('m');
        $year = date('Y');
    }

    // Panggil model untuk mengambil data absensi bulanan
    $data['absensibulan'] = $this->Absensi_Model->get_absensiguru_bulanan($month, $year);

    // Simpan nilai bulan dan tahun untuk dikirim kembali ke form
    $data['month'] = $month;
    $data['year'] = $year;

    // Load view dengan data yang sudah disiapkan
    $this->load->view('admin/absensi/rekapbulanguru', $data);
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

    public function laporan_absensi_siswa()
    {
        require_once APPPATH . 'third_party/tcpdf/tcpdf.php';

        // Memuat model-model yang diperlukan
        $this->load->model('Absensi_Model');
        $this->load->model('Admin');

        // Ambil parameter dari URL
        $start_date = $this->input->get('start_date');
        $kelas_id = $this->input->get('kelas');

        // Set default tanggal jika kosong
        if (empty($start_date)) {
            $start_date = date('Y-m-d');
        }

        // Ambil data dari model
        $lembaga = $this->Admin->get_profilsekolah_data();
        $logo_data = $this->Admin->get_logo();
        $settingabsensi = $this->Absensi_Model->get_settingabsensi();
        $data['logo'] = base_url('assets/web/' . $logo_data['logo']);
        $data['logopemerintah'] = base_url('assets/pemerintah/' . $logo_data['logopemerintah']);

        // Ambil data absensi online berdasarkan tanggal dan kelas
        $absensionline = $this->Absensi_Model->get_absensionline($start_date, $kelas_id);

        if (empty($absensionline)) {
            echo "Tidak ada data absensi yang ditemukan untuk periode tersebut.";
            return;
        }

        // Memuat konten view ke dalam sebuah variabel
        $pdfContent = $this->load->view('admin/cetak/leger_absensi_online', [
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
        $pdf->SetTitle('Laporan Absensi Online');
        $pdf->SetSubject('Laporan Absensi Online');
        $pdf->SetKeywords('Absensi, Online, PDF');
        $pdf->SetPrintHeader(false);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML($pdfContent, true, false, true, false, '');
        $pdf->Output('laporan_absensi_online.pdf', 'I');
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
