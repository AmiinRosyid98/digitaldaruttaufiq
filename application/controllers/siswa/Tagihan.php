<?php

class Tagihan extends CI_Controller
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
			
			$id_siswa 			   	   = $current_user->id_siswa; 
			$data['current_user']      = $current_user; 
			$data['profilsekolah']     = $this->Pesertadidik->get_perusahaan_data(); 
			$data['pembayaran'] 	   = $this->Pesertadidik->get_pembayaran($id_siswa);

		


			$this->load->view('siswa/tagihan', $data);
		} else {
			redirect('auth/loginsiswa');
		}
	}



}