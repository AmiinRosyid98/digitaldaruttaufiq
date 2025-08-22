<?php

class Akun extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->model('admin');
		$this->load->model('auth_siswa');
		$this->load->model('Siswa_Model');
		$this->load->model('Pesertadidik');
		$this->load->model('Kelas_Model'); 
        $this->load->model('auth_admin');

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
			
			$logo_data = $this->admin->get_logo();
            $siswa_data = $this->Siswa_Model->get_siswa_by_id($id_siswa);
            $data['logo']           = $logo_data['logo'];
            $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
            $data['current_user']      = $current_user; 

            $data['kelas']          = $this->Kelas_Model->get_kelas();
            $data['siswa']          = $siswa_data;
            $this->load->view('siswa/akun', $data);
		} else {
			redirect('auth/loginsiswa');
		}

        
    }

    public function updatedatadirisiswa()
    {
        $siswa_id = $this->input->post('editSiswaId');
        $data = array(
            'nama_siswa'        => $this->input->post('editNamaSiswa'),
            'jeniskelamin'      => $this->input->post('editJeniskelamin'),
            'agama'             => $this->input->post('editAgama'),
            'tempatlahir'       => $this->input->post('editTempatlahir'),
            'tanggallahir'      => $this->input->post('editTanggallahir'),
            'siswa_alamat'      => $this->input->post('editSiswaAlamat'),
            'siswa_kelurahan'   => $this->input->post('editSiswaKelurahan'),
            'siswa_kecamatan'   => $this->input->post('editSiswaKecamatan'),
            'siswa_kabupaten'   => $this->input->post('editSiswaKabupaten'),
            'siswa_provinsi'    => $this->input->post('editSiswaProvinsi'),
            'nohp'              => $this->input->post('editNohp'),
            'email'             => $this->input->post('editSiswaemail')
        );

        $result = $this->Siswa_Model->update_siswa($siswa_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Diri Siswa berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Diri Siswa');
        }
        redirect(base_url('siswa/akun') . '#datadiri');
    }



    public function updatedataayah()
    {
        $siswa_id = $this->input->post('editSiswaId');
        $data = array(
            'ayah_nama'         => $this->input->post('editNamayah'),
            'ayah_agama'        => $this->input->post('editAgamaayah'),
            'ayah_nik'          => $this->input->post('editNikayah'),
            'ayah_status'       => $this->input->post('editStatusayah'),
            'ayah_tanggallahir' => $this->input->post('editTanggallahirayah'),
            'ayah_tempatlahir'  => $this->input->post('editTempatlahirayah'),
            'ayah_alamat'       => $this->input->post('editAlamatayah'),
            'ayah_desakel'      => $this->input->post('editKelurahanayah'),
            'ayah_kecamatan'    => $this->input->post('editKecamatanayah'),
            'ayah_kabupaten'    => $this->input->post('editKabupatenayah'),
            'ayah_provinsi'     => $this->input->post('editProvinsiayah'),
            'ayah_pekerjaan'    => $this->input->post('editPekerjaanayah'),
            'ayah_penghasilan'  => $this->input->post('editPendapatanayah'),
            'ayah_nohp'         => $this->input->post('editTelpayah')
        );

        $result = $this->Siswa_Model->update_siswa($siswa_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Ayah Siswa berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Ayah Siswa');
        }
        redirect(base_url('siswa/akun') . '#dataayah');
    }

    public function updatedataibu()
    {
        $siswa_id = $this->input->post('editSiswaId');
        $data = array(
            'ibu_nama'         => $this->input->post('editNamaibu'),
            'ibu_agama'        => $this->input->post('editAgamaibu'),
            'ibu_nik'          => $this->input->post('editNikibu'),
            'ibu_status'       => $this->input->post('editStatusibu'),
            'ibu_tanggallahir' => $this->input->post('editTanggallahiribu'),
            'ibu_tempatlahir'  => $this->input->post('editTempatlahiribu'),
            'ibu_alamat'       => $this->input->post('editAlamatibu'),
            'ibu_desakel'      => $this->input->post('editKelurahanibu'),
            'ibu_kecamatan'    => $this->input->post('editKecamatanibu'),
            'ibu_kabupaten'    => $this->input->post('editKabupatenibu'),
            'ibu_provinsi'     => $this->input->post('editProvinsiibu'),
            'ibu_pekerjaan'    => $this->input->post('editPekerjaanibu'),
            'ibu_penghasilan'  => $this->input->post('editPendapatanibu'),
            'ibu_nohp'         => $this->input->post('editTelpibu')
        );

        $result = $this->Siswa_Model->update_siswa($siswa_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Ibu Siswa berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Ibu Siswa');
        }
        redirect(base_url('siswa/akun') . '#dataibu');
    }

    public function updatedatalainnya()
    {
        $siswa_id = $this->input->post('editSiswaId');
        
        // Get all sibling data from the form
        $hubunganSaudara = $this->input->post('editHubunganSaudara');
        $namaSaudara = $this->input->post('editNamaSaudara');
        $usiaSaudara = $this->input->post('editUsiaSaudara');
        
        $saudaraData = array();
        
        // Process each sibling's data
        if (!empty($hubunganSaudara) && is_array($hubunganSaudara)) {
            foreach ($hubunganSaudara as $index => $hubungan) {
                // Skip if name is empty
                if (empty(trim($namaSaudara[$index]))) {
                    continue;
                }
                
                $saudaraData[] = array(
                    'hub' => $hubungan,
                    'nama' => $namaSaudara[$index],
                    'usia' => isset($usiaSaudara[$index]) ? $usiaSaudara[$index] : ''
                );
            }
        }
        
        // Prepare data for update
        $data = array(
            'saudara' => !empty($saudaraData) ? json_encode($saudaraData) : null
        );

        $result = $this->Siswa_Model->update_siswa($siswa_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data saudara berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data saudara');
        }
        redirect(base_url('siswa/akun') . '#datalainnya');
    }
    public function cetakbukuinduk($siswa_id)
    {
        require_once APPPATH . 'third_party/tcpdf/tcpdf.php';
        $this->load->model('Siswa_Model');
        $siswa = $this->Siswa_Model->get_siswa_by_id($siswa_id);
        $pdfContent = $this->load->view('admin/cetak/bukuinduk_siswa', ['siswa' => $siswa], true);
        $pdf = new TCPDF('L', 'pt', ['format' => 'A3', 'Rotate' => 260]);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Anonymous Code');
        $pdf->SetTitle($siswa['nama_kelas'] . '-' . $siswa['no_absen'] . '-' . $siswa['nama_siswa']); // Mengatur judul PDF menjadi nama siswa
        $pdf->SetSubject($siswa['nama_siswa']);
        $pdf->SetKeywords('TCPDF, PDF, data siswa');
        $pdf->SetMargins(0, 2, 0, true);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->AddPage();
        $pdf->writeHTML($pdfContent, true, false, true, false, '');
        $pdf->Output($siswa['nama_kelas'] . '-' . $siswa['no_absen'] . '-' . $siswa['nama_siswa'] . '.pdf', 'I');
    }
}