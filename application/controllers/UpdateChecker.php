<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UpdateChecker extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url'); // Memuat URL helper
        $this->load->database(); // Memuat database
    }

    public function index()
    {
        // Mendapatkan versi saat ini dari database
        $data['current_version'] = $this->get_current_version();
        $this->load->view('update_checker_index', $data);
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
        $this->load->view('update_checker_index', $data);
    }

    public function upgrade()
    {
        $update_url = 'https://update.excode.my.id/update/get_version_info';

        // Mendapatkan informasi versi terbaru dari server
        $version_info = $this->get_remote_data($update_url);

        if ($version_info === false) {
            show_error('Gagal mendapatkan informasi versi terbaru.');
            return;
        }

        // Memeriksa apakah versi terbaru tersedia
        $remote_version = isset($version_info['version']) ? $version_info['version'] : null;
        if ($this->is_new_version($remote_version)) {
            $this->download_latest_version($version_info['file'], $remote_version);
        } else {
            echo 'Sudah menggunakan versi terbaru.';
        }
    }





    private function is_new_version($remote_version)
    {
        $current_version = $this->get_current_version(); // Mendapatkan versi saat ini dari database
        return version_compare($remote_version, $current_version, '>');
    }

    private function get_current_version()
    {
        $query = $this->db->get('version', 1);
        $result = $query->row();
        return $result ? $result->current_version : 'Tidak ada versi saat ini';
    }

    private function download_latest_version($file_url, $remote_version)
    {
        $new_file = './downloads/latest_version.zip'; // Path untuk menyimpan file, pastikan folder "downloads" ada dan memiliki izin tulis

        // Menggunakan curl untuk mendownload file
        $fp = fopen($new_file, 'w+');
        if (!$fp) {
            echo 'Gagal membuka file untuk menulis.';
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
            echo 'Gagal mendownload file: ' . $error;
            return;
        }

        // Lakukan ekstraksi file dan update sistem sesuai kebutuhan
        if ($this->extract_zip($new_file, './application')) {
            echo 'Update berhasil.';
            // Update versi di database
            $this->update_current_version($remote_version);
        } else {
            echo 'Update gagal.';
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
