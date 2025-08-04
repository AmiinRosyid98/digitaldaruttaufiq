<?php

class Tagihan extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_siswa');
		$this->load->model('Pesertadidik');
		$this->load->model('Kelas_Model'); 
		$this->load->model('Poskeuangan_Model'); 
		$this->load->library('pagination');
        $this->load->helper('tripay');
		
		// $this->load->library('encryption');

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

            $data['kelas']              = $this->Kelas_Model->get_kelas_by_no($current_user->kode_kelas);
			


			$this->load->view('siswa/tagihan', $data);
		} else {
			redirect('auth/loginsiswa');
		}
	}

	public function transfer($id)
	{

		$decoded = urldecode($id); // atau segment URL
		$decrypted = $this->encryption->decrypt($decoded);
		// var_dump($decrypted);die;

		$id_pembayaran = $decrypted;
		
		$current_user = $this->auth_siswa->current_user(); 
		if ($current_user) { 
			
			$cek_sudah_baya = $this->db->select('*')
										->from('transaksi n')
										->where(" n.id_pembayaran = $id_pembayaran
												AND n.id_siswa = ".$current_user->id_siswa."
												AND (status = 'UNPAID' OR status = 'PAID')
												AND n.id_kelas = '".$current_user->kode_kelas."' ")
										->order_by("n.id", "DESC")
										->limit(1)->get();
			if($cek_sudah_baya->num_rows()>0){
				$data['pilihpembayaran'] = "sudah";
				$data['detailmethod'] = $cek_sudah_baya->row();
			} else {
				$data['pilihpembayaran'] = "belum";
				$data['detailmethod']	= "";
			}

			

			$id_siswa 			   	   = $current_user->id_siswa; 
			$data['current_user']      = $current_user; 
			$data['profilsekolah']     = $this->Pesertadidik->get_perusahaan_data(); 
			$data['pembayaran'] 	   = $this->Pesertadidik->get_pembayaran($id_siswa);
            $data['kelas']              = $this->Kelas_Model->get_kelas_by_no($current_user->kode_kelas);
			$data['tarifpembayaran']   = $this->Poskeuangan_Model->get_tarifpembayaran_by_id($id_pembayaran);
			$data['va']   				= $this->Poskeuangan_Model->get_metode_pembayaran("va");
			$data['retail']   			= $this->Poskeuangan_Model->get_metode_pembayaran("retail");
			$data['ewallet']   			= $this->Poskeuangan_Model->get_metode_pembayaran("ewallet");
			$data['qris']   			= $this->Poskeuangan_Model->get_metode_pembayaran("qris");
			

		


			$this->load->view('siswa/transfer', $data);
		} else {
			redirect('auth/loginsiswa');
		}
	}



}