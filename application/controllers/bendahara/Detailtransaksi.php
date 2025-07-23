<?php

class Detailtransaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Pembayaransiswa_Model');
        $this->load->model('auth_admin');
        $this->load->library('pagination');
        $this->load->library('upload');
        
        $current_user = $this->auth_admin->current_user();
        if (!$current_user) {
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginbendahara');
        }
        if ($current_user->role != 'bendahara') {
            $error_msg = 'Anda tidak diizinkan mengakses resources ini';
            show_error($error_msg, 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $logo_data = $this->admin->get_logo();
        $data['current_user']       = $this->auth_admin->current_user(); 
        $data['logo']               = $logo_data['logo'];
        $data['profilsekolah']      = $this->admin->get_profilsekolah_data(); 
        $data['historypembayaran']  = $this->Pembayaransiswa_Model->get_detailpembayaran(); 
    
        // Hitung total pembayaran
        $total_pembayaran = 0;
        foreach ($data['historypembayaran'] as $history) {
            $total_pembayaran += $history['jumlah_pembayaran'];
        }
        $data['jumlah_pembayaran'] = $total_pembayaran;


        // Load view dengan data yang telah diproses
        $this->load->view('bendahara/detailtransaksi', $data);
    }

    public function hapus_pembayaran($pembayaran_id) {
        $result = $this->Pembayaransiswa_Model->hapus_pembayaran($pembayaran_id); 
        if ($result) {
            $this->session->set_flashdata('success_message', 'Pembayaran berhasil batalkan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus pembayaran.');
        }
        redirect('bendahara/detailtransaksi');
    }

    
   
}
