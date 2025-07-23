<?php

class Absensi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_siswa');
		$this->load->model('Pesertadidik');
		$this->load->model('Absensi_Model');
		$this->load->library('pagination');
		if (!$this->auth_siswa->current_user()) {
			redirect('auth/loginsiswa');
		}
	}

	public function index()
	{
		$current_user = $this->auth_siswa->current_user();

		if ($current_user) {
			$data['current_user'] = $current_user;
			$data['profilsekolah'] = $this->Pesertadidik->get_perusahaan_data();
			$data['absensi_harian'] = $this->Absensi_Model->get_absensi_harian($current_user->id_siswa, date('Y-m-d'));

			// Mengambil batas waktu absen masuk dan absen pulang dari model
			$data['batas_waktu_absen_masuk'] = $this->Absensi_Model->get_batas_waktu_absen_masuk();
			$data['batas_waktu_absen_pulang'] = $this->Absensi_Model->get_batas_waktu_absen_pulang();

			$this->load->view('siswa/absensi', $data);
		} else {
			redirect('auth/loginsiswa');
		}
	}


	public function submit_absensi()
	{
		$current_user = $this->auth_siswa->current_user();

		if ($current_user) {

			// Validasi input menggunakan form_validation CodeIgniter
			$this->load->library('form_validation');
			$this->form_validation->set_rules('latitude', 'Latitude', 'required|numeric');
			$this->form_validation->set_rules('longitude', 'Longitude', 'required|numeric');


			// Periksa apakah pengguna sudah melakukan absen hari ini
			$tanggal_absen_terakhir = $this->Absensi_Model->get_tanggal_absen_terakhir($current_user->id_siswa);

			// Ubah format tanggal sesuai dengan format timestamp yang digunakan
			$today_timestamp = date('Y-m-d H:i:s');

			if ($tanggal_absen_terakhir && date('Y-m-d', strtotime($tanggal_absen_terakhir)) == date('Y-m-d', strtotime($today_timestamp))) {
				// Pengguna sudah melakukan absen hari ini, berikan pesan error
				$this->session->set_flashdata('error', 'Anda sudah melakukan absen hari ini.');
				redirect('siswa/absensi');
			}


			if ($this->form_validation->run() == FALSE) {
				// Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
				$this->session->set_flashdata('error', validation_errors());
				redirect('siswa/absensi');
			}

			// Mendapatkan data batas waktu absen dan lokasi dari model
			$template_absensi = $this->Absensi_Model->get_batas_waktu_absen_masuk(); // Misalnya, ambil dari batas waktu masuk

			// Mengambil nilai latitude, longitude, dan radius_absen dari templateabsensi
			$latitude_template = $template_absensi['latitude'];
			$longitude_template = $template_absensi['longitude'];
			$radius_absen = $template_absensi['radius_absen'];

			// Mendapatkan latitude dan longitude yang diinput dari form
			$latitude_input = $this->input->post('latitude');
			$longitude_input = $this->input->post('longitude');

			// Menghitung jarak menggunakan rumus Haversine
			$distance = $this->haversineDistance($latitude_template, $longitude_template, $latitude_input, $longitude_input);

			// Memeriksa apakah jarak lebih besar dari radius absen
			if ($distance > $radius_absen) {
				// Jika di luar radius absen, tidak diizinkan absen
				$this->session->set_flashdata('error', 'Anda berada di luar radius absen yang ditentukan.');
				redirect('siswa/absensi');
			}

			// Jika dalam radius absen, lanjutkan proses absen
			// Menentukan jenis absen berdasarkan batas waktu
			$batas_waktu_absen_masuk = $this->Absensi_Model->status_absen_masuk();
			$batas_waktu_absen_pulang = $this->Absensi_Model->status_absen_pulang();
			$current_time = date('H:i:s');

			if (strtotime($current_time) > strtotime($batas_waktu_absen_pulang)) {
				$absen = 'Pulang'; // Absen pulang
			} elseif (strtotime($current_time) < strtotime($batas_waktu_absen_masuk)) {
				$absen = 'Masuk'; // Absen masuk
			} else {
				// Berada di antara batas waktu masuk dan pulang
				// Sesuaikan logika sesuai kebutuhan
				$absen = 'Telat'; // Dianggap telat
			}

			// Data absensi yang akan disimpan
			$data = array(
				'id_siswa'  => $current_user->id_siswa,
				'timestamp' => date('Y-m-d H:i:s'),
				'absen'     => $absen,
				'latitude'  => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude')
			);

			// Simpan data absensi menggunakan model
			$this->Absensi_Model->submit_absensi($data);

			// Set flashdata untuk pesan sukses
			$this->session->set_flashdata('success', 'Absensi berhasil disimpan.');
			redirect('siswa/absensi');
		} else {
			// Jika pengguna tidak terotentikasi, redirect ke halaman login siswa
			redirect('auth/loginsiswa');
		}
	}


	public function submit_absensi_qr()
	{
		$current_user = $this->auth_siswa->current_user();

		if ($current_user) {

			// Mendapatkan data QR code dari input
			$qr_code = $this->input->post('qr_code');

			// Verifikasi QR code dengan id_siswa
			if ($qr_code != $current_user->id_siswa) {
				$this->session->set_flashdata('error', 'QR Code tidak valid.');
				redirect('siswa/absensi');
			}

			// Periksa apakah pengguna sudah melakukan absen hari ini
			$tanggal_absen_terakhir = $this->Absensi_Model->get_tanggal_absen_terakhir($current_user->id_siswa);

			// Ubah format tanggal sesuai dengan format timestamp yang digunakan
			$today_timestamp = date('Y-m-d H:i:s');

			if ($tanggal_absen_terakhir && date('Y-m-d', strtotime($tanggal_absen_terakhir)) == date('Y-m-d', strtotime($today_timestamp))) {
				// Pengguna sudah melakukan absen hari ini, berikan pesan error
				$this->session->set_flashdata('error', 'Anda sudah melakukan absen hari ini.');
				redirect('siswa/absensi');
			}

			// Menentukan jenis absen berdasarkan batas waktu
			$batas_waktu_absen_masuk = $this->Absensi_Model->status_absen_masuk();
			$batas_waktu_absen_pulang = $this->Absensi_Model->status_absen_pulang();
			$current_time = date('H:i:s');

			if (strtotime($current_time) > strtotime($batas_waktu_absen_pulang)) {
				$absen = 'Pulang'; // Absen pulang
			} elseif (strtotime($current_time) < strtotime($batas_waktu_absen_masuk)) {
				$absen = 'Masuk'; // Absen masuk
			} else {
				// Berada di antara batas waktu masuk dan pulang
				// Sesuaikan logika sesuai kebutuhan
				$absen = 'Telat'; // Dianggap telat
			}

			// Data absensi yang akan disimpan
			$data = array(
				'id_siswa'  => $current_user->id_siswa,
				'timestamp' => date('Y-m-d H:i:s'),
				'absen'     => $absen
			);

			// Simpan data absensi menggunakan model
			$this->Absensi_Model->submit_absensi($data);

			// Set flashdata untuk pesan sukses
			$this->session->set_flashdata('success', 'Absensi berhasil disimpan.');
			redirect('siswa/absensi');
		} else {
			// Jika pengguna tidak terotentikasi, redirect ke halaman login siswa
			redirect('auth/loginsiswa');
		}
	}

	private function haversineDistance($lat1, $lon1, $lat2, $lon2)
	{
		// Haversine formula to calculate distance between two points given their latitude and longitude
		$earth_radius = 6371; // Radius of the Earth in kilometers

		// Convert latitude and longitude from degrees to radians
		$dLat = deg2rad($lat2 - $lat1);
		$dLon = deg2rad($lon2 - $lon1);

		// Calculate the distance using Haversine formula
		$a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$distance = $earth_radius * $c;

		return $distance;
	}
}
