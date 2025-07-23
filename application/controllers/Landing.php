<?php

class Landing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_landing');
        $this->load->model('Auth_siswa');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('user_agent');
        $this->load->dbutil();

        // Dapatkan nama database dari konfigurasi
        $database_name = $this->db->database;

        if (!$this->dbutil->database_exists($database_name)) {
            // Jika database tidak ada, arahkan ke halaman instalasi
            redirect('install');
        }

        // Daftar tabel yang perlu diperiksa
        $tables = array('admin', 'berita', 'buku');

        foreach ($tables as $table) {
            if (!$this->db->table_exists($table)) {
                // Jika salah satu tabel tidak ada, arahkan ke halaman instalasi
                redirect('install');
            }
        }
    }
    public function index($page = 1)
    {
        // var_dump("tes");die;
        // Ambil data site untuk mendapatkan NPSN
        $site_data = $this->Model_landing->get_site()->result();
        $kode_sekolah = isset($site_data[0]->npsn) ? $site_data[0]->npsn : null;

        // Periksa apakah NPSN tersedia
        if (!$kode_sekolah) {
            $this->showLicenseErrorPage('Data NPSN tidak tersedia atau tidak valid.');
            exit;
        }

        // Cek lisensi melalui API eksternal
        $update_url = 'https://lisensi.saifudin.web.id/lisensi_check/cek_kode_lisensi';
        $post_data = array('kode_sekolah' => $kode_sekolah);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $update_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout after 10 seconds

        $response = curl_exec($ch);

        if ($response === false) {
            $this->showLicenseErrorPage('Gagal terhubung ke server lisensi: ' . htmlspecialchars(curl_error($ch), ENT_QUOTES, 'UTF-8'), true);
            curl_close($ch);
            exit;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code >= 400) {
            $this->showLicenseErrorPage('Kode lisensi tidak valid atau tidak ditemukan.', true);
            exit;
        }

        $result = json_decode($response, true);
        if (!$result || !isset($result['status']) || $result['status'] !== 'success') {
            $this->showLicenseErrorPage('Kode lisensi tidak valid atau tidak ditemukan.', true);
            exit;
        }

        // Lanjutkan proses halaman jika lisensi valid
        $view = $this->agent->is_mobile() ? 'halaman_mobile' : 'halaman_landing';

        $config['base_url'] = base_url('landing/index');
        $config['total_rows'] = $this->Model_landing->count_all_books();
        $config['per_page'] = 6;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['num_tag_open'] = '<span class="page-link">';
        $config['num_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="page-link current">';
        $config['cur_tag_close'] = '</span>';
        $config['prev_tag_open'] = '<span class="page-link">';
        $config['prev_tag_close'] = '</span>';
        $config['next_tag_open'] = '<span class="page-link">';
        $config['next_tag_close'] = '</span>';
        $config['first_tag_open'] = '<span class="page-link">';
        $config['first_tag_close'] = '</span>';
        $config['last_tag_open'] = '<span class="page-link">';
        $config['last_tag_close'] = '</span>';

        $this->pagination->initialize($config);
        $offset = ($page - 1) * $config['per_page'];
        $books = $this->Model_landing->get_books($config['per_page'], $offset);

        $total_siswa    = $this->Model_landing->total_siswa();
        $total_guru     = $this->Model_landing->total_guru();
        $total_kelas    = $this->Model_landing->total_kelas();
        $total_alumni   = $this->Model_landing->total_alumni();
        $hobby_data     = $this->Model_landing->get_hobby_stats();

        $data = array(
            'data_site'             => $site_data,
            'versi'                 => $this->Model_landing->get_version()->result(),
            'pengumumankelulusan'   => $this->Model_landing->get_site_with_status()->result(),
            'portalppdb'            => $this->Model_landing->get_portalppdb_with_status()->result(),
            'portalkelulusan'       => $this->Model_landing->get_portalkelulusan_with_status()->result(),
            'berita'                => $this->Model_landing->get_berita()->result(),
            'dataguru'              => $this->Model_landing->get_guru()->result(),
            'link_dinamis'          => $this->Model_landing->get_link_dinamis()->result(),

            'hasil_pencarian'       => null,
            'pagination_links'      => $this->pagination->create_links(),
            'page'                  => $page,
            "total_siswa"           => $total_siswa,
            "total_guru"            => $total_guru,
            "total_kelas"           => $total_kelas,
            "total_alumni"          => $total_alumni,
            'hobby_stats'           => [
                'olahraga' => $hobby_data['hobbies'],
                'kesenian' => $hobby_data['talents']
            ],
            'books'                 => $books,
            'pagination_books'      => $this->pagination->create_links()
        );

        $this->load->view('landing/' . $view, $data);
    }











    // Halaman Informasi PPDB
    public function portalppdb()
    {
        // Load model dulu
        $this->load->model('Ppdb_Model');

        // Mendapatkan data situs
        $data['data_site'] = $this->Model_landing->get_site()->row();

        // Mendapatkan setting PPDB (Status Pendaftaran, tanggal selesai, dll)
        $data['setting'] = $this->Ppdb_Model->get_setting();

        // Mendapatkan jalur pendaftaran yang aktif
        $data['jalur'] = $this->Ppdb_Model->get_active_jalur();

        // Menambahkan total pendaftar berdasarkan jalur
        foreach ($data['jalur'] as &$jalur) {
            $total = $this->db->where('jalur_id', $jalur->id)
                ->count_all_results('ppdb_pendaftaran');
            $jalur->total_pendaftar = $total;
        }

        // Kirim data ke view
        $this->load->view('ppdb/header', $data);
        $this->load->view('ppdb/informasi', $data);
        $this->load->view('ppdb/footer');
    }

    // Halaman Sukses
    public function sukses($no_pendaftaran)
    {

        // Load model dulu
        $this->load->model('Ppdb_Model');

        $data['data_site'] = $this->Model_landing->get_site()->row();
        $data['pendaftaran'] = $this->Ppdb_Model->get_by_no($no_pendaftaran);

        $this->load->view('ppdb/header', $data);
        $this->load->view('ppdb/sukses', $data);
        $this->load->view('ppdb/footer');
    }

    // Form Pendaftaran
    public function daftar()
    {
        // Load model dulu
        $this->load->model('Ppdb_Model');

        $data['data_site'] = $this->Model_landing->get_site()->row();
        $setting = $this->Ppdb_Model->get_setting();
        $today = date('Y-m-d');

        // Cek periode pendaftaran
        if ($setting->status_ppdb != 1 || $today < $setting->tanggal_mulai || $today > $setting->tanggal_selesai) {
            $data['setting'] = $setting; // kirim setting ke view (kalau mau ditampilkan juga)
            $this->load->view('ppdb/header', $data);
            $this->load->view('ppdb/pendaftaran_tutup', $data); // <-- halaman baru di sini
            $this->load->view('ppdb/footer');
            return; // stop eksekusi agar tidak lanjut ke bawah
        }

        // Jika pendaftaran aktif dan dalam periode
        $data['setting'] = $setting;
        $data['jalur'] = $this->Ppdb_Model->get_active_jalur();

        $this->load->view('ppdb/header', $data);
        $this->load->view('ppdb/form_daftar', $data);
        $this->load->view('ppdb/footer');
    }


    // Proses Pendaftaran
    public function proses_daftar()
    {
        $this->load->model('Ppdb_Model');
        $this->load->helper(['string', 'form']); // <- pastikan form helper diload
        $this->load->library(['form_validation', 'upload']); // <- pastikan form_validation dan upload diload

        $setting = $this->Ppdb_Model->get_setting();

        if ($setting->status_ppdb != 1) {
            $this->session->set_flashdata('error', 'Pendaftaran PPDB saat ini tidak aktif');
            redirect('ppdb');
        }

        // Validasi form
        $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|exact_length[16]', [
            'required' => 'Silakan isi NIK Anda.',
            'numeric' => 'NIK harus berupa angka.',
            'exact_length' => 'NIK harus 16 digit.'
        ]);

        $this->form_validation->set_rules('no_kk', 'Nomor KK', 'required|numeric|exact_length[16]', [
            'required' => 'Silakan isi Nomor KK Anda.',
            'numeric' => 'Nomor KK harus berupa angka.',
            'exact_length' => 'Nomor KK harus 16 digit.'
        ]);

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required', ['required' => 'Silakan isi Nama Lengkap Anda.']);
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required', ['required' => 'Silakan isi Tempat Lahir Anda.']);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', ['required' => 'Silakan pilih Jenis Kelamin Anda.']);
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required', ['required' => 'Silakan isi Tanggal Lahir Anda.']);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => 'Silakan isi Alamat Anda.']);
        $this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'required', ['required' => 'Silakan isi Nama Ayah.']);
        $this->form_validation->set_rules('pekerjaan_ayah', 'Pekerjaan Ayah', 'required', ['required' => 'Silakan isi Pekerjaan Ayah.']);
        $this->form_validation->set_rules('nama_ibu', 'Nama Ibu', 'required', ['required' => 'Silakan isi Nama Ibu.']);
        $this->form_validation->set_rules('pekerjaan_ibu', 'Pekerjaan Ibu', 'required', ['required' => 'Silakan isi Pekerjaan Ibu.']);
        $this->form_validation->set_rules('telp_ortu', 'Telepon Orang Tua', 'required|numeric', [
            'required' => 'Silakan isi Nomor Telepon Orang Tua.',
            'numeric' => 'Telepon harus berupa angka.'
        ]);
        $this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required', ['required' => 'Silakan isi Asal Sekolah Anda.']);
        $this->form_validation->set_rules('jalur_id', 'Jalur Pendaftaran', 'required', ['required' => 'Silakan pilih Jalur Pendaftaran.']);

        if (empty($_FILES['foto_siswa']['name'])) {
            $this->form_validation->set_rules('foto_siswa', 'Foto Siswa', 'required', [
                'required' => 'Silakan upload Foto Siswa.'
            ]);
        }

        if ($this->form_validation->run() == FALSE) {
            $this->daftar();
        } else {
            $no_pendaftaran = 'PPDB' . date('Y') . strtoupper(random_string('alnum', 6));

            // Konversi tanggal lahir ke format Y-m-d
            $tanggal_lahir_input = $this->input->post('tanggal_lahir');
            $tanggal_lahir = null;
            if (!empty($tanggal_lahir_input)) {
                $parts = explode('/', $tanggal_lahir_input);
                if (count($parts) === 3) {
                    $tanggal_lahir = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                }
            }

            // Konfigurasi upload foto
            $config['upload_path'] = './upload/foto_siswa/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = 'foto_' . time();

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('foto_siswa')) {
                $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                redirect('landing/daftar');
            } else {
                $uploadData = $this->upload->data();
                $foto_siswa = $uploadData['file_name'];
            }

            $data = [
                'no_pendaftaran' => $no_pendaftaran,
                'nik' => $this->input->post('nik'),
                'no_kk' => $this->input->post('no_kk'),
                'nisn' => $this->input->post('nisn'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $tanggal_lahir,
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'agama' => $this->input->post('agama'),
                'status_ortu' => $this->input->post('status_ortu'),
                'anakke' => $this->input->post('anakke'),
                'jumlah_saudara' => $this->input->post('jumlah_saudara'),

                'asal_sekolah' => $this->input->post('asal_sekolah'),
                'alamat' => $this->input->post('alamat'),
                'rt' => $this->input->post('rt'),
                'rw' => $this->input->post('rw'),
                'kelurahan' => $this->input->post('kelurahan'),
                'kecamatan' => $this->input->post('kecamatan'),
                'kabupaten' => $this->input->post('kabupaten'),

                'nama_ayah' => $this->input->post('nama_ayah'),
                'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
                'pendidikan_ayah' => $this->input->post('pendidikan_ayah'),
                'nama_ibu' => $this->input->post('nama_ibu'),
                'pekerjaan_ibu' => $this->input->post('pekerjaan_ibu'),
                'pendidikan_ibu' => $this->input->post('pendidikan_ibu'),
                'telp_ortu' => $this->input->post('telp_ortu'),

                'no_peserta_ujian' => $this->input->post('no_peserta_ujian'),
                'rata_nilai_ijazah' => $this->input->post('rata_nilai_ijazah'),
                'prestasi' => $this->input->post('prestasi'),
                'tahun_lulus' => $this->input->post('tahun_lulus'),

                'foto_siswa' => $foto_siswa,
                'jalur_id' => $this->input->post('jalur_id'),
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->Ppdb_Model->create($data)) {
                redirect('landing/sukses/' . $no_pendaftaran);
            } else {
                $this->session->set_flashdata('error', 'Gagal melakukan pendaftaran.');
                redirect('landing/daftar');
            }
        }
    }





    // Cek Status
    public function cek_status()
    {

        // Load model dulu
        $this->load->model('Ppdb_Model');
        $data['data_site'] = $this->Model_landing->get_site()->row();

        if ($this->input->post('no_pendaftaran')) {
            $data['result'] = $this->Ppdb_Model->get_by_no($this->input->post('no_pendaftaran'));
        }

        $this->load->view('ppdb/header', $data);
        $this->load->view('ppdb/cek_status', $data ?? null);
        $this->load->view('ppdb/footer');
    }

























    public function portalkelulusan()
    {
        // Fungsi ini untuk menampilkan halaman portal kelulusan
        $data = array(
            'data_site' => $this->Model_landing->get_site()->result(),
            'kelulusan' => array(), // Data kelulusan awalnya kosong
            'target_time' => $this->_get_target_time() // Mendapatkan target time dari fungsi privat
        );

        // Load view 'portal_kelulusan' dengan data
        $this->load->view('landing/portal_kelulusan', $data);
    }

    private function _get_target_time()
    {
        // Mendapatkan target time dari database
        $target_time_data = $this->Model_landing->get_target_time();

        // Pastikan target_time valid sebelum digunakan
        if ($target_time_data && isset($target_time_data->target_time)) {
            return strtotime($target_time_data->target_time) * 1000; // Konversi ke milidetik untuk JavaScript
        } else {
            // Atur default target_time jika tidak ditemukan dari database
            return strtotime('2024-12-31T23:59:59') * 1000; // Misalnya
        }
    }


    // application/controllers/Landing.php


    public function cari_siswa()
    {
        if ($this->input->is_ajax_request()) {
            $nis = $this->input->post('nis');

            // Validasi NIS
            if (empty($nis)) {
                echo json_encode(['error' => 'NIS tidak boleh kosong']);
                return;
            }

            try {
                // Panggil model untuk melakukan pencarian siswa
                $kelulusan = $this->Model_landing->cari_siswa_dengan_nis($nis);

                // Mengatur header response
                header('Content-Type: application/json');

                // Menangani hasil pencarian
                if (empty($kelulusan)) {
                    echo json_encode(['error' => 'Siswa tidak ditemukan']);
                } else {
                    echo json_encode($kelulusan);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
        } else {
            show_404();
        }
    }


    private function showLicenseErrorPage($message, $showContact = false)
    {
        // HTML with styling for the error page
        $html = '
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error Lisensi</title>
            <style>
                body {
                    font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #f8f9fa;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    color: #343a40;
                }
                .error-container {
                    background-color: white;
                    border-radius: 10px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                    padding: 30px;
                    max-width: 600px;
                    width: 90%;
                    text-align: center;
                    border-top: 5px solid #dc3545;
                }
                .error-icon {
                    font-size: 60px;
                    color: #dc3545;
                    margin-bottom: 20px;
                }
                .error-title {
                    font-size: 24px;
                    font-weight: 600;
                    margin-bottom: 15px;
                    color: #dc3545;
                }
                .error-message {
                    font-size: 16px;
                    margin-bottom: 25px;
                    line-height: 1.6;
                }
                .contact-info {
                    background-color: #f8d7da;
                    padding: 15px;
                    border-radius: 5px;
                    margin-top: 20px;
                    display: ' . ($showContact ? 'block' : 'none') . ';
                }
                .contact-title {
                    font-weight: 600;
                    margin-bottom: 10px;
                }
                .whatsapp-btn {
                    display: inline-block;
                    background-color: #25D366;
                    color: white;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    margin-top: 15px;
                    font-weight: 500;
                    transition: background-color 0.3s;
                }
                .whatsapp-btn:hover {
                    background-color: #128C7E;
                }
                .action-btns {
                    margin-top: 25px;
                }
                .btn {
                    display: inline-block;
                    padding: 8px 16px;
                    margin: 0 5px;
                    border-radius: 4px;
                    text-decoration: none;
                    font-weight: 500;
                }
                .btn-primary {
                    background-color: #007bff;
                    color: white;
                }
                .btn-primary:hover {
                    background-color: #0069d9;
                }
                .btn-secondary {
                    background-color: #6c757d;
                    color: white;
                }
                .btn-secondary:hover {
                    background-color: #5a6268;
                }
            </style>
        </head>
        <body>
            <div class="error-container">
                <div class="error-icon">⚠️</div>
                <h1 class="error-title">Masalah Lisensi</h1>
                <div class="error-message">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</div>
                
                <div class="contact-info">
                    <div class="contact-title">Perlu Bantuan?</div>
                    <p>Hubungi tim support kami untuk memperbarui lisensi Anda</p>
                    <a href="https://wa.me/6282183930485" class="whatsapp-btn">
                        Hubungi via WhatsApp
                    </a>
                </div>
                
                <div class="action-btns">
                    <a href="javascript:location.reload()" class="btn btn-primary">Coba Lagi</a>
                    <a href="/" class="btn btn-secondary">Kembali ke Beranda</a>
                </div>
            </div>
        </body>
        </html>';

        echo $html;
    }
}
