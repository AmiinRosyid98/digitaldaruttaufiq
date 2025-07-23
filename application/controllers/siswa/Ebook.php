<?php

class Ebook extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_siswa');
		$this->load->model('Pesertadidik');
		$this->load->library('pagination');
		if(!$this->auth_siswa->current_user()){
			redirect('auth/loginsiswa');
		}
	}
    


	public function index()
	{
		$current_user = $this->auth_siswa->current_user(); 

		if ($current_user) { 
			// Jika ada user yang sedang login
			$siswa_kode_kelas 		= $current_user->kode_kelas; // Mengambil kode_kelas dari objek current_user
			$data['current_user'] 	= $current_user; // Data current_user untuk ditampilkan di view
			$data['profilsekolah'] 	= $this->Pesertadidik->get_perusahaan_data(); // Mendapatkan data profil sekolah dari model
			$data['buku'] 			= $this->Pesertadidik->get_buku_by_siswa_kode_kelas($siswa_kode_kelas); // Mendapatkan data buku berdasarkan kode_kelas siswa
		
			// Memuat view 'siswa/buku' dengan data yang telah dikumpulkan
			$this->load->view('siswa/buku', $data);
		} else {
			// Jika tidak ada user yang sedang login, redirect ke halaman login siswa
			redirect('auth/loginsiswa');
		}
	}




}