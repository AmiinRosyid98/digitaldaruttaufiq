<?php

class Berita extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Berita_Model');
        $this->load->model('auth_admin');
        $this->load->library('pagination');
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


    // FUNGSI TAHUN LIST BERITA
    public function listberita()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['listberita']     = $this->Berita_Model->get_listberita();
        $this->load->view('admin/berita/listberita', $data);
    }


    public function simpan_berita()
    {
        $this->load->library('form_validation');

        // Set rules untuk validasi form
        $this->form_validation->set_rules('judul_berita', 'Judul Berita', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('isi_berita', 'Isi Berita', 'required|trim|htmlspecialchars');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, set pesan error ke flashdata
            $this->session->set_flashdata('error_message', validation_errors());
            redirect('admin/berita/listberita');
        } else {
            // Konfigurasi upload gambar
            $config['upload_path'] = './upload/berita/';
            $config['allowed_types'] = 'jpg|jpeg|png|';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar_berita')) {
                // Jika upload gambar gagal, set pesan error ke flashdata
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error_message', $error);
            } else {
                // Jika upload gambar berhasil, ambil info gambar
                $upload_data = $this->upload->data();
                $gambar_berita = $upload_data['file_name'];

                // Ambil data dari input form
                $judul_berita   = $this->input->post('judul_berita');
                $isi_berita     = $this->input->post('isi_berita');
                $penulis_berita     = $this->input->post('penulis_berita');
                $tanggal_berita     = $this->input->post('tanggal_berita');

                // Siapkan data untuk disimpan ke database
                $insert_data = array(
                    'judul_berita'  => $judul_berita,
                    'isi_berita'    => $isi_berita,
                    'gambar_berita' => $gambar_berita,
                    'penulis_berita' => $penulis_berita,
                    'tanggal_berita' => $tanggal_berita
                );

                // Panggil model untuk menyimpan data
                $insert_result = $this->Berita_Model->simpan_berita($insert_data);
                if ($insert_result) {
                    // Jika penyimpanan berhasil, set pesan sukses ke flashdata
                    $this->session->set_flashdata('success_message', 'Data Berita berhasil disimpan.');
                } else {
                    // Jika penyimpanan gagal, set pesan error ke flashdata
                    $this->session->set_flashdata('error_message', 'Gagal menyimpan data Berita.');
                }
            }

            // Redirect kembali ke halaman listberita
            redirect('admin/berita/listberita');
        }
    }



    public function hapus_beritaa($berita_id)
    {
        $result = $this->Berita_Model->hapus_berita($berita_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Berita berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Berita.');
        }
        redirect('admin/berita/listberita');
    }


    public function hapus_berita($berita_id)
    {
        // Ambil informasi berita termasuk nama file gambar
        $berita = $this->Berita_Model->get_berita_by_id($berita_id);

        if (!$berita) {
            $this->session->set_flashdata('error_message', 'Berita tidak ditemukan.');
        } else {
            // Hapus file gambar jika ada
            $file_path = './upload/berita/' . $berita->gambar_berita;
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file gambar dari sistem file
            }

            // Hapus berita dari database
            $result = $this->Berita_Model->hapus_berita($berita_id);
            if ($result) {
                $this->session->set_flashdata('success_message', 'Berita berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menghapus Berita.');
            }
        }

        redirect('admin/berita/listberita');
    }
}
