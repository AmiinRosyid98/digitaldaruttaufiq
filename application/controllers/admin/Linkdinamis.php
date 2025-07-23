<?php

class Linkdinamis extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('linkdinamis_Model');
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

    public function index()
    {
        $logo_data                  = $this->admin->get_logo();
        $data['logo']               = $logo_data['logo'];
        $data['current_user']       = $this->auth_admin->current_user();
        $data['linkdinamis']        = $this->linkdinamis_Model->get_link();
        $data['profilsekolah']      = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/linkdinamis', $data);
    }

    public function simpan_linkdinamis()
    {
        $nama_link = $this->input->post('nama_link', true);
        $link = $this->input->post('link', true);
        $upload_path = './upload/logo_link/';

        // Konfigurasi upload
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 3048; // 2MB
        $config['file_name'] = 'LogoLink_' . date('YmdHis');

        // Inisialisasi konfigurasi upload
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('logo_link')) {
            // Jika gagal unggah file
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Gagal mengunggah logo: ' . $error);
        } else {
            // Jika berhasil unggah file
            $upload_data = $this->upload->data();
            $logo_link = $upload_data['file_name'];

            // Data untuk disimpan ke database
            $insert_data = array(
                'nama_link' => $nama_link,
                'link' => $link,
                'logo_link' => $logo_link
            );

            // Simpan data ke database
            $insert_result = $this->linkdinamis_Model->tambah_link($insert_data);
            if ($insert_result) {
                $this->session->set_flashdata('success_message', 'Data link berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menambahkan data link');
            }
        }

        // Redirect kembali ke halaman
        redirect('admin/linkdinamis');
    }


    public function update_linkdinamis()
    {
        $id = $this->input->post('id', true);
        $nama_link = $this->input->post('nama_link', true);
        $link = $this->input->post('link', true);
        $upload_path = './upload/logo_link/';

        $this->load->library('upload');

        // Cek apakah ada file baru diunggah
        if (!empty($_FILES['logo_link']['name'])) {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 3048; // 3MB
            $config['file_name'] = 'LogoLink_' . date('YmdHis');

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('logo_link')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error_message', 'Gagal mengunggah logo: ' . $error);
                redirect('admin/linkdinamis');
                return;
            }

            // Jika berhasil upload, ambil nama file dan simpan
            $upload_data = $this->upload->data();
            $logo_link = $upload_data['file_name'];

            // Hapus logo lama jika ada (opsional)
            $existing = $this->linkdinamis_Model->get_link_by_id($id);
            if ($existing && !empty($existing->logo_link) && file_exists($upload_path . $existing->logo_link)) {
                unlink($upload_path . $existing->logo_link);
            }

            // Data termasuk logo
            $update_data = array(
                'nama_link' => $nama_link,
                'link' => $link,
                'logo_link' => $logo_link
            );
        } else {
            // Data tanpa ganti logo
            $update_data = array(
                'nama_link' => $nama_link,
                'link' => $link
            );
        }

        // Simpan ke DB
        $update_result = $this->linkdinamis_Model->update_link($id, $update_data);
        if ($update_result) {
            $this->session->set_flashdata('success_message', 'Data link berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal memperbarui data link');
        }

        redirect('admin/linkdinamis');
    }



    public function hapus_link($id)
    {
        // Ambil data link yang akan dihapus
        $link = $this->linkdinamis_Model->get_link_by_id($id);

        if (!$link) {
            $this->session->set_flashdata('error', 'Data link tidak ditemukan');
            redirect('admin/linkdinamis');
        }

        // Hapus file logo jika ada
        if (!empty($link->logo_link)) {
            $file_path = './upload/logo_link/' . $link->logo_link;
            if (file_exists($file_path)) {
                @unlink($file_path);
            }
        }

        // Hapus data dari database
        $delete_result = $this->linkdinamis_Model->hapus_link($id);

        if ($delete_result) {
            $this->session->set_flashdata('success_delete_message', 'Data link berhasil dihapus');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus data link');
        }

        redirect('admin/linkdinamis');
    }
}
