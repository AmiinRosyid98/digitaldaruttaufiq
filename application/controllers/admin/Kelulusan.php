<?php

class Kelulusan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Kelas_Model');
        $this->load->model('Kelulusan_Model');
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


    public function datakelulusan()
    {
        $logo_data = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['current_user']   = $this->auth_admin->current_user();
        $data['siswa']          = $this->Kelulusan_Model->get_siswalulus();
        $data['kelas']          = $this->Kelas_Model->get_kelas();
        $data['tahunangkatan']  = $this->Tahunangkatan_Model->get_tahunangkatan();
        $this->load->view('admin/kelulusan', $data);
    }


    public function get_siswa_by_kelas($kelas_id)
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $limit = $this->input->get('perpage') ? $this->input->get('perpage') : 10;
        $offset = ($page - 1) * $limit;
        $tahun_angkatan = $this->input->get('tahun_angkatan');
        $siswa = $this->Kelulusan_Model->get_siswa_by_kelas_paginated($kelas_id, $tahun_angkatan, $limit, $offset);
        $total_siswa = $this->Kelulusan_Model->count_siswa_by_kelas($kelas_id);

        $response = array(
            'data' => $siswa,
            'total_pages' => ceil($total_siswa / $limit),
            'current_page' => $page
        );

        echo json_encode($response);
    }



    public function update_kode_kelas()
    {
        $siswa_ids      = $this->input->post('siswa_ids');
        $new_kelas_id   = $this->input->post('new_kelas_id');
        $updated_count  = 0;

        if (!empty($siswa_ids) && $new_kelas_id) {
            if (array_filter($siswa_ids, 'is_numeric') === $siswa_ids) {
                foreach ($siswa_ids as $siswa_id) {
                    $this->Kelulusan_Model->update_kode_kelas($siswa_id, $new_kelas_id);
                    $updated_count++;
                }

                $this->session->set_flashdata('success_message', 'Terdapat ' . $updated_count . ' Siswa Berhasil Di Update.');
                $response['success'] = true;
                $response['updated_count'] = $updated_count;
            } else {
                $this->session->set_flashdata('error_message', 'Gagal mengupdate kelas siswa.');
                $response['success'] = false;
            }
        } else {
            $this->session->set_flashdata('error_message', 'Data tidak lengkap.');
            $response['success'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }


    public function update_status_kelulusan()
    {
        $siswa_ids = $this->input->post('siswa_ids');
        $new_status = $this->input->post('new_status');
        $updated_count = 0;

        if (!empty($siswa_ids) && $new_status !== null) {
            if (array_filter($siswa_ids, 'is_numeric') === $siswa_ids) {
                foreach ($siswa_ids as $siswa_id) {
                    $this->Kelulusan_Model->update_status_kelulusan($siswa_id, $new_status);
                    $updated_count++;
                }

                $this->session->set_flashdata('success_message', 'Terdapat ' . $updated_count . ' Siswa Berhasil Di Update Status Kelulusan.');
                $response['success'] = true;
                $response['updated_count'] = $updated_count;
            } else {
                $this->session->set_flashdata('error_message', 'Gagal mengupdate status kelulusan siswa.');
                $response['success'] = false;
            }
        } else {
            $this->session->set_flashdata('error_message', 'Data tidak lengkap.');
            $response['success'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }



    public function settingskl()
    {
        $data['current_user'] = $this->auth_admin->current_user();
        $data['logo'] = $this->admin->get_logo()['logo'];
        $data['logopemerintah'] = $this->admin->get_logopemerintah()['logopemerintah'];
        $data['profilsekolah'] = $this->admin->get_profilsekolah_data();
        $data['templateskl'] = $this->Kelulusan_Model->get_settingskl();

        if ($this->input->post()) {
            $profilsekolah_data = array(
                'judul_skl'         => $this->input->post('judul_skl'),
                'no_skl'            => $this->input->post('no_skl'),
                'tgl_skl'           => $this->input->post('tgl_skl'),
                'target_time'       => $this->input->post('target_time'),
                'dasar_skl'         => $this->input->post('dasar_skl'),
                'isi_skl'           => $this->input->post('isi_skl'),
                'penutup_skl'       => $this->input->post('penutup_skl'),
                'status_pengumuman' => $this->input->post('status_pengumuman')
            );

            $update_result = $this->Kelulusan_Model->update_skl($profilsekolah_data);
            if ($update_result) {
                $this->session->set_flashdata('toast_message', 'Peraturan berhasil diperbarui');
            } else {
                $this->session->set_flashdata('toast_message', 'Tidak ada data yang diperbarui');
            }
            redirect('admin/kelulusan/settingskl');
        }

        // Memuat skrip CKEditor
        $ckeditor_script = '
        <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector("#dasar_skl"))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector("#isi_skl"))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector("#penutup_skl"))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    ';

        // Menambahkan skrip CKEditor ke dalam data
        $data['ckeditor_script'] = $ckeditor_script;

        // Memuat tampilan bersamaan dengan skrip CKEditor
        $this->load->view('admin/setting_skl', $data);
    }
}
