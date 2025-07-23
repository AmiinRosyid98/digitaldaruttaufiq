<?php

class Arsipguru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Arsipguru_Model');
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
        $kategori = $this->input->get('kategori'); // Tangkap filter dari form GET

        $logo_data = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['current_user']   = $this->auth_admin->current_user();
        $data['arsip']          = $this->Arsipguru_Model->get_arsip($kategori); // Kirim filter ke model
        $data['arsiptimeline']  = $this->Arsipguru_Model->get_arsiptimeline();
        $data['selected_kategori'] = $kategori;

        $this->load->view('admin/arsipguru', $data);
    }
}
