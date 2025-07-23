<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_landing');
        $this->load->model('Absensi_Model');
        $this->load->model('admin');
        $this->load->model('auth_admin');
        $this->load->helper('url');

        $this->load->database();
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
        $total_guru         = $this->admin->total_guru();
        $total_siswa        = $this->admin->total_siswa();
        $total_siswalulus   = $this->admin->total_siswalulus();
        $total_kelas        = $this->admin->total_kelas();
        $logo_data          = $this->admin->get_logo();

        // Data yang akan dikirim ke view
        $data = [
            "current_user"      => $this->auth_admin->current_user(),
            "total_guru"        => $total_guru,
            "total_siswa"       => $total_siswa,
            "total_siswalulus"  => $total_siswalulus,
            "total_kelas"       => $total_kelas,
            "profilsekolah"     => $this->admin->get_profilsekolah_data(), // Ambil data perusahaan
            "templateabsen"     => $this->Absensi_Model->get_settingabsensi(), // Ambil data perusahaan
            "logo"              => $logo_data['logo'], // Mengirim data logo ke view
        ];

        $data['current_version'] = $this->get_current_version();
        $update_url = 'https://lisensi.saifudin.web.id/update/get_version_info';
        $version_info = $this->get_remote_data($update_url);

        // Memeriksa apakah versi terbaru tersedia
        $data['latest_version'] = isset($version_info['version']) ? $version_info['version'] : null;

        // Memuat view 'admin/dashboard.php' dan mengirimkan data ke view
        $this->load->view('/admin/dashboard', $data);
    }



    private function get_current_version()
    {
        $query = $this->db->get('version', 1);
        $result = $query->row();
        return $result ? $result->current_version : 'Tidak ada versi saat ini';
    }

    public function check_for_update()
    {
        $data['current_version'] = $this->get_current_version();
        $update_url = 'https://update.excode.my.id/update/get_version_info';

        // Mendapatkan informasi versi terbaru dari server
        $version_info = $this->get_remote_data($update_url);

        if ($version_info === false) {
            show_error('Gagal mendapatkan informasi versi terbaru.');
            return;
        }

        // Memeriksa apakah versi terbaru tersedia
        $data['latest_version'] = isset($version_info['version']) ? $version_info['version'] : null;

        // Muat view dengan data versi saat ini dan versi terbaru
        $this->load->view('admin/dashboard', $data);
    }

    public function upgrade()
    {
        $update_url = 'https://update.excode.my.id/update/get_version_info';

        // Mendapatkan informasi versi terbaru dari server
        $version_info = $this->get_remote_data($update_url);

        if ($version_info === false) {
            $message = 'Gagal mendapatkan informasi versi terbaru.';
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => $message]));
            return;
        }

        // Memeriksa apakah versi terbaru tersedia
        $remote_version = isset($version_info['version']) ? $version_info['version'] : null;
        if ($this->is_new_version($remote_version)) {
            $this->download_latest_version($version_info['file'], $remote_version);
            // Update berhasil
            $message = 'Upgrade berhasil, silahkan refresh Halaman.';
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true, 'message' => $message]));
        } else {
            $message = 'Sudah menggunakan versi terbaru. Silahkan Kembali';
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => $message]));
        }
    }

    private function is_new_version($remote_version)
    {
        $current_version = $this->get_current_version(); // Mendapatkan versi saat ini dari database
        return version_compare($remote_version, $current_version, '>');
    }

    private function download_latest_version($file_url, $remote_version)
    {
        $new_file = './downloads/latest_version.zip'; // Path untuk menyimpan file, pastikan folder "downloads" ada dan memiliki izin tulis

        // Menggunakan curl untuk mendownload file
        $fp = fopen($new_file, 'w+');
        if (!$fp) {
            $message = 'Gagal membuka file untuk menulis.';
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => $message]));
            return;
        }

        $ch = curl_init($file_url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $success = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        fclose($fp);

        if (!$success) {
            $message = 'Gagal mendownload file: ' . $error;
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => $message]));
            return;
        }

        // Lakukan ekstraksi file dan update sistem sesuai kebutuhan
        if ($this->extract_zip($new_file, './application')) {
            $message = 'Update berhasil.';
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true, 'message' => $message]));
            // Update versi di database
            $this->update_current_version($remote_version);
        } else {
            $message = 'Update gagal.';
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => $message]));
        }
    }

    private function extract_zip($zip_file, $extract_to)
    {
        $zip = new ZipArchive;
        if ($zip->open($zip_file) === TRUE) {
            $zip->extractTo($extract_to);
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    private function get_remote_data($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($data === false) {
            return false;
        }
        return json_decode($data, true);
    }

    private function update_current_version($new_version)
    {
        $this->db->where('id', 1);
        $this->db->update('version', ['current_version' => $new_version]);
    }
}
