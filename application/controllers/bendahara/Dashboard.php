<?php

class Dashboard extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_landing');
		$this->load->model('admin');
		$this->load->model('auth_admin');
        
        // Pemeriksaan apakah pengguna telah login
        $current_user = $this->auth_admin->current_user();
        if (!$current_user) {
            // Simpan URL halaman sebelumnya
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginbendahara');
        }
    
        // Pemeriksaan apakah pengguna memiliki peran 'admin'
        if ($current_user->role != 'bendahara') {
            // Mengarahkan pengguna ke halaman kesalahan kustom
            $error_msg = 'Anda tidak diizinkan mengakses resources ini';
            show_error($error_msg, 403, 'Akses Ditolak');
        }
	}
    
    public function index()
    {
        $total_poskeuangan      = $this->admin->total_poskeuangan();
        $total_jenispembayaran  = $this->admin->total_jenispembayaran();
        $total_siswa 	        = $this->admin->total_siswa();
        $total_tarifpembayaran  = $this->admin->total_tarifpembayaran();
        $logo_data              = $this->admin->get_logo();


        // Data yang akan dikirim ke view
        $data = [
            "current_user" 	            => $this->auth_admin->current_user(),
            "total_poskeuangan"         => $total_poskeuangan,
            "total_jenispembayaran"     => $total_jenispembayaran,
            "total_siswa"               => $total_siswa,
            "total_tarifpembayaran"     => $total_tarifpembayaran,
            "profilsekolah"             => $this->admin->get_profilsekolah_data(), // Ambil data perusahaan
            "logo" 			            => $logo_data['logo'], // Mengirim data logo ke view
        ];

        // Memuat view 'admin/dashboard.php' dan mengirimkan data ke view
        $this->load->view('bendahara/dashboard.php', $data);
    }
}


