<?php

class Masterdata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Kelas_Model');
        $this->load->model('Tingkat_Model');
        $this->load->model('Tahunangkatan_Model');
        $this->load->model('Tahunpelajaran_Model');
        $this->load->model('Mapel_Model');
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


    // FUNGSI TAHUN ANGKATAN
    public function tahunangkatan()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['tahunangkatan']  = $this->Tahunangkatan_Model->get_tahunangkatan();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/tahunangkatan', $data);
    }


    public function get_tahunangkatan()
    {
        $tahunangkatan_id   = $this->input->get('tahunangkatan_id');
        $tahunangkatan      = $this->Tahunangkatan_Model->get_tahunangkatan_by_id($tahunangkatan_id);
        echo json_encode(array('tahunangkatan' => $tahunangkatan));
    }


    public function simpan_tahunangkatan()
    {
        $tahun = $this->input->post('tahun');

        $existing_kelas = $this->Tahunangkatan_Model->get_tahunangkatan_by_tahun($tahun);
        if ($existing_kelas) {
            $this->session->set_flashdata('error_message', 'Tahun Angkatan Telah Tersedia. Silakan Ganti Tahun Angkatan lain.');
            redirect('admin/masterdata/tahunangkatan');
            return;
        }
        $insert_data = array(
            'tahun' => $tahun
        );
        $insert_result = $this->Tahunangkatan_Model->simpan_tahunangkatan($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Tahun Angkatan berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Tahun Angakatan.');
        }
        redirect('admin/masterdata/tahunangkatan');
    }


    public function update_tahunangkatan()
    {
        $tahunangkatan_id   = $this->input->post('editTahunAngkatanId');
        $data         = array(
            'tahun'     => $this->input->post('editTahunAngkatan')
        );
        $result = $this->Tahunangkatan_Model->update_tahunangkatan($tahunangkatan_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Tahun Angkatan berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Tahun Angkatan');
            echo json_encode(array('success' => false));
        }
    }


    public function hapus_tahunangkatan($tahun_id)
    {
        $result = $this->Tahunangkatan_Model->hapus_tahunangkatan($tahun_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Tahun Angkatan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Tahun Angkatan.');
        }
        redirect('admin/masterdata/tahunangkatan');
    }




    //FUNGSI TAHUN PELAJARAN
    public function tahunpelajaran()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['tahunpelajaran'] = $this->Tahunpelajaran_Model->get_tahunpelajaran();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/tahunpelajaran', $data);
    }

    public function get_tahunpelajaran()
    {
        $tahunpelajaran_id   = $this->input->get('tahunpelajaran_id');
        $tahunpelajaran      = $this->Tahunpelajaran_Model->get_tahunpelajaran_by_id($tahunpelajaran_id);
        echo json_encode(array('tahunpelajaran' => $tahunpelajaran));
    }


    public function simpan_tahunpelajaran()
    {
        $tahun_pelajaran = $this->input->post('tahun_pelajaran');

        $existing_tahunpelajaran = $this->Tahunpelajaran_Model->get_tahunpelajaran_by_tahun($tahun_pelajaran);
        if ($existing_tahunpelajaran) {
            $this->session->set_flashdata('error_message', 'Tahun Pelajaran Telah Tersedia. Silakan Ganti Tahun Pelajaran lain.');
            redirect('admin/masterdata/tahunpelajaran');
            return;
        }
        $insert_data = array(
            'tahun_pelajaran' => $tahun_pelajaran
        );
        $insert_result = $this->Tahunpelajaran_Model->simpan_tahunpelajaran($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Tahun Pelajaran berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Tahun Pelajaran.');
        }
        redirect('admin/masterdata/tahunpelajaran');
    }


    public function update_tahunpelajaran()
    {
        $tahunpelajaran_id   = $this->input->post('editTahunPelajaranId');
        $data         = array(
            'tahun_pelajaran'     => $this->input->post('editTahunPelajaran')
        );
        $result = $this->Tahunpelajaran_Model->update_tahunpelajaran($tahunpelajaran_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Tahun Pelajaran berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Tahun Pelajaran');
            echo json_encode(array('success' => false));
        }
    }


    public function hapus_tahupelajaran($tahunpelajaran_id)
    {
        $result = $this->Tahunpelajaran_Model->hapus_tahunpelajaran($tahunpelajaran_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Tahun Pelajaran berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Tahun Pelajaran.');
        }
        redirect('admin/masterdata/tahunpelajaran');
    }





    //FUNGSI TINGKAT
    public function tingkat()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['tingkat']        = $this->Tingkat_Model->get_tingkat();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/tingkat', $data);
    }


    public function get_tingkat()
    {
        $tingkat_id   = $this->input->get('tingkat_id');
        $tingkat      = $this->Tingkat_Model->get_tingkat_by_id($tingkat_id);
        echo json_encode(array('tingkat' => $tingkat));
    }


    public function simpan_tingkat()
    {
        $nama_tingkat = $this->input->post('nama_tingkat');
        $existing_tingkat = $this->Tingkat_Model->get_tingkat_by_nama($nama_tingkat);

        if ($existing_tingkat) {
            $this->session->set_flashdata('error_message', 'Tingkat sudah tersedia. Silakan gunakan nama tingkat lain.');
            redirect('admin/masterdata/tingkat');
            return;
        }

        $insert_data = array(
            'nama_tingkat' => $nama_tingkat
        );

        $insert_result = $this->Tingkat_Model->simpan_tingkat($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data tingkat berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data tingkat.');
        }

        redirect('admin/masterdata/tingkat');
    }

    public function update_tingkat()
    {
        $tingkat_id   = $this->input->post('editTingkatId');
        $data       = array(
            'nama_tingkat'     => $this->input->post('editNamaTingkat')
        );
        $result = $this->Tingkat_Model->update_tingkat($tingkat_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Tingkat berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Tingkat');
            echo json_encode(array('success' => false));
        }
    }

    public function hapus_tingkat($tingkat_id)
    {
        $result = $this->Tingkat_Model->hapus_tingkat($tingkat_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Tingkat berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Tingkat.');
        }
        redirect('admin/masterdata/tingkat');
    }








    // FUNGSI KELAS
    public function kelas()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['kelas']          = $this->Kelas_Model->get_kelas('nama_kelas');
        $data['tingkat']        = $this->Tingkat_Model->get_tingkat();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/kelas', $data);
    }


    public function get_kelas()
    {
        $kelas_id   = $this->input->get('kelas_id');
        $kelas      = $this->Kelas_Model->get_kelas_by_id($kelas_id);
        echo json_encode(array('kelas' => $kelas));
    }

    public function simpan_kelas()
    {
        $nama_kelas   = $this->input->post('nama_kelas');
        $no_kelas     = $this->input->post('no_kelas');
        $kode_tingkat = $this->input->post('kode_tingkat');

        $existing_kelas = $this->Kelas_Model->get_kelas_by_no($no_kelas);
        if ($existing_kelas) {
            $this->session->set_flashdata('error_message', 'Kode kelas sudah Tersedia. Silakan gunakan kode kelas lain.');
            redirect('admin/masterdata/kelas');
            return;
        }
        $insert_data = array(
            'nama_kelas'    => $nama_kelas,
            'no_kelas'      => $no_kelas,
            'kode_tingkat'  => $kode_tingkat
        );
        $insert_result = $this->Kelas_Model->simpan_kelas($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Kelas berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Kelas.');
        }
        redirect('admin/masterdata/kelas');
    }

    public function update_kelas()
    {
        $kelas_id   = $this->input->post('editKelasId');
        $data       = array(
            'nama_kelas'          => $this->input->post('editNamaKelas'),
            'kode_tingkat'        => $this->input->post('editKodeTingkat')
        );
        $result = $this->Kelas_Model->update_kelas($kelas_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Kelas berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Kelas');
            echo json_encode(array('success' => false));
        }
    }


    public function hapus_kelas($kelas_id)
    {
        if (is_null($kelas_id) || !is_numeric($kelas_id)) {
            $this->session->set_flashdata('error_message', 'ID Kelas tidak valid.');
            redirect('admin/masterdata/kelas');
            return;
        }

        // Coba hapus kelas
        $kelas = $this->Kelas_Model->get_kelas_by_id($kelas_id);
        if ($kelas && $this->Kelas_Model->is_kelas_digunakan($kelas->no_kelas)) {
            $this->session->set_flashdata('error_message', 'Gagal menghapus kelas karena masih digunakan oleh siswa.');
        } else {
            $result = $this->Kelas_Model->hapus_kelas($kelas_id);
            if ($result) {
                $this->session->set_flashdata('success_message', 'Kelas berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menghapus kelas.');
            }
        }
        redirect('admin/masterdata/kelas');
    }






    //FUNGSI MAPEL
    public function mapel()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['mapel']          = $this->Mapel_Model->get_mapel();

        $this->load->view('admin/mapel', $data);
    }


    public function get_mapel()
    {
        $mapel_id   = $this->input->get('mapel_id');
        $mapel      = $this->Mapel_Model->get_mapel_by_id($mapel_id);
        echo json_encode(array('mapel' => $mapel));
    }


    public function simpan_mapel()
    {
        $nama_mapel         = $this->input->post('nama_mapel');
        $kelompok_mapel     = $this->input->post('kelompok_mapel');
        $nourut_mapel       = $this->input->post('nourut_mapel');
        $existing_mapel     = $this->Mapel_Model->get_mapel_by_nama($nama_mapel);

        if ($existing_mapel) {
            $this->session->set_flashdata('error_message', 'Mapel sudah tersedia. Silakan gunakan nama Mapel lain.');
            redirect('admin/masterdata/mapel');
            return;
        }

        $insert_data = array(
            'nama_mapel'        => $nama_mapel,
            'kelompok_mapel'    => $kelompok_mapel,
            'nourut_mapel'      => $nourut_mapel
        );

        $insert_result = $this->Mapel_Model->simpan_mapel($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Mapel berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Mapel.');
        }

        redirect('admin/masterdata/mapel');
    }




    public function update_mapel()
    {
        $mapel_id   = $this->input->post('editMapelId');

        $data       = array(
            'nama_mapel'        => $this->input->post('editNamaMapel'),
            'kelompok_mapel'    => $this->input->post('editKelompokMapel'),
            'nourut_mapel'      => $this->input->post('editNourutMapel')

        );
        $result = $this->Mapel_Model->update_mapel($mapel_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Mapel berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Mapel');
            echo json_encode(array('success' => false));
        }
    }



    public function hapus_mapel($mapel_id)
    {
        $result = $this->Mapel_Model->hapus_mapel($mapel_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Mapel berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Mapel.');
        }
        redirect('admin/masterdata/mapel');
    }
}
