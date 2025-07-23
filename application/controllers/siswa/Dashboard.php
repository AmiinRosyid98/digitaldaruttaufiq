<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_siswa');
        $this->load->model('Pesertadidik');
        $this->load->model('Siswa_Model');
        $this->load->library('ciqrcode');

        if (!$this->auth_siswa->current_user()) {
            redirect('auth/loginsiswa');
        }
    }


    public function index()
    {
        $current_user = $this->auth_siswa->current_user();

        if ($current_user) {
            $id_siswa = $current_user->id_siswa;

            $data = [
                'current_user'      => $current_user,
                'profilsekolah'     => $this->Pesertadidik->get_perusahaan_data(),
                'datasiswa'         => $this->Pesertadidik->get_datasiswa($id_siswa)
            ];

            $this->load->view('siswa/dashboard', $data);
        } else {
            redirect('auth/loginsiswa');
        }
    }


    public function generate_qr_code($id_siswa)
    {
        // Ambil data siswa berdasarkan ID
        $siswa = $this->Siswa_Model->get_siswa_by_id($id_siswa);

        if (!$siswa) {
            // Jika data siswa tidak ditemukan, beri respons error
            $response = [
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ];
            echo json_encode($response);
            return;
        }

        // Format data siswa untuk QR Code
        $qr_text = $siswa['id_siswa'];

        // Konfigurasi QR Code
        $params['data'] = $qr_text;
        $params['level'] = 'H'; // Error correction level (L, M, Q, H)
        $params['size'] = 10; // Ukuran QR Code
        $params['savename'] = FCPATH . 'assets/qr_code/' . $siswa['nama_siswa'] . '_' . $siswa['id_siswa'] . '.png'; // Lokasi untuk menyimpan QR Code

        // Generate QR Code
        $this->ciqrcode->generate($params);

        // Simpan lokasi file QR Code ke dalam variabel
        $qr_code_path = 'assets/qr_code/' . $siswa['nama_siswa'] . '_' . $siswa['id_siswa'] . '.png';

        // Simpan $qr_code_path ke dalam database
        $this->Siswa_Model->update_qr_code_path($id_siswa, $qr_code_path);

        // Respons JSON dengan path QR Code
        $response = [
            'success' => true,
            'qr_code_path' => base_url($qr_code_path)
        ];
        echo json_encode($response);
    }
}
