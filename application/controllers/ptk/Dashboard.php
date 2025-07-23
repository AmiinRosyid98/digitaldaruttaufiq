<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_landing');
        $this->load->model('Buku_Model');
        $this->load->model('Ptk');
        $this->load->model('Auth_ptk');
        $this->load->library('ciqrcode');


        if (!$this->Auth_ptk->current_user()) {
            redirect('auth/loginptk');
        }
    }

    public function index()
    {
        $logo_data = $this->Ptk->get_logo();
        $current_user = $this->Auth_ptk->current_user();
        $id_guru = $current_user->id_guru;

        $data = [
            "current_user"     => $current_user,
            "profilsekolah"    => $this->Ptk->get_profilsekolah_data(),
            "kelas"            => $this->Ptk->get_kelasmengajar($id_guru),
            "mapel"            => $this->Ptk->get_mapel_mengajar($id_guru), // Tambahkan data mapel
            'dataguru'         => $this->Ptk->get_dataguru($id_guru),
            "logo"             => $logo_data['logo'],
        ];

        $this->load->view('ptk/dashboard', $data);
    }


    public function generate_qr_code($id_guru)
    {
        // Ambil data siswa berdasarkan ID
        $guru = $this->Ptk->get_dataguru($id_guru);

        if (!$guru) {
            // Jika data siswa tidak ditemukan, beri respons error
            $response = [
                'success' => false,
                'message' => 'Data Guru tidak ditemukan'
            ];
            echo json_encode($response);
            return;
        }

        // Format data siswa untuk QR Code
        $qr_text = $guru['id_guru'];

        // Konfigurasi QR Code
        $params['data'] = $qr_text;
        $params['level'] = 'H'; // Error correction level (L, M, Q, H)
        $params['size'] = 10; // Ukuran QR Code
        $params['savename'] = FCPATH . 'assets/qr_code/' . $guru['nama_ptk'] . '_' . $guru['id_guru'] . '.png'; // Lokasi untuk menyimpan QR Code

        // Generate QR Code
        $this->ciqrcode->generate($params);

        // Simpan lokasi file QR Code ke dalam variabel
        $qr_code_path = 'assets/qr_code/' . $guru['nama_ptk'] . '_' . $guru['id_guru'] . '.png';

        // Simpan $qr_code_path ke dalam database
        $this->Ptk->update_qr_code_path($id_guru, $qr_code_path);

        // Respons JSON dengan path QR Code
        $response = [
            'success' => true,
            'qr_code_path' => base_url($qr_code_path)
        ];
        echo json_encode($response);
    }
}
