<?php

class Sistem extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('auth_admin');
        $this->load->model('Tahunpelajaran_Model');
        $this->load->library('upload');

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



    public function updatesistem()
    {
        // Mendapatkan data yang diperlukan untuk view
        $data['current_user']   = $this->auth_admin->current_user();
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $logo_datapemerintah    = $this->admin->get_logopemerintah();
        $data['logopemerintah'] = $logo_datapemerintah['logopemerintah'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['tahunpelajaran'] = $this->Tahunpelajaran_Model->get_tahunpelajaran();

        // Ambil nilai NPSN dari data profil sekolah
        $kode_sekolah = isset($data['profilsekolah']['npsn']) ? $data['profilsekolah']['npsn'] : null;

        // Periksa apakah NPSN tersedia
        if (!$kode_sekolah) {
            $this->showLicenseErrorPage('Data NPSN tidak tersedia atau tidak valid.');
            return;
        }

        // URL untuk memeriksa kode lisensi
        $update_url = 'https://lisensi.saifudin.web.id/lisensi_check/cek_kode_lisensi';
        $post_data = array('kode_sekolah' => $kode_sekolah);

        // Inisialisasi curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $update_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Eksekusi curl dan simpan respons
        $response = curl_exec($ch);

        // Periksa apakah ada error curl
        if ($response === false) {
            $error_message = 'Gagal terhubung ke server lisensi: ' . htmlspecialchars(curl_error($ch), ENT_QUOTES, 'UTF-8');
            curl_close($ch);
            $this->showLicenseErrorPage($error_message);
            return;
        }

        // Dapatkan kode HTTP dan tutup curl
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Proses respons
        if ($http_code >= 400) {
            $this->showLicenseErrorPage('Kode lisensi tidak valid atau tidak ditemukan.', true);
            return;
        }

        $result = json_decode($response, true);
        if (!$result || !isset($result['status'])) {
            $this->showLicenseErrorPage('Respon server tidak valid.', true);
            return;
        }

        if ($result['status'] != 'success') {
            $this->showLicenseErrorPage('Kode lisensi tidak valid atau tidak ditemukan. Silahkan Beli/Perbaharui Lisensi anda (082183930485)', true);
            return;
        }

        // Kode lisensi valid, lanjutkan dengan memperbarui data perusahaan jika ada input POST
        if ($this->input->post()) {
            $profilsekolah_data = array(
                'npsn'                  => htmlspecialchars($this->input->post('npsn'), ENT_QUOTES, 'UTF-8'),
                'nama_lembaga'          => htmlspecialchars($this->input->post('nama_lembaga'), ENT_QUOTES, 'UTF-8'),
                'naungan_lembaga'       => htmlspecialchars($this->input->post('naungan_lembaga'), ENT_QUOTES, 'UTF-8'),
                'status_lembaga'        => htmlspecialchars($this->input->post('status_lembaga'), ENT_QUOTES, 'UTF-8'),
                'pemerintah_lembaga'    => htmlspecialchars($this->input->post('pemerintah_lembaga'), ENT_QUOTES, 'UTF-8'),
                'tahun_pelajaran'       => htmlspecialchars($this->input->post('tahun_pelajaran'), ENT_QUOTES, 'UTF-8'),
                'alamat_lembaga'        => htmlspecialchars($this->input->post('alamat_lembaga'), ENT_QUOTES, 'UTF-8'),
                'kab_lembaga'           => htmlspecialchars($this->input->post('kab_lembaga'), ENT_QUOTES, 'UTF-8'),
                'prov_lembaga'          => htmlspecialchars($this->input->post('prov_lembaga'), ENT_QUOTES, 'UTF-8'),
                'kodepos_lembaga'       => htmlspecialchars($this->input->post('kodepos_lembaga'), ENT_QUOTES, 'UTF-8'),
                'notelp_lembaga'        => htmlspecialchars($this->input->post('notelp_lembaga'), ENT_QUOTES, 'UTF-8'),
                'nama_kepsek'           => htmlspecialchars($this->input->post('nama_kepsek'), ENT_QUOTES, 'UTF-8'),
                'nip_kepsek'            => htmlspecialchars($this->input->post('nip_kepsek'), ENT_QUOTES, 'UTF-8'),
                'email_lembaga'         => htmlspecialchars($this->input->post('email_lembaga'), ENT_QUOTES, 'UTF-8'),
                'website_lembaga'       => htmlspecialchars($this->input->post('website_lembaga'), ENT_QUOTES, 'UTF-8'),
                'menu_active'           => htmlspecialchars($this->input->post('menu_active'), ENT_QUOTES, 'UTF-8'),
                'bg_active'             => htmlspecialchars($this->input->post('bg_active'), ENT_QUOTES, 'UTF-8')
            );

            $update_result = $this->admin->update_perusahaan($profilsekolah_data);

            // Set flashdata berdasarkan hasil update
            if ($update_result) {
                $this->session->set_flashdata('toast_message', 'Data Lembaga berhasil diperbarui');
            } else {
                $this->session->set_flashdata('toast_message', 'Tidak ada data yang diperbarui');
            }

            // Redirect kembali ke halaman yang sama
            redirect('admin/sistem/updatesistem');
        }

        // Load view jika tidak ada input POST atau setelah validasi lisensi
        $this->load->view('admin/sistem', $data);
    }


    public function update_logo()
    {
        // Tentukan direktori untuk menyimpan logo
        $upload_path = './assets/web/';
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['file_name'] = '_' . $_FILES['logo']['name']; // Nama file dengan format ID_pengguna_nama_file
        $this->upload->initialize($config);

        // Lakukan proses upload
        if ($this->upload->do_upload('logo')) {
            $upload_data = $this->upload->data();

            // Simpan nama file ke dalam database
            $this->admin->update_logo($config['file_name']);

            // Redirect ke halaman profil atau tampilkan pesan sukses
            $this->session->set_flashdata('success', 'logo berhasil diperbarui.');
            redirect('admin/sistem/updatesistem');
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect('admin/sistem/updatesistem');
        }
    }

    public function update_logopemerintah()
    {
        // Tentukan direktori untuk menyimpan logo
        $upload_path = './assets/pemerintah/';
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['file_name'] = '_' . $_FILES['logopemerintah']['name']; // Nama file dengan format ID_pengguna_nama_file
        $this->upload->initialize($config);

        // Lakukan proses upload
        if ($this->upload->do_upload('logopemerintah')) {
            $upload_data = $this->upload->data();

            // Simpan nama file ke dalam database
            $this->admin->update_logopemerintah($config['file_name']);

            // Redirect ke halaman profil atau tampilkan pesan sukses
            $this->session->set_flashdata('success', 'logo berhasil diperbarui.');
            redirect('admin/sistem/updatesistem');
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect('admin/sistem/updatesistem');
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
