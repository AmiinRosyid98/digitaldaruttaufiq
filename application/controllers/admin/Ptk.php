<?php

class Ptk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Kelas_Model');
        $this->load->model('Mapel_Model');
        $this->load->model('Siswa_Model');

        $this->load->model('Ptk_Model');
        $this->load->model('Tahunangkatan_Model');
        $this->load->model('auth_admin');
        $this->load->library('pagination');
        $this->load->library('upload');
        $this->load->library('ciqrcode');

        // Pemeriksaan apakah pengguna telah login
        $current_user = $this->auth_admin->current_user();
        if (!$current_user) {
            // Simpan URL halaman sebelumnya
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginadmin');
        }

        // Pemeriksaan apakah pengguna memiliki peran 'admin'
        if ($current_user->role != 'admin') {
            // Mengarahkan pengguna ke halaman kesalahan kustom
            $error_msg = 'Anda tidak diizinkan mengakses resources ini';
            show_error($error_msg, 403, 'Akses Ditolak');
        }
    }


    public function index()
    {
        $logo_data = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['current_user']   = $this->auth_admin->current_user();
        $data['ptk']            = $this->Ptk_Model->get_ptk();
        $data['kelas']          = $this->Kelas_Model->get_kelas();
        $data['mapel']          = $this->Mapel_Model->get_mapel();
        $this->load->view('admin/ptk', $data);
    }
    public function detailptk($siswa_id)
    {

        $logo_data = $this->admin->get_logo();
        $ptk_data = $this->Ptk_Model->get_ptk_by_id($siswa_id);
        $data['logo']           = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['current_user']   = $this->auth_admin->current_user();
        $data['kelas']          = $this->Kelas_Model->get_kelas();
        $data['ptk']          = $ptk_data;
        $this->load->view('admin/ptk_detail', $data);
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
        redirect(base_url('admin/ptk/detailptk/') . $guru_id) . '#datadiri';
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
        redirect(base_url('admin/ptk/detailptk/') . $guru_id) . '#datapendidikan';
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
                redirect(base_url('admin/ptk/detailptk/') . $guru_id) . '#datakepegawaian';

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
        redirect(base_url('admin/ptk/detailptk/') . $guru_id) . '#datakepegawaian';
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
        redirect(base_url('admin/ptk/detailptk/') . $guru_id) . '#dokumenpendukung';
    }


    public function upload_foto($id_guru)
    {
        $config['upload_path']   = './assets/ptk/profile/'; // Path untuk menyimpan foto
        $config['allowed_types']  = 'jpg|jpeg|png';
        $config['max_size']       = 2048; // Maksimal 2MB
        $config['file_name']      = 'avatar_' . $id_guru; // Nama file unik
        $this->upload->initialize($config);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_guru')) {
            $upload_data = $this->upload->data();
            // Simpan informasi foto guru ke database
            $this->Ptk_Model->update_foto($id_guru, $upload_data['file_name']); // Gunakan kolom 'avatar'

            $this->session->set_flashdata('success_message', 'Foto guru berhasil diupload.');
        } else {
            $this->session->set_flashdata('error_message', $this->upload->display_errors());
        }

        redirect('admin/ptk');
    }



    public function get_ptk()
    {
        $ptk_id = $this->input->get('ptk_id');
        $ptk = $this->Ptk_Model->get_ptk_by_id($ptk_id);

        // Ambil data mapel yang diajar oleh PTK ini
        $ptk['mapel'] = $this->Ptk_Model->get_mapel_ptk($ptk_id);

        echo json_encode(['ptk' => $ptk]);
    }



    public function simpan_ptk()
    {
        $nip = $this->input->post('nip');
        $username = $this->input->post('username');

        // Check if the NIP already exists in the database
        $existing_nip = $this->Ptk_Model->cek_nip($nip);
        if ($existing_nip) {
            $this->session->set_flashdata('error_message', 'NIP sudah ada dalam database.');
            redirect('admin/ptk');
            return;
        }

        // Check if the username already exists in the database
        $existing_username = $this->Ptk_Model->cek_username($username);
        if ($existing_username) {
            $this->session->set_flashdata('error_message', 'Username sudah ada dalam database.');
            redirect('admin/ptk');
            return;
        }

        // If NIP and username are unique, proceed with data insertion
        $nama_ptk = $this->input->post('nama_ptk');
        $jeniskelamin = $this->input->post('jeniskelamin');
        $agama = $this->input->post('agama');
        $tempatlahir_ptk = $this->input->post('tempatlahir_ptk');
        $tanggallahir_ptk = $this->input->post('tanggallahir_ptk');
        $ptk_alamat = $this->input->post('ptk_alamat');
        $kode_kelas = implode(',', $this->input->post('kode_kelas'));
        $avatar = $this->input->post('avatar');
        $password = $this->input->post('password');
        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
        $mengajar_mapel = $this->input->post('mengajar_mapel'); // Array of mapel IDs

        $insert_data = array(
            'nip' => $nip,
            'nama_ptk' => $nama_ptk,
            'jeniskelamin' => $jeniskelamin,
            'agama' => $agama,
            'tempatlahir_ptk' => $tempatlahir_ptk,
            'tanggallahir_ptk' => $tanggallahir_ptk,
            'ptk_alamat' => $ptk_alamat,
            'kode_kelas' => $kode_kelas,
            'avatar' => $avatar,
            'username' => $username,
            'password' => $encrypted_password
        );

        // Mulai transaction
        $this->db->trans_start();

        // Simpan data PTK utama
        $insert_result = $this->Ptk_Model->simpan_ptk($insert_data);
        $id_guru = $this->db->insert_id();

        // Simpan data mapel yang diajar
        if (!empty($mengajar_mapel)) {
            foreach ($mengajar_mapel as $id_mapel) {
                if (!empty($id_mapel)) { // Skip jika mapel kosong
                    $this->Ptk_Model->tambah_mapel_ptk($id_guru, $id_mapel);
                }
            }
        }

        // Selesaikan transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data PTK.');
        } else {
            $this->session->set_flashdata('success_message', 'Data PTK berhasil disimpan.');
        }
        redirect('admin/ptk');
    }

    public function generate_qr_code($id_guru)
    {
        // Ambil data PTK berdasarkan ID
        $ptk = $this->Ptk_Model->get_ptk_by_id($id_guru);

        if (!$ptk) {
            // Jika data PTK tidak ditemukan, beri respons error
            $response = [
                'success' => false,
                'message' => 'Data PTK tidak ditemukan'
            ];
            echo json_encode($response);
            return;
        }

        // Format data siswa untuk QR Code
        $qr_text = $ptk['id_guru'];

        // Konfigurasi QR Code
        $params['data'] = $qr_text;
        $params['level'] = 'H'; // Error correction level (L, M, Q, H)
        $params['size'] = 10; // Ukuran QR Code
        $params['savename'] = FCPATH . 'assets/qr_code/' . $ptk['nama_ptk'] . '_' . $ptk['id_guru'] . '.png'; // Lokasi untuk menyimpan QR Code

        // Generate QR Code
        $this->ciqrcode->generate($params);

        // Simpan lokasi file QR Code ke dalam variabel
        $qr_code_path = 'assets/qr_code/' . $ptk['nama_ptk'] . '_' . $ptk['id_guru'] . '.png';

        // Simpan $qr_code_path ke dalam database
        $this->Ptk_Model->update_qr_code_path($id_guru, $qr_code_path);

        // Respons JSON dengan path QR Code
        $response = [
            'success' => true,
            'qr_code_path' => base_url($qr_code_path)
        ];
        echo json_encode($response);
    }


    public function import_data_excel()
    {
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        $response = array('success' => false, 'message' => '');

        try {
            $allowedExtensions = array('xls', 'xlsx');
            $fileExtension = pathinfo($_FILES['excelFile']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                $response['message'] = 'Hanya file dengan ekstensi .xls atau .xlsx yang diizinkan.';
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            $excelFile = $_FILES['excelFile']['tmp_name'];
            $objPHPExcel = PHPExcel_IOFactory::load($excelFile);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            // Proses data dari baris kedua (A2) dari file Excel
            for ($i = 3; $i <= count($sheetData); $i++) {
                $row = $sheetData[$i];
                $username           = isset($row['B']) ? $row['B'] : '';
                $password           = isset($row['B']) ? password_hash($row['B'], PASSWORD_DEFAULT) : '';
                $nip                = isset($row['B']) ? $row['B'] : '';
                $nama_ptk           = isset($row['C']) ? $row['C'] : '';
                $jeniskelamin       = isset($row['D']) ? $row['D'] : '';
                $agama              = isset($row['E']) ? $row['E'] : '';
                $tempatlahir_ptk    = isset($row['F']) ? $row['F'] : '';
                $tanggallahir_ptk   = isset($row['G']) ? $row['G'] : '';



                // Lakukan proses penyimpanan ke dalam database
                $this->Ptk_Model->simpan_ptk_from_excel(
                    $username,
                    $password,
                    $nip,
                    $nama_ptk,
                    $jeniskelamin,
                    $agama,
                    $tempatlahir_ptk,
                    $tanggallahir_ptk
                ); // Method ini harus Anda definisikan dalam model Anda
            }

            $response['success'] = true;
            $response['message'] = 'Data berhasil diimpor dari Excel';
        } catch (Exception $e) {
            $response['message'] = 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function formatTanggalIndo($datetime, $pakejam = null) {
        // Ubah ke timestamp
        if($datetime==""){
            return "";
        }
        $timestamp = strtotime($datetime);

        // Array nama bulan dalam Bahasa Indonesia
        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

        $tgl = date('d', $timestamp);
        $bln = (int)date('m', $timestamp); // jadi integer untuk ambil dari array
        $thn = date('Y', $timestamp);
        $jam = $pakejam ? date('H:i', $timestamp) : '';
        if($pakejam != null){
            return "$tgl {$bulanIndo[$bln]} $thn, Pukul $jam WIB";
        }
        return "$tgl {$bulanIndo[$bln]} $thn";
    }

    // tes


    public function export_excel()
    {
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Ambil data dari model PTK
        $data = $this->Ptk_Model->get_ptk();

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Data PTK")
            ->setSubject("Data PTK")
            ->setDescription("Laporan data PTK")
            ->setKeywords("ptk excel")
            ->setCategory("Laporan");

        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // HEADER INTRO

        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');
        

        // Set style untuk cell yang di-merge
        $style = array(
            'font'  => array(
                'bold'  => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        // Buat style untuk border
        $Border = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $styleCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $sheet->getStyle('A1')->applyFromArray($style);
        $sheet->getStyle('A2')->applyFromArray($style);
        $sheet->getStyle('A3')->applyFromArray($style);

        $sheet->setCellValue('A1', 'DATA PTK');
        $sheet->setCellValue('A2', 'SMP ISLAM DARUT TAUFIQ');
        $sheet->setCellValue('A3', 'TAHUN AJARAN 2025');


        // Header kolom
        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Nama PTK');
        $sheet->setCellValue('C5', 'NIP');
        $sheet->setCellValue('D5', 'Email');
        $sheet->setCellValue('E5', 'Jenis Kelamin');
        $sheet->setCellValue('F5', 'Mapel');
        $sheet->setCellValue('G5', 'NIK');
        $sheet->setCellValue('H5', 'Agama');
        $sheet->setCellValue('I5', 'Tempat dan Tanggal Lahir');
        $sheet->setCellValue('J5', 'Alamat');
        $sheet->setCellValue('K5', 'No Telp');
        $sheet->setCellValue('L5', 'Email');
        $sheet->setCellValue('M5', 'Pendidikan Terakhir');
        $sheet->setCellValue('N5', 'Nama Institusi');
        $sheet->setCellValue('O5', 'Jurusan');
        $sheet->setCellValue('P5', 'Tahun Lulus');
        $sheet->setCellValue('Q5', 'No. Ijazah');
        $sheet->setCellValue('R5', 'Status Kepegawaian');
        $sheet->setCellValue('S5', 'Tanggal Mulai Pengangkatan (TMT)');
        $sheet->setCellValue('T5', 'Jabatan / Tugas Tambahan');
        $sheet->setCellValue('U5', 'Status');
        $sheet->setCellValue('V5', 'No. Rekening');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);

        // Isi data
        $row = 6;
        $no = 1;
        foreach ($data as $d) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $d['nama_ptk']);
            $sheet->setCellValue('C' . $row, $d['nip']);
            $sheet->setCellValue('D' . $row, $d['email']);
            $sheet->setCellValue('E' . $row, $d['jeniskelamin']);
            $sheet->setCellValue('F' . $row, $d['nama_mapel']); // sesuaikan jika nama mapel gabung tabel
            $sheet->setCellValue('G' . $row, $d['nik']);
            $sheet->setCellValue('H' . $row, $d['agama']);
            $sheet->setCellValue('I' . $row, $d['tempatlahir_ptk'].", ". $this->formatTanggalIndo($d['tanggallahir_ptk']));
            $sheet->setCellValue('J' . $row, $d['ptk_alamat']. ", ". $d['kelurahan']. ", ". $d['kecamatan']. ", ". $d['kabupaten']. ", ". $d['provinsi']);
            $sheet->setCellValue('K' . $row, $d['no_telepon']);
            $sheet->setCellValue('L' . $row, $d['email']);
            $sheet->setCellValue('M' . $row, $d['pendidikan_terakhir']);
            $sheet->setCellValue('N' . $row, $d['nama_institusi_pendidikan']);
            $sheet->setCellValue('O' . $row, $d['jurusan']);
            $sheet->setCellValue('P' . $row, $d['tahun_lulus']);
            $sheet->setCellValue('Q' . $row, $d['ijazah_transkrip']);
            $sheet->setCellValue('R' . $row, $d['status_kepegawaian']);
            $sheet->setCellValue('S' . $row, $this->formatTanggalIndo($d['tmt']));
            $sheet->setCellValue('T' . $row, $d['jabatan_tambahan']);
            $sheet->setCellValue('U' . $row, $d['status_aktif']);
            $sheet->setCellValue('V' . $row, $d['nomor_rekening']);
            $row++;
        }

        $sheet->getStyle('A5:V' . ($row-1))->applyFromArray($Border);
        $sheet->getStyle('A5:A' . ($row-1))->applyFromArray($styleCenter);
        $sheet->getStyle('E5:E' . ($row-1))->applyFromArray($styleCenter);
        $sheet->getStyle('H5:H' . ($row-1))->applyFromArray($styleCenter);
        $sheet->getStyle('M5:M' . ($row-1))->applyFromArray($styleCenter);
        $sheet->getStyle('P5:P' . ($row-1))->applyFromArray($styleCenter);
        $sheet->getStyle('R5:R' . ($row-1))->applyFromArray($styleCenter);
        $sheet->getStyle('S5:S' . ($row-1))->applyFromArray($styleCenter);
        $sheet->getStyle('U5:U' . ($row-1))->applyFromArray($styleCenter);

        $row = $row+2;
        $sheet->setCellValue('A' . $row, 'Di Download Pada :  ' . $this->formatTanggalIndo(date('Y-m-d H:i:s'), "dgnjam"));

        // Style untuk header (baris 5)
        $headerStyle = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '4472C4') // Warna biru
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF') // Warna teks putih
            ),
            'alignment' => array(
                'wrap' => true, // Aktifkan wrap text
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            )
        );

        // Terapkan style ke header
        $sheet->getStyle('A5:V5')->applyFromArray($headerStyle);

        // Atur tinggi baris header
        $sheet->getRowDimension(5)->setRowHeight(30); // Atur tinggi 30 point

        // Nama file
        $filename = "Data_PTK_" . date('YmdHis') . ".xlsx";

        

        // Output ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }


    public function update_ptk()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('editPtkId', 'ID PTK', 'required|integer');
        $this->form_validation->set_rules('editNip', 'NIP', 'required|numeric');
        $this->form_validation->set_rules('editNama', 'Nama PTK', 'required|trim');
        $this->form_validation->set_rules('editJeniskelamin', 'Jenis Kelamin', 'required|in_list[L,P]');
        $this->form_validation->set_rules('editAgama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('editTempatlahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('editTanggallahir', 'Tanggal Lahir', 'required|callback_valid_date');
        $this->form_validation->set_rules('editUsername', 'Username', 'required|trim');
        $this->form_validation->set_rules('editPassword', 'Password', 'min_length[6]');
        $this->form_validation->set_rules('editMapel[]', 'Mata Pelajaran', 'required');

        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(array('success' => false, 'message' => $errors));
            return;
        }

        $ptk_id = $this->input->post('editPtkId', true);
        $kode_kelas = $this->input->post('editKodeKelas', true);
        $kode_kelas_string = is_array($kode_kelas) ? implode(',', $kode_kelas) : '';
        $mapel_mengajar = $this->input->post('editMapel', true);

        // Data untuk update
        $data = array(
            'nip'               => $this->input->post('editNip', true),
            'nama_ptk'          => $this->input->post('editNama', true),
            'jeniskelamin'      => $this->input->post('editJeniskelamin', true),
            'agama'             => $this->input->post('editAgama', true),
            'tempatlahir_ptk'  => $this->input->post('editTempatlahir', true),
            'tanggallahir_ptk'  => $this->input->post('editTanggallahir', true),
            'kode_kelas'       => $kode_kelas_string,
            'ptk_alamat'       => $this->input->post('editAlamat', true),
            'username'         => $this->input->post('editUsername', true)
        );

        // Jika ada input password baru
        $new_password = $this->input->post('editPassword', true);
        if (!empty($new_password)) {
            $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        // Mulai transaction
        $this->db->trans_start();

        // Update data PTK utama
        $result = $this->Ptk_Model->update_ptk($ptk_id, $data);

        // Hapus semua relasi mapel yang ada
        $this->Ptk_Model->hapus_mapel_ptk($ptk_id);

        // Tambahkan kembali mapel yang dipilih
        if (!empty($mapel_mengajar) && is_array($mapel_mengajar)) {
            foreach ($mapel_mengajar as $id_mapel) {
                if (!empty($id_mapel)) {
                    $this->Ptk_Model->tambah_mapel_ptk($ptk_id, $id_mapel);
                }
            }
        }

        // Selesaikan transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error_message', 'Gagal memperbarui data PTK.');
            echo json_encode(array('success' => false, 'message' => 'Gagal memperbarui data PTK.'));
        } else {
            $this->session->set_flashdata('success_message', 'Data PTK berhasil diperbarui.');
            echo json_encode(array('success' => true));
        }
    }





    public function valid_date($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }


    public function hapus_ptk($ptk_id)
    {
        // Mulai transaction
        $this->db->trans_start();

        // 1. Hapus data mapel yang diajar oleh PTK ini
        $this->Ptk_Model->hapus_mapel_ptk($ptk_id);

        // 2. Hapus data PTK utama
        $result = $this->Ptk_Model->hapus_ptk($ptk_id);

        // Selesaikan transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error_message', 'Gagal menghapus PTK.');
        } else {
            $this->session->set_flashdata('success_message', 'PTK berhasil dihapus.');
        }

        redirect('admin/ptk');
    }


    public function kosongkan_ptk()
    {
        $this->Ptk_Model->kosongkan_ptk();

        // Set pesan flashdata untuk ditampilkan setelah redirect
        $this->session->set_flashdata('success_message', 'Data PTK telah berhasil dikosongkan.');


        redirect('admin/ptk');
    }



































    public function detailsiswa($siswa_id)
    {

        $logo_data = $this->admin->get_logo();
        $siswa_data = $this->Siswa_Model->get_siswa_by_id($siswa_id);
        $data['logo']           = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['current_user']   = $this->auth_admin->current_user();
        $data['kelas']          = $this->Kelas_Model->get_kelas();
        $data['siswa']          = $siswa_data;
        $this->load->view('admin/siswa_detail', $data);
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

        // Arahkan kembali pengguna ke halaman detail siswa dengan ID siswa yang sama
        redirect(base_url('admin/siswa/detailsiswa/') . $siswa_id) . '#datadiri';
    }

    public function updatedatakelassiswa()
    {
        $siswa_id = $this->input->post('editSiswaId');
        $data = array(
            'no_absen'      => $this->input->post('editNoAbsen'),
            'kode_kelas'    => $this->input->post('editKodeKelas'),
            'nis'           => $this->input->post('editNis'),
            'nisn'          => $this->input->post('editNisn')
        );

        $result = $this->Siswa_Model->update_siswa($siswa_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Kelas Siswa berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Kelas Siswa');
        }

        // Arahkan kembali pengguna ke halaman detail siswa dengan ID siswa yang sama dan tab-pane yang dipilih
        redirect(base_url('admin/siswa/detailsiswa/') . $siswa_id . '#datakelas');
    }

    public function updatedataakunsiswa()
    {
        $siswa_id = $this->input->post('editSiswaId');
        $password = $this->input->post('editPassword');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $data = array(
            'username' => $this->input->post('editUsername'),
            'password' => $hashed_password
        );

        $result = $this->Siswa_Model->update_siswa($siswa_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Akun Siswa berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Data Akun Siswa');
        }

        // Arahkan kembali pengguna ke halaman detail siswa dengan ID siswa yang sama dan tab-pane yang dipilih
        redirect(base_url('admin/siswa/detailsiswa/') . $siswa_id . '#datakelas');
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


    public function cetak_suratketeranganlulus($siswa_id)
    {
        require_once APPPATH . 'third_party/tcpdf/tcpdf.php';
        $this->load->model('Siswa_Model');
        $this->load->model('Admin');
        $this->load->model('Kelulusan_Model');

        $siswa                  = $this->Siswa_Model->get_siswa_by_id($siswa_id);
        $lembaga                = $this->admin->get_profilsekolah_data();
        $templateskl            = $this->Kelulusan_Model->get_settingskl();
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = base_url('assets/web/' . $logo_data['logo']);
        $data['logopemerintah'] = base_url('assets/pemerintah/' . $logo_data['logopemerintah']);

        $pdfContent = $this->load->view('admin/cetak/surat_keterangan_lulus', ['siswa' => $siswa, 'lembaga' => $lembaga, 'data' => $data, 'templateskl' => $templateskl], true);
        $pdf = new TCPDF('P', 'pt', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Anonymous Code');
        $pdf->SetTitle($siswa['nama_kelas'] . '-' . $siswa['no_absen'] . '-' . $siswa['nama_siswa']); // Mengatur judul PDF menjadi nama siswa
        $pdf->SetSubject($siswa['nama_siswa']);
        $pdf->SetKeywords('TCPDF, PDF, data siswa');
        $pdf->SetMargins(20, 20, 20, true);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetPrintHeader(false);
        $pdf->AddPage();
        $pdf->writeHTML($pdfContent, true, false, true, false, '');
        $pdf->Output('KET-LULUS' . '-' . $siswa['nama_kelas'] . '-' . $siswa['no_absen'] . '-' . $siswa['nama_siswa'] . '.pdf', 'I');
    }
}
