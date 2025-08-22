<?php

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Kelas_Model');
        $this->load->model('Siswa_Model');
        $this->load->model('Tahunangkatan_Model');
        $this->load->model('auth_admin');
        $this->load->library('pagination');
        $this->load->library('upload');
        $this->load->library('ciqrcode');

        // Pemeriksaan otentikasi dan peran pengguna
        $this->_check_auth();
    }

    private function _check_auth()
    {
        // Pemeriksaan apakah pengguna telah login
        $current_user = $this->auth_admin->current_user();
        if (!$current_user) {
            // Simpan URL halaman sebelumnya dan alihkan ke halaman login
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginadmin');
        }

        // Pemeriksaan apakah pengguna memiliki peran 'admin'
        if ($current_user->role != 'admin') {
            // Mengarahkan pengguna ke halaman kesalahan kustom
            $error_msg = 'Anda tidak diizinkan mengakses resource ini';
            show_error($error_msg, 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        // Mendapatkan data untuk tampilan
        $logo_data = $this->admin->get_logo();
        $data = [
            'logo' => $logo_data['logo'],
            'profilsekolah' => $this->admin->get_profilsekolah_data(),
            'current_user' => $this->auth_admin->current_user(),
            'siswa' => $this->Siswa_Model->get_siswa(),
            'kelas' => $this->Kelas_Model->get_kelas(),
            'tahunangkatan' => $this->Tahunangkatan_Model->get_tahunangkatan()
        ];

        // Memuat tampilan
        $this->load->view('admin/siswa/siswa', $data);
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



    public function get_siswa()
    {
        $siswa_id   = $this->input->get('siswa_id');
        $siswa      = $this->Siswa_Model->get_siswa_by_id($siswa_id);
        echo json_encode(array('siswa' => $siswa));
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
        $this->load->view('admin/siswa/siswa_detail', $data);
    }



    public function simpan_siswa()
    {
        $nis                = $this->input->post('nis');
        $nisn               = $this->input->post('nisn');
        $nama_siswa         = $this->input->post('nama_siswa');
        $jeniskelamin       = $this->input->post('jeniskelamin');
        $tempatlahir        = $this->input->post('tempatlahir');
        $tanggallahir       = $this->input->post('tanggallahir');
        $siswa_alamat       = $this->input->post('siswa_alamat');
        $agama              = $this->input->post('agama');
        $kode_kelas         = $this->input->post('kode_kelas');
        $no_absen           = $this->input->post('no_absen');
        $avatar             = $this->input->post('avatar');
        $username           = $this->input->post('username');
        $password           = $this->input->post('password');
        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
        $tahun_angkatan     = $this->input->post('tahun_angkatan');
        $insert_data = array(
            'nis'               => $nis,
            'nisn'              => $nisn,
            'nama_siswa'        => $nama_siswa,
            'jeniskelamin'      => $jeniskelamin,
            'tempatlahir'       => $tempatlahir,
            'tanggallahir'      => $tanggallahir,
            'siswa_alamat'      => $siswa_alamat,
            'agama'             => $agama,
            'kode_kelas'        => $kode_kelas,
            'no_absen'          => $no_absen,
            'avatar'            => $avatar,
            'username'          => $username,
            'password'          => $encrypted_password,
            'tahun_angkatan'    => $tahun_angkatan
        );
        $insert_result = $this->Siswa_Model->simpan_siswa($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Siswa berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data pengguna.');
        }
        redirect('admin/siswa');
    }



    public function update_siswa()
    {
        $siswa_id = $this->input->post('editSiswaId');
        $data = array(
            'nama_siswa'        => $this->input->post('editNamaSiswa'),
            'jeniskelamin'      => $this->input->post('editJeniskelamin'),
            'agama'             => $this->input->post('editAgama'),
            'tempatlahir'       => $this->input->post('editTempatlahir'),
            'tanggallahir'      => $this->input->post('editTanggallahir'),
            'siswa_alamat'      => $this->input->post('editAlamatSiswa'),
            'kode_kelas'        => $this->input->post('editKodeKelas'),
            'no_absen'          => $this->input->post('editNomorAbsen'),
            'nis'               => $this->input->post('editNis'),
            'nisn'              => $this->input->post('editNisn'),
            'tahun_angkatan'    => $this->input->post('editTahunAngkatan')
        );
        $result = $this->Siswa_Model->update_siswa($siswa_id, $data);
        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Siswa berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Siswa');
            echo json_encode(array('success' => false));
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
        redirect(base_url('admin/siswa/detailsiswa/') . $siswa_id . '#datakelas');
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
        redirect(base_url('admin/siswa/detailsiswa/') . $siswa_id . '#dataayah');
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
        redirect(base_url('admin/siswa/detailsiswa/') . $siswa_id . '#dataibu');
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
        redirect(base_url('admin/siswa/detailsiswa/') . $siswa_id . '#datalainnya');
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

        redirect(base_url('admin/siswa/detailsiswa/') . $siswa_id . '#dataakun');
    }



    public function hapus_siswaa($siswa_id)
    {
        $result = $this->Siswa_Model->hapus_siswa($siswa_id);

        if ($result) {
            $this->session->set_flashdata('error_message', 'Siswa berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Siswa.');
        }

        redirect('admin/siswa');
    }

    public function hapus_siswa($siswa_id)
    {
        // Ambil data siswa dari database
        $siswa = $this->Siswa_Model->get_siswa_by_id($siswa_id);

        // Hapus file QR code jika ada
        if ($siswa && !empty($siswa['qrcode_siswa'])) {
            $file_path = FCPATH . $siswa['qrcode_siswa']; // Sudah lengkap

            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Hapus data siswa dari database
        $result = $this->Siswa_Model->hapus_siswa($siswa_id);

        if ($result) {
            $this->session->set_flashdata('error_message', 'Siswa berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Siswa.');
        }

        redirect('admin/siswa');
    }




    public function kosongkan_siswa()
    {
        // Panggil model untuk mengosongkan data siswa
        $this->Siswa_Model->kosongkan_siswa();

        // Set pesan flashdata untuk ditampilkan setelah redirect
        $this->session->set_flashdata('success_message', 'Data siswa telah berhasil dikosongkan.');

        // Redirect ke halaman siswa
        redirect('admin/siswa');
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
        $pdf = new TCPDF('P', 'pt', 'LEGAL', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Anonymous Code');
        $pdf->SetTitle($siswa['nama_kelas'] . '-' . $siswa['no_absen'] . '-' . $siswa['nama_siswa']); // Mengatur judul PDF menjadi nama siswa
        $pdf->SetSubject($siswa['nama_siswa']);
        $pdf->SetKeywords('TCPDF, PDF, data siswa');
        $pdf->SetPrintHeader(false);
        $pdf->AddPage();
        $pdf->writeHTML($pdfContent, true, false, true, false, '');
        $pdf->Output('KET-LULUS' . '-' . $siswa['nama_kelas'] . '-' . $siswa['no_absen'] . '-' . $siswa['nama_siswa'] . '.pdf', 'I');
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

            // Mulai transaksi
            $this->db->trans_start();


            // Proses data dari baris kedua (A2) dari file Excel
            for ($i = 3; $i <= count($sheetData); $i++) {
                $row = $sheetData[$i];
                $username           = isset($row['B']) ? $row['B'] : '';
                $password           = isset($row['B']) ? password_hash($row['B'], PASSWORD_DEFAULT) : '';
                $nis                = isset($row['B']) ? $row['B'] : '';
                $nisn               = isset($row['C']) ? $row['C'] : '';
                $nama_siswa         = isset($row['D']) ? $row['D'] : '';
                $jeniskelamin       = isset($row['E']) ? $row['E'] : '';
                $agama              = isset($row['F']) ? $row['F'] : '';
                $tempatlahir        = isset($row['G']) ? $row['G'] : '';
                $tanggallahir       = isset($row['H']) ? $row['H'] : '';
                $kode_kelas         = isset($row['I']) ? $row['I'] : '';
                $no_absen           = isset($row['J']) ? $row['J'] : '';
                $tahun_angkatan     = isset($row['K']) ? $row['K'] : '';
                $anakke             = isset($row['M']) ? $row['M'] : '';
                $jumlahsaudara      = isset($row['N']) ? $row['N'] : '';
                $hobi               = isset($row['O']) ? $row['O'] : '';
                $citacita           = isset($row['P']) ? $row['P'] : '';
                $nohp               = isset($row['Q']) ? $row['Q'] : '';

                $siswa_alamat       = isset($row['S']) ? $row['S'] : '';
                $siswa_kelurahan    = isset($row['T']) ? $row['T'] : '';
                $siswa_kecamatan    = isset($row['U']) ? $row['U'] : '';
                $siswa_kabupaten    = isset($row['V']) ? $row['V'] : '';
                $siswa_provinsi     = isset($row['W']) ? $row['W'] : '';
                $siswa_jaraksekolah = isset($row['X']) ? $row['X'] : '';
                $siswa_transportasi = isset($row['Y']) ? $row['Y'] : '';
                $siswa_tinggal      = isset($row['Z']) ? $row['Z'] : '';

                //INFORMASI DATA AYAH
                $ayah_nama          = isset($row['AB']) ? $row['AB'] : '';
                $ayah_nik           = isset($row['AC']) ? $row['AC'] : '';
                $ayah_tempatlahir   = isset($row['AD']) ? $row['AD'] : '';
                $ayah_tanggallahir  = isset($row['AE']) ? $row['AE'] : '';
                $ayah_agama         = isset($row['AF']) ? $row['AF'] : '';
                $ayah_pendidikan    = isset($row['AG']) ? $row['AG'] : '';
                $ayah_pekerjaan     = isset($row['AH']) ? $row['AH'] : '';
                $ayah_penghasilan   = isset($row['AI']) ? $row['AI'] : '';
                $ayah_alamat        = isset($row['AJ']) ? $row['AJ'] : '';
                $ayah_desakel       = isset($row['AK']) ? $row['AK'] : '';
                $ayah_kecamatan     = isset($row['AL']) ? $row['AL'] : '';
                $ayah_kabupaten     = isset($row['AM']) ? $row['AM'] : '';
                $ayah_provinsi      = isset($row['AN']) ? $row['AN'] : '';
                $ayah_nohp          = isset($row['AO']) ? $row['AO'] : '';
                $ayah_status        = isset($row['AP']) ? $row['AP'] : '';

                //INFORMASI DATA IBU
                $ibu_nama           = isset($row['AR']) ? $row['AR'] : '';
                $ibu_nik            = isset($row['AS']) ? $row['AS'] : '';
                $ibu_tempatlahir    = isset($row['AT']) ? $row['AT'] : '';
                $ibu_tanggallahir   = isset($row['AU']) ? $row['AU'] : '';
                $ibu_agama          = isset($row['AV']) ? $row['AV'] : '';
                $ibu_pendidikan     = isset($row['AW']) ? $row['AW'] : '';
                $ibu_pekerjaan      = isset($row['AX']) ? $row['AX'] : '';
                $ibu_penghasilan    = isset($row['AY']) ? $row['AY'] : '';
                $ibu_alamat         = isset($row['AZ']) ? $row['AZ'] : '';
                $ibu_desakel        = isset($row['BA']) ? $row['BA'] : '';
                $ibu_kecamatan      = isset($row['BB']) ? $row['BB'] : '';
                $ibu_kabupaten      = isset($row['BC']) ? $row['BC'] : '';
                $ibu_provinsi       = isset($row['BD']) ? $row['BD'] : '';
                $ibu_nohp           = isset($row['BE']) ? $row['BE'] : '';
                $ibu_status         = isset($row['BF']) ? $row['BF'] : '';

                //INFORMASI WALI
                $wali_nama           = isset($row['BH']) ? $row['BH'] : '';
                $wali_nik            = isset($row['BI']) ? $row['BI'] : '';
                $wali_tempatlahir    = isset($row['BJ']) ? $row['BJ'] : '';
                $wali_tanggallahir   = isset($row['BK']) ? $row['BK'] : '';
                $wali_agama          = isset($row['BL']) ? $row['BL'] : '';
                $wali_pendidikan     = isset($row['BM']) ? $row['BM'] : '';
                $wali_pekerjaan      = isset($row['BN']) ? $row['BN'] : '';
                $wali_penghasilan    = isset($row['BO']) ? $row['BO'] : '';
                $wali_alamat         = isset($row['BP']) ? $row['BP'] : '';
                $wali_desakel        = isset($row['BQ']) ? $row['BQ'] : '';
                $wali_kecamatan      = isset($row['BR']) ? $row['BR'] : '';
                $wali_kabupaten      = isset($row['BS']) ? $row['BS'] : '';
                $wali_provinsi       = isset($row['BT']) ? $row['BT'] : '';
                $wali_nohp           = isset($row['BU']) ? $row['BU'] : '';
                $wali_status         = isset($row['BV']) ? $row['BV'] : '';

                //KESEHATAN SISWA
                $pendukung_golongandarah    = isset($row['BX']) ? $row['BX'] : '';
                $pendukung_penyakit         = isset($row['BY']) ? $row['BY'] : '';
                $pendukung_kelainanjasmani  = isset($row['BZ']) ? $row['BZ'] : '';
                $pendukung_tinggibadan      = isset($row['CA']) ? $row['CA'] : '';
                $pendukung_beratbadan       = isset($row['CB']) ? $row['CB'] : '';

                //PENDIDIKAN SEBELUMNYA
                $asal_sekolah               = isset($row['CD']) ? $row['CD'] : '';
                $asal_noijazah              = isset($row['CE']) ? $row['CE'] : '';
                $asal_noskhu                = isset($row['CF']) ? $row['CF'] : '';
                $asal_tanggal               = isset($row['CG']) ? $row['CG'] : '';

                //KEGEMARAN SISWA
                $kegemaran_kesenian         = isset($row['CI']) ? $row['CI'] : '';
                $kegemaran_olahraga         = isset($row['CJ']) ? $row['CJ'] : '';
                $kegemaran_organisasi       = isset($row['CK']) ? $row['CK'] : '';
                $kegemaran_lainlain         = isset($row['CL']) ? $row['CL'] : '';


                // Cek apakah kode_kelas ada di tabel kelas
                $this->db->where('no_kelas', $kode_kelas);
                $kelas = $this->db->get('kelas')->row();

                if (!$kelas) {
                    // Rollback transaksi
                    $this->db->trans_rollback();

                    $response['message'] = 'Kode kelas "' . $kode_kelas . '" tidak ditemukan di tabel kelas pada baris ' . $i . '. Import dibatalkan.';
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }

                // Lakukan proses penyimpanan ke dalam database
                $this->Siswa_Model->simpan_siswa_from_excel(
                    $username,
                    $password,
                    $nis,
                    $nisn,
                    $nama_siswa,
                    $jeniskelamin,
                    $agama,
                    $tempatlahir,
                    $tanggallahir,
                    $kode_kelas,
                    $no_absen,
                    $tahun_angkatan,
                    $anakke,
                    $jumlahsaudara,
                    $hobi,
                    $citacita,
                    $nohp,
                    $siswa_alamat,
                    $siswa_kelurahan,
                    $siswa_kecamatan,
                    $siswa_kabupaten,
                    $siswa_provinsi,
                    $siswa_jaraksekolah,
                    $siswa_transportasi,
                    $siswa_tinggal,
                    $ayah_nama,
                    $ayah_nik,
                    $ayah_tempatlahir,
                    $ayah_tanggallahir,
                    $ayah_agama,
                    $ayah_pendidikan,
                    $ayah_pekerjaan,
                    $ayah_penghasilan,
                    $ayah_alamat,
                    $ayah_desakel,
                    $ayah_kecamatan,
                    $ayah_kabupaten,
                    $ayah_provinsi,
                    $ayah_nohp,
                    $ayah_status,
                    $ibu_nama,
                    $ibu_nik,
                    $ibu_tempatlahir,
                    $ibu_tanggallahir,
                    $ibu_agama,
                    $ibu_pendidikan,
                    $ibu_pekerjaan,
                    $ibu_penghasilan,
                    $ibu_alamat,
                    $ibu_desakel,
                    $ibu_kecamatan,
                    $ibu_kabupaten,
                    $ibu_provinsi,
                    $ibu_nohp,
                    $ibu_status,
                    $pendukung_golongandarah,
                    $pendukung_penyakit,
                    $pendukung_kelainanjasmani,
                    $pendukung_tinggibadan,
                    $pendukung_beratbadan,
                    $asal_sekolah,
                    $asal_noijazah,
                    $asal_noskhu,
                    $asal_tanggal,
                    $wali_nama,
                    $wali_nik,
                    $wali_tempatlahir,
                    $wali_tanggallahir,
                    $wali_agama,
                    $wali_pendidikan,
                    $wali_pekerjaan,
                    $wali_penghasilan,
                    $wali_alamat,
                    $wali_desakel,
                    $wali_kecamatan,
                    $wali_kabupaten,
                    $wali_provinsi,
                    $wali_nohp,
                    $wali_status,
                    $kegemaran_kesenian,
                    $kegemaran_olahraga,
                    $kegemaran_organisasi,
                    $kegemaran_lainlain
                ); // Method ini harus Anda definisikan dalam model Anda
            }

            // Commit transaksi jika semua sukses
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $response['message'] = 'Terjadi kesalahan saat menyimpan data.';
            } else {
                $response['success'] = true;
                $response['message'] = 'Data berhasil diimpor dari Excel.';
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
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

    public function export_excel()
    {
        // Load library PHPExcel
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil model atau ambil data yang ingin diekspor
        $data = $this->Siswa_Model->export_siswa(); // Gantilah dengan method yang sesuai dari model Anda

        // Load library PHPExcel
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Your Name")
            ->setLastModifiedBy("Your Name")
            ->setTitle("Data Siswa")
            ->setSubject("Data Siswa")
            ->setDescription("Data Siswa")
            ->setKeywords("excel phpexcel php codeigniter")
            ->setCategory("Data Siswa");

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

        $sheet->setCellValue('A1', 'DATA SISWA');
        $sheet->setCellValue('A2', 'SMP ISLAM DARUT TAUFIQ');
        $sheet->setCellValue('A3', 'TAHUN AJARAN 2025');

        // Add data
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Username');
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'NIS');
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'NISN');
        $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Nama Siswa');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Jenis Kelamin');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Agama');
        $objPHPExcel->getActiveSheet()->setCellValue('H5', 'Tempat Lahir');
        $objPHPExcel->getActiveSheet()->setCellValue('I5', 'Tanggal Lahir');
        $objPHPExcel->getActiveSheet()->setCellValue('J5', 'Kode Kelas');
        $objPHPExcel->getActiveSheet()->setCellValue('K5', 'No. Absen');
        $objPHPExcel->getActiveSheet()->setCellValue('L5', 'Tahun Angkatan');
        $objPHPExcel->getActiveSheet()->setCellValue('M5', 'Anak ke-');
        $objPHPExcel->getActiveSheet()->setCellValue('N5', 'Jumlah Saudara');
        $objPHPExcel->getActiveSheet()->setCellValue('O5', 'Hobi');
        $objPHPExcel->getActiveSheet()->setCellValue('P5', 'Cita-cita');
        $objPHPExcel->getActiveSheet()->setCellValue('Q5', 'No. HP');
        $objPHPExcel->getActiveSheet()->setCellValue('R5', 'Alamat');
        $objPHPExcel->getActiveSheet()->setCellValue('S5', 'Kelurahan');
        $objPHPExcel->getActiveSheet()->setCellValue('T5', 'Kecamatan');
        $objPHPExcel->getActiveSheet()->setCellValue('U5', 'Kabupaten');
        $objPHPExcel->getActiveSheet()->setCellValue('V5', 'Provinsi');
        $objPHPExcel->getActiveSheet()->setCellValue('W5', 'Jarak ke Sekolah');
        $objPHPExcel->getActiveSheet()->setCellValue('X5', 'Transportasi');
        $objPHPExcel->getActiveSheet()->setCellValue('Y5', 'Tinggal');
        $objPHPExcel->getActiveSheet()->setCellValue('Z5', 'Nama Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AA5', 'NIK Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AB5', 'Tempat Lahir Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AC5', 'Tanggal Lahir Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AD5', 'Agama Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AE5', 'Pendidikan Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AF5', 'Pekerjaan Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AG5', 'Penghasilan Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AH5', 'Alamat Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AI5', 'Kelurahan Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ5', 'Kecamatan Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AK5', 'Kabupaten Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AL5', 'Provinsi Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AM5', 'No. HP Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AN5', 'Status Ayah');
        $objPHPExcel->getActiveSheet()->setCellValue('AO5', 'Nama Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AP5', 'NIK Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ5', 'Tempat Lahir Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AR5', 'Tanggal Lahir Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AS5', 'Agama Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AT5', 'Pendidikan Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AU5', 'Pekerjaan Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AV5', 'Penghasilan Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AW5', 'Alamat Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AX5', 'Kelurahan Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AY5', 'Kecamatan Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ5', 'Kabupaten Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('BA5', 'Provinsi Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('BB5', 'No. HP Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('BC5', 'Status Ibu');
        $objPHPExcel->getActiveSheet()->setCellValue('BD5', 'Nama Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BE5', 'NIK Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BF5', 'Tempat Lahir Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BG5', 'Tanggal Lahir Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BH5', 'Agama Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BI5', 'Pendidikan Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BJ5', 'Pekerjaan Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BK5', 'Penghasilan Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BL5', 'Alamat Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BM5', 'Kelurahan Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BN5', 'Kecamatan Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BO5', 'Kabupaten Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BP5', 'Provinsi Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BQ5', 'No. HP Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BR5', 'Status Wali');
        $objPHPExcel->getActiveSheet()->setCellValue('BS5', 'Golongan Darah');
        $objPHPExcel->getActiveSheet()->setCellValue('BT5', 'Penyakit');
        $objPHPExcel->getActiveSheet()->setCellValue('BU5', 'Kelainan Jasmani');
        $objPHPExcel->getActiveSheet()->setCellValue('BV5', 'Tinggi Badan');
        $objPHPExcel->getActiveSheet()->setCellValue('BW5', 'Berat Badan');
        $objPHPExcel->getActiveSheet()->setCellValue('BX5', 'Asal Sekolah');
        $objPHPExcel->getActiveSheet()->setCellValue('BY5', 'No. Ijazah');
        $objPHPExcel->getActiveSheet()->setCellValue('BZ5', 'No. SKHU');
        $objPHPExcel->getActiveSheet()->setCellValue('CA5', 'Tanggal Lulus');
        $objPHPExcel->getActiveSheet()->setCellValue('CB5', 'Kesenian');
        $objPHPExcel->getActiveSheet()->setCellValue('CC5', 'Olahraga');
        $objPHPExcel->getActiveSheet()->setCellValue('CD5', 'Organisasi');
        $objPHPExcel->getActiveSheet()->setCellValue('CE5', 'Lain-lain');


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
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        // Lanjutkan dari kolom Y sampai CE
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);
        $sheet->getColumnDimension('AA')->setAutoSize(true);
        $sheet->getColumnDimension('AB')->setAutoSize(true);
        $sheet->getColumnDimension('AC')->setAutoSize(true);
        $sheet->getColumnDimension('AD')->setAutoSize(true);
        $sheet->getColumnDimension('AE')->setAutoSize(true);
        $sheet->getColumnDimension('AF')->setAutoSize(true);
        $sheet->getColumnDimension('AG')->setAutoSize(true);
        $sheet->getColumnDimension('AH')->setAutoSize(true);
        $sheet->getColumnDimension('AI')->setAutoSize(true);
        $sheet->getColumnDimension('AJ')->setAutoSize(true);
        $sheet->getColumnDimension('AK')->setAutoSize(true);
        $sheet->getColumnDimension('AL')->setAutoSize(true);
        $sheet->getColumnDimension('AM')->setAutoSize(true);
        $sheet->getColumnDimension('AN')->setAutoSize(true);
        $sheet->getColumnDimension('AO')->setAutoSize(true);
        $sheet->getColumnDimension('AP')->setAutoSize(true);
        $sheet->getColumnDimension('AQ')->setAutoSize(true);
        $sheet->getColumnDimension('AR')->setAutoSize(true);
        $sheet->getColumnDimension('AS')->setAutoSize(true);
        $sheet->getColumnDimension('AT')->setAutoSize(true);
        $sheet->getColumnDimension('AU')->setAutoSize(true);
        $sheet->getColumnDimension('AV')->setAutoSize(true);
        $sheet->getColumnDimension('AW')->setAutoSize(true);
        $sheet->getColumnDimension('AX')->setAutoSize(true);
        $sheet->getColumnDimension('AY')->setAutoSize(true);
        $sheet->getColumnDimension('AZ')->setAutoSize(true);
        $sheet->getColumnDimension('BA')->setAutoSize(true);
        $sheet->getColumnDimension('BB')->setAutoSize(true);
        $sheet->getColumnDimension('BC')->setAutoSize(true);
        $sheet->getColumnDimension('BD')->setAutoSize(true);
        $sheet->getColumnDimension('BE')->setAutoSize(true);
        $sheet->getColumnDimension('BF')->setAutoSize(true);
        $sheet->getColumnDimension('BG')->setAutoSize(true);
        $sheet->getColumnDimension('BH')->setAutoSize(true);
        $sheet->getColumnDimension('BI')->setAutoSize(true);
        $sheet->getColumnDimension('BJ')->setAutoSize(true);
        $sheet->getColumnDimension('BK')->setAutoSize(true);
        $sheet->getColumnDimension('BL')->setAutoSize(true);
        $sheet->getColumnDimension('BM')->setAutoSize(true);
        $sheet->getColumnDimension('BN')->setAutoSize(true);
        $sheet->getColumnDimension('BO')->setAutoSize(true);
        $sheet->getColumnDimension('BP')->setAutoSize(true);
        $sheet->getColumnDimension('BQ')->setAutoSize(true);
        $sheet->getColumnDimension('BR')->setAutoSize(true);
        $sheet->getColumnDimension('BS')->setAutoSize(true);
        $sheet->getColumnDimension('BT')->setAutoSize(true);
        $sheet->getColumnDimension('BU')->setAutoSize(true);
        $sheet->getColumnDimension('BV')->setAutoSize(true);
        $sheet->getColumnDimension('BW')->setAutoSize(true);
        $sheet->getColumnDimension('BX')->setAutoSize(true);
        $sheet->getColumnDimension('BY')->setAutoSize(true);
        $sheet->getColumnDimension('BZ')->setAutoSize(true);
        $sheet->getColumnDimension('CA')->setAutoSize(true);
        $sheet->getColumnDimension('CB')->setAutoSize(true);
        $sheet->getColumnDimension('CC')->setAutoSize(true);
        $sheet->getColumnDimension('CD')->setAutoSize(true);
        $sheet->getColumnDimension('CE')->setAutoSize(true);


        $row = 6; // Mulai dari baris kedua untuk data
        $no = 1; // Inisialisasi nomor urut
        foreach ($data as $row_data) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $row_data['username']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $row_data['nis']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $row_data['nisn']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $row_data['nama_siswa']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $row_data['jeniskelamin']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $row_data['agama']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $row_data['tempatlahir']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $this->formatTanggalIndo($row_data['tanggallahir']));
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $row_data['kode_kelas']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $row_data['no_absen']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $row_data['tahun_angkatan']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $row_data['anakke']);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $row_data['jumlahsaudara']);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $row_data['hobi']);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $row_data['citacita']);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $row_data['nohp']);
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $row_data['siswa_alamat']);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $row_data['siswa_kelurahan']);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $row_data['siswa_kecamatan']);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $row_data['siswa_kabupaten']);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, $row_data['siswa_provinsi']);
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $row, $row_data['siswa_jaraksekolah']);
            $objPHPExcel->getActiveSheet()->setCellValue('X' . $row, $row_data['siswa_transportasi']);
            $objPHPExcel->getActiveSheet()->setCellValue('Y' . $row, $row_data['siswa_tinggal']);
            $objPHPExcel->getActiveSheet()->setCellValue('Z' . $row, $row_data['ayah_nama']);
            $objPHPExcel->getActiveSheet()->setCellValue('AA' . $row, $row_data['ayah_nik']);
            $objPHPExcel->getActiveSheet()->setCellValue('AB' . $row, $row_data['ayah_tempatlahir']);
            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $row, $this->formatTanggalIndo($row_data['ayah_tanggallahir']));
            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $row, $row_data['ayah_agama']);
            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $row, $row_data['ayah_pendidikan']);
            $objPHPExcel->getActiveSheet()->setCellValue('AF' . $row, $row_data['ayah_pekerjaan']);
            $objPHPExcel->getActiveSheet()->setCellValue('AG' . $row, $row_data['ayah_penghasilan']);
            $objPHPExcel->getActiveSheet()->setCellValue('AH' . $row, $row_data['ayah_alamat']);
            $objPHPExcel->getActiveSheet()->setCellValue('AI' . $row, $row_data['ayah_desakel']);
            $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $row, $row_data['ayah_kecamatan']);
            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $row, $row_data['ayah_kabupaten']);
            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $row, $row_data['ayah_provinsi']);
            $objPHPExcel->getActiveSheet()->setCellValue('AM' . $row, $row_data['ayah_nohp']);
            $objPHPExcel->getActiveSheet()->setCellValue('AN' . $row, $row_data['ayah_status']);
            $objPHPExcel->getActiveSheet()->setCellValue('AO' . $row, $row_data['ibu_nama']);
            $objPHPExcel->getActiveSheet()->setCellValue('AP' . $row, $row_data['ibu_nik']);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $row, $row_data['ibu_tempatlahir']);
            $objPHPExcel->getActiveSheet()->setCellValue('AR' . $row, $this->formatTanggalIndo($row_data['ibu_tanggallahir']));
            $objPHPExcel->getActiveSheet()->setCellValue('AS' . $row, $row_data['ibu_agama']);
            $objPHPExcel->getActiveSheet()->setCellValue('AT' . $row, $row_data['ibu_pendidikan']);
            $objPHPExcel->getActiveSheet()->setCellValue('AU' . $row, $row_data['ibu_pekerjaan']);
            $objPHPExcel->getActiveSheet()->setCellValue('AV' . $row, $row_data['ibu_penghasilan']);
            $objPHPExcel->getActiveSheet()->setCellValue('AW' . $row, $row_data['ibu_alamat']);
            $objPHPExcel->getActiveSheet()->setCellValue('AX' . $row, $row_data['ibu_desakel']);
            $objPHPExcel->getActiveSheet()->setCellValue('AY' . $row, $row_data['ibu_kecamatan']);
            $objPHPExcel->getActiveSheet()->setCellValue('AZ' . $row, $row_data['ibu_kabupaten']);
            $objPHPExcel->getActiveSheet()->setCellValue('BA' . $row, $row_data['ibu_provinsi']);
            $objPHPExcel->getActiveSheet()->setCellValue('BB' . $row, $row_data['ibu_nohp']);
            $objPHPExcel->getActiveSheet()->setCellValue('BC' . $row, $row_data['ibu_status']);
            $objPHPExcel->getActiveSheet()->setCellValue('BD' . $row, $row_data['wali_nama']);
            $objPHPExcel->getActiveSheet()->setCellValue('BE' . $row, $row_data['wali_nik']);
            $objPHPExcel->getActiveSheet()->setCellValue('BF' . $row, $row_data['wali_tempatlahir']);
            $objPHPExcel->getActiveSheet()->setCellValue('BG' . $row, $this->formatTanggalIndo($row_data['wali_tanggallahir']));
            $objPHPExcel->getActiveSheet()->setCellValue('BH' . $row, $row_data['wali_agama']);
            $objPHPExcel->getActiveSheet()->setCellValue('BI' . $row, $row_data['wali_pendidikan']);
            $objPHPExcel->getActiveSheet()->setCellValue('BJ' . $row, $row_data['wali_pekerjaan']);
            $objPHPExcel->getActiveSheet()->setCellValue('BK' . $row, $row_data['wali_penghasilan']);
            $objPHPExcel->getActiveSheet()->setCellValue('BL' . $row, $row_data['wali_alamat']);
            $objPHPExcel->getActiveSheet()->setCellValue('BM' . $row, $row_data['wali_desakel']);
            $objPHPExcel->getActiveSheet()->setCellValue('BN' . $row, $row_data['wali_kecamatan']);
            $objPHPExcel->getActiveSheet()->setCellValue('BO' . $row, $row_data['wali_kabupaten']);
            $objPHPExcel->getActiveSheet()->setCellValue('BP' . $row, $row_data['wali_provinsi']);
            $objPHPExcel->getActiveSheet()->setCellValue('BQ' . $row, $row_data['wali_nohp']);
            $objPHPExcel->getActiveSheet()->setCellValue('BR' . $row, $row_data['wali_status']);
            $objPHPExcel->getActiveSheet()->setCellValue('BS' . $row, $row_data['pendukung_golongandarah']);
            $objPHPExcel->getActiveSheet()->setCellValue('BT' . $row, $row_data['pendukung_penyakit']);
            $objPHPExcel->getActiveSheet()->setCellValue('BU' . $row, $row_data['pendukung_kelainanjasmani']);
            $objPHPExcel->getActiveSheet()->setCellValue('BV' . $row, $row_data['pendukung_tinggibadan']);
            $objPHPExcel->getActiveSheet()->setCellValue('BW' . $row, $row_data['pendukung_beratbadan']);
            $objPHPExcel->getActiveSheet()->setCellValue('BX' . $row, $row_data['asal_sekolah']);
            $objPHPExcel->getActiveSheet()->setCellValue('BY' . $row, $row_data['asal_noijazah']);
            $objPHPExcel->getActiveSheet()->setCellValue('BZ' . $row, $row_data['asal_noskhu']);
            $objPHPExcel->getActiveSheet()->setCellValue('CA' . $row, $row_data['asal_tanggal']);
            $objPHPExcel->getActiveSheet()->setCellValue('CB' . $row, $row_data['kegemaran_kesenian']);
            $objPHPExcel->getActiveSheet()->setCellValue('CC' . $row, $row_data['kegemaran_olahraga']);
            $objPHPExcel->getActiveSheet()->setCellValue('CD' . $row, $row_data['kegemaran_organisasi']);
            $objPHPExcel->getActiveSheet()->setCellValue('CE' . $row, $row_data['kegemaran_lainlain']);

            $row++;
            $no++; // Tambahkan nomor urut

        }
        $sheet->getStyle('A5:CE' . ($row-1))->applyFromArray($Border);


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
        $sheet->getStyle('A5:CE5')->applyFromArray($headerStyle);

        // Atur tinggi baris header
        $sheet->getRowDimension(5)->setRowHeight(30); // Atur tinggi 30 point

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Data Siswa');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DataSiswa.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}
