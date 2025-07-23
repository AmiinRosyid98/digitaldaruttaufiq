<?php

class Manajemenpengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Manajemenpengguna_Model');
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
        $logo_data                  = $this->admin->get_logo();
        $data['logo']               = $logo_data['logo'];
        $data['current_user']       = $this->auth_admin->current_user();
        $data['manajemenpengguna']  = $this->Manajemenpengguna_Model->get_pengguna();
        $data['profilsekolah']      = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/manajemenpengguna', $data);
    }

    public function get_pengguna()
    {
        $pengguna_id   = $this->input->get('pengguna_id');
        $pengguna      = $this->Manajemenpengguna_Model->get_pengguna_by_id($pengguna_id);
        echo json_encode(array('pengguna' => $pengguna));
    }



    public function simpan_pengguna()
    {
        $name       = $this->input->post('name');
        $email      = $this->input->post('email');
        $username   = $this->input->post('email');
        $password   = $this->input->post('password');
        $role       = $this->input->post('role');
        $avatar     = $this->input->post('avatar');
        $created_at = $this->input->post('created_at');

        $existing_pengguna = $this->Manajemenpengguna_Model->get_kelas_by_email($email);
        if ($existing_pengguna) {
            $this->session->set_flashdata('error_message', 'Email Pengguna sudah Tersedia. Silakan gunakan Email lain.');
            redirect('admin/manajemenpengguna');
            return;
        }

        // Hash password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_data = array(
            'name'          => $name,
            'email'         => $email,
            'password'      => $hashed_password,
            'role'        => $role,
            'avatar'        => $avatar,
            'created_at'    => $created_at,
            'username'      => $username,

        );
        $insert_result = $this->Manajemenpengguna_Model->simpan_pengguna($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Pengguna berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Pengguna.');
        }
        redirect('admin/manajemenpengguna');
    }

    public function update_pengguna()
    {
        $pengguna_id    = $this->input->post('editPenggunaId');
        $data           = array(
            'name'      => $this->input->post('editNamaPengguna'),
            'username'  => $this->input->post('editUserPengguna'),
            'email'     => $this->input->post('editEmailPengguna')
        );

        $password = $this->input->post('editPasswordPengguna');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT); // Menggunakan password_hash untuk keamanan
        }

        $result = $this->Manajemenpengguna_Model->update_pengguna($pengguna_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Pengguna berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Pengguna');
            echo json_encode(array('success' => false));
        }
    }




    public function hapus_pengguna($pengguna_id)
    {
        $result = $this->Manajemenpengguna_Model->hapus_pengguna($pengguna_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Pengguna berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Pengguna.');
        }
        redirect('admin/manajemenpengguna');
    }
}
