<?php

class Profile extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('member');
        $this->load->model('auth_member');
        $this->load->library('upload');
        // Pastikan pengguna sudah terotentikasi untuk mengakses profil
        if (!$this->auth_member->current_user()) {
            redirect('auth/loginmember');
        }
    }

	public function index()
    {
        // Tampilkan halaman profil dengan informasi pengguna saat ini
        $data['current_user'] = $this->auth_member->current_user();
        // Ambil data perusahaan
		$data['perusahaan'] = $this->member->get_perusahaan_data();

        $this->load->view('member/profile', $data);
    }


    public function update()
    {
        // Ambil ID pengguna yang sedang login
        $user_id = $this->auth_member->current_user()->id;
        
        // Ambil data yang dikirim melalui formulir update profil
        $data = array(
            'name'          => $this->input->post('name'),
            'nama_lembaga'  => $this->input->post('nama_lembaga'),
            'alamat'        => $this->input->post('alamat'),
            'provinsi'      => $this->input->post('provinsi'),
            'kabupaten'     => $this->input->post('kabupaten'),
            'kecamatan'     => $this->input->post('kecamatan'),
            'notelp'        => $this->input->post('notelp'),
            'jagung'        => $this->input->post('jagung'),
            'konsentrat'    => $this->input->post('konsentrat'),
            'dedak'         => $this->input->post('dedak'),
            'takaran_pakan' => $this->input->post('takaran_pakan'),
            'kg_jagung'     => $this->input->post('kg_jagung'),
            'kg_konsentrat' => $this->input->post('kg_konsentrat'),
            'kg_dedak'      => $this->input->post('kg_dedak'),
            'harga_jual'    => $this->input->post('harga_jual'),
            // Tambahkan kolom lain yang ingin Anda update
        );

         // Periksa apakah ada perubahan pada password
        $new_password = $this->input->post('password');
        if (!empty($new_password)) {
            // Jika ada perubahan, hash password baru
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $data['password'] = $hashed_password;
        }


    
        
        // Panggil fungsi update_profile dari model Member untuk melkaukan update data profil
        $update_result = $this->member->update_profile($user_id, $data);
        
        if ($update_result) {
            // Jika proses update berhasil, redirect ke halaman profil
        	redirect('member/profile?success=Data telah berhasil diperbaharui');
        } else {
            // Jika proses update gagal, tampilkan pesan error atau redirect ke halaman tertentu
            redirect('member/profile?error=Tidak ada data yang di perbaharui');
        }
    }



    public function update_avatar() {
        // Tentukan direktori untuk menyimpan avatar
        $upload_path = './assets/member/profile/';
    
        // Dapatkan ID pengguna yang sedang login
        $user_id = $this->auth_member->current_user()->id;
    
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
            $this->member->update_avatar($user_id, $config['file_name']);
    
            // Redirect ke halaman profil atau tampilkan pesan sukses
            $this->session->set_flashdata('success', 'Avatar berhasil diperbarui.');
            redirect('member/profile');
        } else {
            // Jika upload gagal, tampilkan pesan error
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect('member/profile');
        }
    }
    
    

	
  
}