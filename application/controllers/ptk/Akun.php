<?php

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_landing');
        $this->load->model('Buku_Model');
        $this->load->model('Ptk');
        $this->load->model('Ptk_Model');
        $this->load->model('Kelas_Model');
        $this->load->model('admin');
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

        $logo_data = $this->admin->get_logo();
        $ptk_data = $this->Ptk_Model->get_ptk_by_id($id_guru);
        $data['current_user']   = $current_user;
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['kelas']          = $this->Ptk->get_kelasmengajar($id_guru);
        $data['mapel']          =  $this->Ptk->get_mapel_mengajar($id_guru);
        $data['dataguru']          =   $this->Ptk->get_dataguru($id_guru);
        $data['ptk']          = $ptk_data;
        $data['logo']           = $logo_data['logo'];
        $this->load->view('ptk/ptk_detail', $data);
    }

    /*public function index()
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
    }*/


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

    public function updatedatadiriguru()
    {
        $guru_id = $this->input->post('editGuruId');
        $data = array(
            'nama_ptk'        => $this->input->post('editNamaPtk'),
            'nip'        => $this->input->post('editNipPtk'),
            'nik'        => $this->input->post('editNikPtk'),
            'jeniskelamin'      => $this->input->post('editJeniskelamin'),
            'agama'             => $this->input->post('editAgama'),
            'tempatlahir_ptk'       => $this->input->post('editTempatlahir'),
            'tanggallahir_ptk'      => $this->input->post('editTanggallahir'),
            'ptk_alamat'      => $this->input->post('editPtkAlamat'),
            'kelurahan'   => $this->input->post('editPtkKelurahan'),
            'kecamatan'   => $this->input->post('editPtkKecamatan'),
            'kabupaten'   => $this->input->post('editPtkKabupaten'),
            'provinsi'    => $this->input->post('editPtkProvinsi'),
            'no_telepon'              => $this->input->post('editNohp'),
            'email'             => $this->input->post('editPtkemail')
        );


        $lanjut = "yes";
        if (isset($_FILES['editPhoto']) && $_FILES['editPhoto']['error'] == UPLOAD_ERR_OK) {
            $config['upload_path']   = './assets/ptk/profile/'; // Path untuk menyimpan foto
            $config['allowed_types']  = 'jpg|jpeg|png';
            $config['max_size']       = 2048; // Maksimal 2MB
            $config['file_name']      = 'avatar_' . $guru_id; // Nama file unik
            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('editPhoto')) {
                $upload_data = $this->upload->data();
                // Simpan informasi foto guru ke database
                $this->Ptk_Model->update_foto($guru_id, $upload_data['file_name']); // Gunakan kolom 'avatar'

                $this->session->set_flashdata('success_message', 'Foto guru berhasil diupload.');
            } else {
                $this->session->set_flashdata('error_message', $this->upload->display_errors());
                $lanjut = "no";
            }

        } 
        if($lanjut == "yes"){
            $result = $this->Ptk_Model->update_guru($guru_id, $data);
        } else {
            $result = false;
            // $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Diri Guru');

        }
        // var_dump($result);die;
        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Diri Guru berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Diri Guru');
        }
        redirect(base_url('ptk/akun')) . '#datadiri';
    }

    public function updatedatapendidikan()
    {
        $guru_id = $this->input->post('editGuruId');
        $data = array(
            'pendidikan_terakhir'        => $this->input->post('editPendidikanTerakhir'),
            'nama_institusi_pendidikan'        => $this->input->post('editInstitusiPendidikan'),
            'jurusan'        => $this->input->post('editJurusan'),
            'tahun_lulus'      => $this->input->post('editTahunLulus'),
            'ijazah_transkrip'             => $this->input->post('editIjazah'),
        );

        $result = $this->Ptk_Model->update_guru($guru_id, $data);

        // var_dump($result);die;
        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Diri Guru berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Diri Guru');
        }
        redirect(base_url('ptk/akun')) . '#datapendidikan';
    }

    public function updatedatakepegawaian()
    {
        $guru_id = $this->input->post('editGuruId');
        $data = array(
            'status_kepegawaian'        => $this->input->post('editStatusKepegawaian'),
            'tmt'        => $this->input->post('editTanggalMulaiTugas'),
            'jabatan_tambahan'        => $this->input->post('editJabatan'),
            'status_aktif'      => $this->input->post('editStatusAktif'),
            'nomor_rekening'             => $this->input->post('editNomorRekening'),
        );

        $lanjut = "yes";
        if (isset($_FILES['editSkPengangkatan']) && $_FILES['editSkPengangkatan']['error'] == UPLOAD_ERR_OK) {
            $config['upload_path']   = './assets/ptk/dokumen/'; // Path untuk menyimpan foto
            $config['allowed_types']  = '*';
            $config['max_size']       = 100048; // Maksimal 2MB
            $config['file_name']      = 'sk_pengangkatan_' . $guru_id; // Nama file unik
            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('editSkPengangkatan')) {
                $upload_data = $this->upload->data();
                // Simpan informasi foto guru ke database
                $this->Ptk_Model->update_sk_pengangkatan($guru_id, $upload_data['file_name']); // Gunakan kolom 'avatar'

                $this->session->set_flashdata('success_message', 'SK Pengangkatan guru berhasil diupload.');
            } else {
                $this->session->set_flashdata('error_message', $this->upload->display_errors());
                // var_dump($this->upload->display_errors());die;
                // $lanjut = "no";
                redirect(base_url('ptk/akun')) . '#datakepegawaian';

            }

        } 
        
        $result = $this->Ptk_Model->update_guru($guru_id, $data);

        /*var_dump($lanjut);
        var_dump($result);die;*/

        // $result = $this->Ptk_Model->update_guru($guru_id, $data);

        // var_dump($result);die;
        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Diri Guru berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Diri Guru');
            // sadsadas
        }
        redirect(base_url('ptk/akun')) . '#datakepegawaian';
    }

    public function updatedokumenpendukung()
    {
        $guru_id = $this->input->post('editGuruId');
        $data = array(
            'pendidikan_terakhir'        => $this->input->post('editPendidikanTerakhir'),
            'nama_institusi_pendidikan'        => $this->input->post('editInstitusiPendidikan'),
            'jurusan'        => $this->input->post('editJurusan'),
            'tahun_lulus'      => $this->input->post('editTahunLulus'),
            'ijazah_transkrip'             => $this->input->post('editIjazah'),
        );
        $data = [];
        $path = './assets/ptk/dokumen/';
        if (isset($_FILES['editScanIjazah']) && $_FILES['editScanIjazah']['error'] == UPLOAD_ERR_OK) {
            $config['upload_path']   = $path; // Path untuk menyimpan foto
            $config['allowed_types']  = '*';
            $config['max_size']       = 100048; // Maksimal 2MB
            $config['file_name']      = 'scan_ijazah_' . $guru_id; // Nama file unik
            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('editScanIjazah')) {
                $upload_data = $this->upload->data();
                $data['scan_ijazah'] = $upload_data['file_name'];
            } else {
                

            }

        } 

        if (isset($_FILES['editScanKtp']) && $_FILES['editScanKtp']['error'] == UPLOAD_ERR_OK) {
            $config['upload_path']   = $path; // Path untuk menyimpan foto
            $config['allowed_types']  = '*';
            $config['max_size']       = 100048; // Maksimal 2MB
            $config['file_name']      = 'scan_ijazah_' . $guru_id; // Nama file unik
            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('editScanKtp')) {
                $upload_data = $this->upload->data();
                $data['scan_ktp'] = $upload_data['file_name'];
            } else {
                

            }

        } 

        if (isset($_FILES['editSertifikatPendidik']) && $_FILES['editSertifikatPendidik']['error'] == UPLOAD_ERR_OK) {
            $config['upload_path']   = $path; // Path untuk menyimpan foto
            $config['allowed_types']  = '*';
            $config['max_size']       = 100048; // Maksimal 2MB
            $config['file_name']      = 'scan_ijazah_' . $guru_id; // Nama file unik
            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('editSertifikatPendidik')) {
                $upload_data = $this->upload->data();
                $data['sertifikat_pendidik'] = $upload_data['file_name'];
            } else {
                

            }

        } 
        if (isset($_FILES['editSertifikatPelatihan']) && $_FILES['editSertifikatPelatihan']['error'] == UPLOAD_ERR_OK) {
            $config['upload_path']   = $path; // Path untuk menyimpan foto
            $config['allowed_types']  = '*';
            $config['max_size']       = 100048; // Maksimal 2MB
            $config['file_name']      = 'scan_ijazah_' . $guru_id; // Nama file unik
            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('editSertifikatPelatihan')) {
                $upload_data = $this->upload->data();
                $data['sertifikat_pelatihan'] = $upload_data['file_name'];
            } else {
                

            }

        } 
        if (isset($_FILES['editPortofolio']) && $_FILES['editPortofolio']['error'] == UPLOAD_ERR_OK) {
            $config['upload_path']   = $path; // Path untuk menyimpan foto
            $config['allowed_types']  = '*';
            $config['max_size']       = 100048; // Maksimal 2MB
            $config['file_name']      = 'scan_ijazah_' . $guru_id; // Nama file unik
            $this->upload->initialize($config);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('editPortofolio')) {
                $upload_data = $this->upload->data();
                $data['portofolio_cv'] = $upload_data['file_name'];
            } else {
                

            }

        } 


        $result = $this->Ptk_Model->update_guru($guru_id, $data);

        // var_dump($result);die;
        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Diri Guru berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Diri Guru');
        }
        redirect(base_url('ptk/akun')) . '#dokumenpendukung';
    }
}
