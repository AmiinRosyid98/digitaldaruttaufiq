<?php

class Profile extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('auth_admin');
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

	public function updateprofil()
    {
       
        $logo_data = $this->admin->get_logo(); // Mengirim data logo ke view
        $data['logo'] = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['current_user'] = $this->auth_admin->current_user(); // Tampilkan halaman profil dengan informasi pengguna saat ini
      
       

        $this->load->view('admin/profile', $data);
    }




    public function updatedataprofile()
    {
        // Ambil ID pengguna yang sedang login
        $user_id = $this->auth_admin->current_user()->id;
        
        // Ambil data yang dikirim melalui formulir update profil
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            // Tambahkan kolom lain yang ingin Anda update
        );

         // Periksa apakah ada perubahan pada password
        $new_password = $this->input->post('password');
        if (!empty($new_password)) {
            // Jika ada perubahan, hash password baru
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $data['password'] = $hashed_password;
        }


    
        
        // Panggil fungsi update_profile dari model Admin untuk melkaukan update data profil
        $update_result = $this->admin->update_profile($user_id, $data);
        
        if ($update_result) {
            // Jika proses update berhasil, redirect ke halaman profil
        	redirect('admin/profile/updateprofil?success=Data telah berhasil diperbaharui');
        } else {
            // Jika proses update gagal, tampilkan pesan error atau redirect ke halaman tertentu
            redirect('admin/profile/updateprofil?error=Tidak ada data yang di perbaharui');
        }
    }



    public function update_avatar() {
        // Tentukan direktori untuk menyimpan avatar
        $upload_path = './assets/admin/profile/';
    
        // Dapatkan ID pengguna yang sedang login
        $user_id = $this->auth_admin->current_user()->id;
    
        // Konfigurasi upload gambar
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // Maksimum 2MB
        $config['file_name'] = $user_id . '_' . $_FILES['avatar']['name']; // Nama file dengan format ID_pengguna_nama_file
        // Konfigurasi lainnya jika diperlukan
    
        // Inisialisasi konfigurasi upload
        $this->upload->initialize($config);
    
        // Lakukan proses upload
        if ($this->upload->do_upload('avatar')) {
            // Jika upload berhasil, ambil data file
            $upload_data = $this->upload->data();
    
            // Simpan nama file ke dalam database
            $this->admin->update_avatar($user_id, $config['file_name']);
    
            // Redirect ke halaman profil atau tampilkan pesan sukses
            $this->session->set_flashdata('success', 'Avatar berhasil diperbarui.');
            redirect('admin/profile/updateprofil');
        } else {
            // Jika upload gagal, tampilkan pesan error
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect('admin/profile/updateprofil');
        }
    }
    
    
   

  
}