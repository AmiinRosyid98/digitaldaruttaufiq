<?php

class Rombel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Kelas_Model');
        $this->load->model('Siswa_Model');
        $this->load->model('Rombel_Model');
        $this->load->model('Tahunangkatan_Model');
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
        $logo_data = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['current_user']   = $this->auth_admin->current_user();
        $data['siswa']          = $this->Siswa_Model->get_siswa();
        $data['kelas']          = $this->Kelas_Model->get_kelas();
        $data['tahunangkatan']  = $this->Tahunangkatan_Model->get_tahunangkatan();
        $this->load->view('admin/rombel', $data);
    }
    public function get_siswa_by_kelas($kelas_id)
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 1; // Ambil nomor halaman dari parameter GET, default ke 1 jika tidak ada
        $limit = $this->input->get('perpage') ? $this->input->get('perpage') : 10; // Ambil jumlah data per halaman dari parameter GET, default ke 10 jika tidak ada

        $offset = ($page - 1) * $limit; // Hitung offset berdasarkan nomor halaman dan jumlah data per halaman

        // Ambil data siswa berdasarkan kelas yang dipilih dengan batasan limit dan offset
        $siswa = $this->Rombel_Model->get_siswa_by_kelas_paginated($kelas_id, $limit, $offset);

        // Hitung total jumlah data siswa
        $total_siswa = $this->Rombel_Model->count_siswa_by_kelas($kelas_id);

        // Format respons sesuai dengan format yang diharapkan di sisi klien
        $response = array(
            'data' => $siswa,
            'total_pages' => ceil($total_siswa / $limit), // Hitung total halaman berdasarkan jumlah data siswa dan limit
            'current_page' => $page // Nomor halaman saat ini
        );

        // Ubah data siswa menjadi format JSON dan kirimkan sebagai respons
        echo json_encode($response);
    }

    public function update_kode_kelas()
    {
        // Tangani request untuk memperbarui kode_kelas siswa
        $siswa_ids      = $this->input->post('siswa_ids');
        $new_kelas_id   = $this->input->post('new_kelas_id');
        $updated_count  = 0; // Variabel untuk menyimpan jumlah data yang diupdate

        if (!empty($siswa_ids) && $new_kelas_id) {
            // Periksa apakah semua nilai siswa_ids adalah angka
            if (array_filter($siswa_ids, 'is_numeric') === $siswa_ids) {
                // Lakukan update kode_kelas untuk setiap siswa yang dipilih
                foreach ($siswa_ids as $siswa_id) {
                    $this->Rombel_Model->update_kode_kelas($siswa_id, $new_kelas_id);
                    $updated_count++; // Tambahkan 1 ke jumlah data yang diupdate
                }

                // Set flashdata untuk pesan sukses
                $this->session->set_flashdata('success_message', 'Terdapat ' . $updated_count . ' Siswa Berhasil Di Update.');
                $response['success'] = true;
                $response['updated_count'] = $updated_count; // Kirim kembali jumlah data yang diupdate
            } else {
                // Set flashdata untuk pesan error
                $this->session->set_flashdata('error_message', 'Gagal mengupdate kelas siswa.');
                $response['success'] = false;
            }
        } else {
            // Set flashdata untuk pesan error
            $this->session->set_flashdata('error_message', 'Data tidak lengkap.');
            $response['success'] = false;
        }

        // Kirim respons dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit; // Pastikan untuk keluar setelah mengirim respons
    }


    public function update_status_kelulusan()
    {
        // Tangani permintaan untuk memperbarui status kelulusan siswa
        $siswa_ids = $this->input->post('siswa_ids');
        $new_status = $this->input->post('new_status');
        $updated_count = 0; // Variabel untuk menyimpan jumlah data yang diupdate

        if (!empty($siswa_ids) && $new_status !== null) {
            // Periksa apakah semua nilai siswa_ids adalah angka
            if (array_filter($siswa_ids, 'is_numeric') === $siswa_ids) {
                // Lakukan update status kelulusan untuk setiap siswa yang dipilih
                foreach ($siswa_ids as $siswa_id) {
                    $this->Rombel_Model->update_status_kelulusan($siswa_id, $new_status);
                    $updated_count++; // Tambahkan 1 ke jumlah data yang diupdate
                }

                // Set flashdata untuk pesan sukses
                $this->session->set_flashdata('success_message', 'Terdapat ' . $updated_count . ' Siswa Berhasil Di Update Status Kelulusan.');
                $response['success'] = true;
                $response['updated_count'] = $updated_count; // Kirim kembali jumlah data yang diupdate
            } else {
                // Set flashdata untuk pesan error
                $this->session->set_flashdata('error_message', 'Gagal mengupdate status kelulusan siswa.');
                $response['success'] = false;
            }
        } else {
            // Set flashdata untuk pesan error
            $this->session->set_flashdata('error_message', 'Data tidak lengkap.');
            $response['success'] = false;
        }

        // Kirim respons dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit; // Pastikan untuk keluar setelah mengirim respons
    }
}
