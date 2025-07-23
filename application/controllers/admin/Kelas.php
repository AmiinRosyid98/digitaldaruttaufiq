<?php

class Kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Kelas_Model');
        $this->load->model('auth_admin');
        $this->load->library('pagination');
        $this->load->library('upload');

        // Pemeriksaan apakah pengguna telah login
        $current_user = $this->auth_admin->current_user();
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

    public function index()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['kelas']          = $this->Kelas_Model->get_kelas();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/kelas', $data);
    }

    public function get_kelas()
    {
        $kelas_id   = $this->input->get('kelas_id');
        $kelas      = $this->Kelas_Model->get_kelas_by_id($kelas_id);
        echo json_encode(array('kelas' => $kelas));
    }

    public function cetak_siswakelas($kode_kelas)
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
        $nama_kelas             = $this->Absensi_Model->get_nama_kelas($kode_kelas);
        if (empty($siswa)) {
            echo "Tidak ada siswa yang ditemukan untuk kelas tersebut.";
            return;
        }



        // Memuat konten view ke dalam sebuah variabel
        $pdfContent = $this->load->view('admin/cetak/leger_siswakelas', ['siswa' => $siswa, 'nama_kelas' => $nama_kelas,  'lembaga' => $lembaga, 'settingabsensi' => $settingabsensi, 'data' => $data], true);
        $pdf = new TCPDF('L', 'pt', 'LEGAL', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nama Anda');
        $pdf->SetTitle('Daftar Siswa');
        $pdf->SetSubject('Daftar Siswa');
        $pdf->SetKeywords('Daftar Siswa, Leger, PDF');
        $pdf->SetPrintHeader(false);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML($pdfContent, true, false, true, false, '');
        // Menambahkan nama_kelas ke nama file output
        $cleaned_nama_kelas = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nama_kelas); // Bersihkan nama kelas dari karakter yang tidak valid untuk nama file
        $pdf->Output('Daftar_siswa_kelas_' . $cleaned_nama_kelas . '.pdf', 'I');
    }
}
