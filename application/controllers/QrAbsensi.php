<?php

class QrAbsensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_Model');
        $this->load->model('Pesertadidik');
        $this->load->model('Model_landing');
    }

    public function index()
    {

        $data = array(
            'data_site'             => $this->Model_landing->get_site()->result()
        );

        $this->load->view('qr_scan', $data);
    }


    public function submit_qr_absensi()
    {
        // Mendapatkan data QR code dari POST request
        $qr_code = $this->input->post('qr_code', true); // Menggunakan filter 'true' untuk XSS filter

        // Validasi input QR code
        if (empty($qr_code)) {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'QR Code tidak valid.')));
            return;
        }

        // Mendapatkan data siswa berdasarkan QR code (id_siswa)
        $siswa = $this->Pesertadidik->get_siswa_by_qr_code($qr_code);
        if (!$siswa) {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Siswa tidak ditemukan.')));
            return;
        }

        // Periksa apakah pengguna sudah melakukan absen hari ini
        $tanggal_absen_terakhir = $this->Absensi_Model->get_tanggal_absen_terakhir($siswa->id_siswa);
        $today_timestamp = date('Y-m-d H:i:s');

        if ($tanggal_absen_terakhir && date('Y-m-d', strtotime($tanggal_absen_terakhir)) == date('Y-m-d', strtotime($today_timestamp))) {
            // Pengguna sudah melakukan absen hari ini, berikan pesan error
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => $siswa->nama_siswa . ' melakukan absen hari ini.')));
            return;
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
            $absen = 'Telat'; // Dianggap telat
        }

        // Data absensi yang akan disimpan
        $data = array(
            'id_siswa'  => $siswa->id_siswa,
            'timestamp' => date('Y-m-d H:i:s'),
            'absen'     => $absen
        );

        try {
            // Simpan data absensi menggunakan model
            $this->Absensi_Model->submit_absensi($data);

            // Set flashdata untuk pesan sukses
            $response = array('status' => 'success', 'message' => 'Absensi ' . $siswa->nama_siswa . ' berhasil disimpan.');
        } catch (Exception $e) {
            // Tangani error jika ada
            $response = array('status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan absensi.');
        }

        $this->output->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
