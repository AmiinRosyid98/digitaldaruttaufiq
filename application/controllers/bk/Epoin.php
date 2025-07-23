<?php

class Epoin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin');
        $this->load->model('Epoin_Model');
        $this->load->model('Auth_admin');
        $this->load->library('pagination');
        $this->load->library('upload');

        // Pemeriksaan apakah pengguna telah login
        $current_user = $this->Auth_admin->current_user();
        if (!$current_user) {
            // Simpan URL halaman sebelumnya
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginbk');
        }

        // Pemeriksaan apakah pengguna memiliki peran 'admin'
        if ($current_user->role != 'bk') {
            // Mengarahkan pengguna ke halaman kesalahan kustom
            $error_msg = 'Anda tidak diizinkan mengakses resources ini';
            show_error($error_msg, 403, 'Akses Ditolak');
        }
    }

    public function jenispelanggaran()
    {
        $logo_data                  = $this->Admin->get_logo();
        $data['current_user']       = $this->Auth_admin->current_user();
        $data['logo']               = $logo_data['logo'];
        $data['profilsekolah']      = $this->Admin->get_profilsekolah_data();
        $data['jenispelanggaran']   = $this->Epoin_Model->get_jenispelanggaran();
        $data['datasiswa']          = $this->Epoin_Model->get_siswa();

        $this->load->view('bk/jenispelanggaran', $data);
    }

    public function pelanggaran()
    {
        $logo_data                  = $this->Admin->get_logo();
        $data['current_user']       = $this->Auth_admin->current_user();
        $data['logo']               = $logo_data['logo'];
        $data['profilsekolah']      = $this->Admin->get_profilsekolah_data();
        $data['poinpelanggaran']    = $this->Epoin_Model->get_poinpelanggaran();
        $data['datasiswa']          = $this->Epoin_Model->get_siswa();
        $data['jenispelanggaran']    = $this->Epoin_Model->get_jenispelanggaran(); // Tambahkan ini

        $this->load->view('bk/poinpelanggaran', $data);
    }


    public function datasiswa()
    {
        $logo_data                  = $this->Admin->get_logo();
        $data['current_user']       = $this->Auth_admin->current_user();
        $data['logo']               = $logo_data['logo'];
        $data['profilsekolah']      = $this->Admin->get_profilsekolah_data();
        $data['poinpelanggaran']    = $this->Epoin_Model->get_totalpoinpelanggaran();
        $data['datasiswa']          = $this->Epoin_Model->get_siswa();

        $this->load->view('bk/datasiswa', $data);
    }


    public function cari_siswa()
    {
        $term = $this->input->get('term'); // Ambil kata kunci pencarian dari Ajax

        // Panggil model untuk mencari siswa berdasarkan nama
        $results = $this->Epoin_Model->cari_siswa($term);

        // Format data untuk autocomplete
        $data = array();
        foreach ($results as $row) {
            $data[] = array(
                'id' => $row['id_siswa'],
                'value' => $row['nama_siswa']
            );
        }

        echo json_encode($data); // Mengirimkan data dalam format JSON
    }

    public function simpan_jenispelanggaran()
    {
        // Ambil data yang dikirimkan dari form
        $nama_pelanggaran   = $this->input->post('nama_pelanggaran');
        $poin               = $this->input->post('poin');

        // Simpan data ke dalam database
        $insert_data = array(
            'nama_pelanggaran'  => $nama_pelanggaran,
            'poin'              => $poin
            // Tambahkan data lain yang perlu disimpan
        );

        $insert_result = $this->Epoin_Model->simpan_jenis_pelanggaran($insert_data);

        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Jenis pelanggaran berhasil disimpan');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan Jenis pelanggaran');
        }

        redirect('bk/epoin/jenispelanggaran'); // Redirect kembali ke halaman pelanggaran
    }



    public function simpan_pelanggaran()
    {
        // Ambil data yang dikirimkan dari form
        $id_siswa           = $this->input->post('id_siswa');
        $tanggal            = $this->input->post('tanggal');
        $poin               = $this->input->post('poin');
        $nama_pelanggaran   = $this->input->post('nama_pelanggaran');

        // Validasi data (contoh sederhana, sesuaikan dengan kebutuhan Anda)
        if (empty($id_siswa) || empty($poin) || empty($nama_pelanggaran)) {
            $this->session->set_flashdata('error_message', 'Semua kolom harus diisi');
            redirect('bk/epoin/pelanggaran'); // Redirect kembali ke halaman form
        }

        // Simpan data ke dalam database
        $insert_data = array(
            'id_siswa'          => $id_siswa,
            'tanggal'           => $tanggal,
            'poin'              => $poin,
            'nama_pelanggaran' => $nama_pelanggaran
            // Tambahkan data lain yang perlu disimpan
        );

        $insert_result = $this->Epoin_Model->simpan_data_pelanggaran($insert_data);

        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data pelanggaran berhasil disimpan');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data pelanggaran');
        }

        redirect('bk/epoin/pelanggaran'); // Redirect kembali ke halaman pelanggaran
    }


    public function hapus_jenispelanggaransiswa($pelanggaran_id)
    {
        $result = $this->Epoin_Model->hapus_jenispelanggaran($pelanggaran_id);
        if ($result) {
            $this->session->set_flashdata('success_message', 'Jenis pelanggaran berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Jenis pelanggaran.');
        }
        redirect('bk/epoin/jenispelanggaran');
    }


    public function hapus_pelanggaransiswa($pelanggaran_id)
    {
        $result = $this->Epoin_Model->hapus_poinpelanggaran($pelanggaran_id);
        if ($result) {
            $this->session->set_flashdata('success_message', 'Data pelanggaran berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Data pelanggaran.');
        }
        redirect('bk/epoin/pelanggaran');
    }
}
