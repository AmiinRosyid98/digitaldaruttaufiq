<?php

class Pembayaransiswa extends CI_Controller
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
        // Ambil data logo, pengguna saat ini, dan profil sekolah
        $logo_data = $this->admin->get_logo();
        $data['current_user']   = $this->auth_admin->current_user(); 
        $data['logo']           = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data(); 
        // Ambil semua kelas untuk pilihan filter
        $data['kelas']          = $this->Pembayaransiswa_Model->get_kelas();
        $data['poskeuangan']    = $this->Pembayaransiswa_Model->get_poskeuangan();
        $data['tahunpelajaran'] = $this->Pembayaransiswa_Model->get_tahunpelajaran();
    



        // Ambil parameter dari input
        $selected_kelas          = $this->input->get('kelas');
        $selected_poskeuangan    = $this->input->get('poskeuangan');
        $selected_tahunpelajaran = $this->input->get('tahunpelajaran');
    
        // Jika ada pencarian NIS
        $selected_nis = $this->input->get('nis');
        if (!empty($selected_nis)) {
            $data['siswa'] = $this->Pembayaransiswa_Model->get_siswa_by_nis($selected_nis, $selected_tahunpelajaran);
        } else {
            // Filter berdasarkan kelas dan pos keuangan
            $data['siswa'] = $this->Pembayaransiswa_Model->filter_siswa_by_kelas_dan_poskeuangan($selected_kelas, $selected_poskeuangan, $selected_tahunpelajaran );
        }
        
        
         // Dapatkan jumlah pembayaran untuk setiap siswa
        foreach ($data['siswa'] as &$siswa_item) {
            $siswa_item['jumlah_pembayaran'] = $this->Pembayaransiswa_Model->get_jumlah_pembayaran_by_id_siswa($siswa_item['id_siswa']);
        }


        // Simpan data filter untuk digunakan kembali di view
        $data['selected_kelas']             = $selected_kelas;
        $data['selected_poskeuangan']       = $selected_poskeuangan;
        $data['selected_tahunpelajaran']    = $selected_tahunpelajaran;
        $data['selected_nis']               = $selected_nis;
    
        // Load view dengan data yang telah diproses
        $this->load->view('bendahara/pembayaransiswa', $data);
    }

    public function simpan_pembayaran()
    {
        $id_siswa                   = $this->input->post('id_siswa');
        $nama_tipepembayaran        = $this->input->post('id_tipepembayaran');
        $id_pos                     = $this->input->post('id_pos');
        $id_pembayaran              = $this->input->post('id_pembayaran');
        $id_tahunpelajaran          = $this->input->post('kode_tahunpelajaran');
        $id_kelas                   = $this->input->post('kode_kelas');
        $statuspembayaran           = $this->input->post('statuspembayaran');
        $jumlah_tarif               = $this->input->post('jumlah_tarif');
        $jumlah_pembayaran          = $this->input->post('jumlah_pembayaran');
        $tanggal_pembayaran         = $this->input->post('tanggal_pembayaran');

        // Menghapus format rupiah dari jumlah_pembayaran
        $jumlah_pembayaran_clean = preg_replace('/\D/', '', $jumlah_pembayaran);


        $data = array(
            'id_siswa'              => $id_siswa,
            'nama_tipepembayaran'   => $nama_tipepembayaran,
            'id_pos'                => $id_pos,
            'id_pembayaran'         => $id_pembayaran,
            'id_tahunpelajaran'     => $id_tahunpelajaran,
            'id_kelas'              => $id_kelas,
            'statuspembayaran'      => $statuspembayaran,
            'jumlah_tarif'          => $jumlah_tarif,
            'jumlah_pembayaran'     => $jumlah_pembayaran_clean,
            'tanggal_pembayaran'    => $tanggal_pembayaran,
            'created_at'            => date('Y-m-d H:i:s')
        );
        
        $this->Pembayaransiswa_Model->simpan_pembayaran($data);
        
        $this->session->set_flashdata('success_message', 'Pembayaran berhasil dicatat.');
        redirect('bendahara/detailtransaksi');
    }
}
