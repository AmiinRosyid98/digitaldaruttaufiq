<?php

class Elearning extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_siswa');
		$this->load->model('Pesertadidik');
		$this->load->library('pagination');
		$this->load->helper('text'); // ✅ Tambahkan ini untuk fungsi character_limiter

		if (!$this->auth_siswa->current_user()) {
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
			$data['materi'] 		= $this->Pesertadidik->get_materi_by_kode_kelas($siswa_kode_kelas);

			// Memuat view 'siswa/buku' dengan data yang telah dikumpulkan
			$this->load->view('siswa/elearning', $data);
		} else {
			// Jika tidak ada user yang sedang login, redirect ke halaman login siswa
			redirect('auth/loginsiswa');
		}
	}


	public function detail_materi($id_materi)
	{
		$current_user = $this->auth_siswa->current_user();
		if (!$current_user) {
			redirect('auth/loginsiswa');
		}

		// Ambil data materi
		$this->load->model('Pesertadidik');
		$data['current_user'] 	= $current_user;
		$data['profilsekolah'] 	= $this->Pesertadidik->get_perusahaan_data(); // Mendapatkan data profil sekolah dari model
		$data['materi'] 		= $this->Pesertadidik->get_materi_detail($id_materi);
		$data['tugas'] 			= $this->Pesertadidik->get_tugas_by_materi($id_materi);

		if (!$data['materi']) {
			show_404();
		}

		$this->load->view('siswa/detail_materi', $data);
	}


	public function detail_tugas($id_tugas)
	{
		$current_user = $this->auth_siswa->current_user();
		if (!$current_user) {
			redirect('auth/loginsiswa');
		}

		$siswa = $this->auth_siswa->current_user();
		$data['current_user'] = $current_user;
		$data['profilsekolah'] = $this->Pesertadidik->get_perusahaan_data();
		$data['tugas'] = $this->Pesertadidik->get_tugas_detail($id_tugas);
		$data['soal_pg'] = $this->Pesertadidik->get_soal_pg($id_tugas);
		$data['jawaban_pg'] = $this->Pesertadidik->get_jawaban_pg($siswa->id_siswa, $id_tugas);
		$data['jawaban'] = $this->Pesertadidik->get_jawaban_siswa($id_tugas, $siswa->id_siswa);

		// Hitung nilai jika sudah dikerjakan
		$data['nilai'] = 0;
		$data['total_soal'] = count($data['soal_pg']);
		$data['jawaban_benar'] = 0;

		if (!empty($data['jawaban_pg']) && !empty($data['soal_pg'])) {
			foreach ($data['soal_pg'] as $soal) {
				if (
					isset($data['jawaban_pg'][$soal['id_soal']]) &&
					$data['jawaban_pg'][$soal['id_soal']] === $soal['jawaban_benar']
				) {
					$data['jawaban_benar']++;
				}
			}
			$data['nilai'] = ($data['jawaban_benar'] / $data['total_soal']) * 100;
		}

		$data['sudah_terkirim'] = !empty($data['jawaban_pg']) || !empty($data['jawaban']);


		$this->load->view('siswa/tugas_detail', $data);
	}

	public function simpan_jawaban()
	{
		$siswa = $this->auth_siswa->current_user();
		if (!$siswa) {
			redirect('auth/loginsiswa');
		}

		$id_tugas = $this->input->post('id_tugas');

		// Iterasi melalui setiap soal dan simpan jawaban siswa
		foreach ($_POST as $key => $value) {
			if (strpos($key, 'jawaban_') === 0) {
				$id_soal = str_replace('jawaban_', '', $key);  // Mendapatkan ID soal
				$this->Pesertadidik->simpan_jawaban_pg($siswa->id_siswa, $id_soal, $value); // Simpan jawaban
			}
		}

		// Setelah berhasil menyimpan, bisa redirect atau memberikan notifikasi
		$this->session->set_flashdata('message', 'Jawaban berhasil disimpan.');
		redirect('siswa/elearning/detail_tugas/' . $id_tugas);
	}



	public function upload_jawabannn()
	{
		$id_tugas  = $this->input->post('id_tugas');
		$id_siswa  = $this->auth_siswa->current_user()->id_siswa;

		// Siapkan data awal
		$data = [
			'id_tugas' => $id_tugas,
			'id_siswa' => $id_siswa,
			'tanggal_upload' => date('Y-m-d H:i:s')
		];

		// Cek apakah ada file yang diunggah
		if (!empty($_FILES['file_jawaban']['name'])) {
			$config['upload_path']   = './upload/jawaban/';
			$config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png|zip';
			$config['max_size']      = 5048; // maksimal 5MB
			$config['file_name']     = 'Jawaban_' . $id_siswa . '_' . date('YmdHis');

			// Inisialisasi dan konfigurasi upload
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('file_jawaban')) {
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];

				$data['file_jawaban'] = $file_name;

				// Simpan ke database melalui model
				$this->Pesertadidik->simpan_jawaban($data);

				$this->session->set_flashdata('success', 'Jawaban berhasil diupload.');
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('error', 'Gagal mengunggah file: ' . $error);
			}
		} else {
			$this->session->set_flashdata('error', 'Silakan pilih file jawaban untuk diunggah.');
		}

		redirect('siswa/elearning/detail_tugas/' . $id_tugas);
	}

	public function upload_jawaban()
	{
		$id_tugas  = $this->input->post('id_tugas');
		$id_siswa  = $this->auth_siswa->current_user()->id_siswa;
		$isi_jawaban = $this->input->post('isi_jawaban');

		$data = [
			'id_tugas' => $id_tugas,
			'id_siswa' => $id_siswa,
			'tanggal_upload' => date('Y-m-d H:i:s'),
			'isi_jawaban' => $isi_jawaban ?: null
		];

		$upload_success = false;

		if (!empty($_FILES['file_jawaban']['name'])) {
			$config['upload_path']   = './upload/jawaban/';
			$config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png|zip';
			$config['max_size']      = 5048; // 5MB
			$config['file_name']     = 'Jawaban_' . $id_siswa . '_' . date('YmdHis');

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('file_jawaban')) {
				$upload_data = $this->upload->data();
				$data['file_jawaban'] = $upload_data['file_name'];
				$upload_success = true;
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('error', 'Gagal mengunggah file: ' . $error);
				redirect('siswa/elearning/detail_tugas/' . $id_tugas);
				return;
			}
		}

		// Validasi: minimal salah satu harus diisi
		if (empty($data['file_jawaban']) && empty($isi_jawaban)) {
			$this->session->set_flashdata('error', 'Silakan isi jawaban atau unggah file terlebih dahulu.');
			redirect('siswa/elearning/detail_tugas/' . $id_tugas);
			return;
		}

		// Simpan ke database
		$this->Pesertadidik->simpan_jawaban($data);
		$this->session->set_flashdata('success', 'Jawaban berhasil dikirim.');
		redirect('siswa/elearning/detail_tugas/' . $id_tugas);
	}
}
