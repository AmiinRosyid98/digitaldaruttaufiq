<?php

class Ebook extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Kelas_Model');
        $this->load->model('Ebook_Model');
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
        $logo_data = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['current_user']   = $this->auth_admin->current_user();
        $data['kelas']          = $this->Kelas_Model->get_kelas();      
        $data['buku']           = $this->Ebook_Model->get_buku();      
        $data['bukutimeline']   = $this->Ebook_Model->get_bukutimeline();      
        $this->load->view('admin/ebook', $data);
    }
   
  
}