<?php

class Datakeuangan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Poskeuangan_Model');
        $this->load->model('auth_admin');
        $this->load->library('pagination');
        $this->load->library('upload');

        // Pemeriksaan apakah pengguna telah login
        $current_user = $this->auth_admin->current_user();
        if (!$current_user) {
            // Simpan URL halaman sebelumnya
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginbendahara');
        }

        // Pemeriksaan apakah pengguna memiliki peran 'admin'
        if ($current_user->role != 'bendahara') {
            // Mengarahkan pengguna ke halaman kesalahan kustom
            $error_msg = 'Anda tidak diizinkan mengakses resources ini';
            show_error($error_msg, 403, 'Akses Ditolak');
        }
    }

    public function poskeuangan()
    {
        $logo_data              = $this->admin->get_logo();
        $data['current_user']   = $this->auth_admin->current_user();
        $data['logo']           = $logo_data['logo'];
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['poskeuangan']    = $this->Poskeuangan_Model->get_poskeuangan();
        $this->load->view('bendahara/poskeuangan', $data);
    }


    public function get_poskeuangan()
    {
        $pos_id           = $this->input->get('pos_id');
        $poskeuangan      = $this->Poskeuangan_Model->get_poskeuangan_by_id($pos_id);
        echo json_encode(array('poskeuangan' => $poskeuangan));
    }


    public function simpan_poskeuangan()
    {
        $nama_pos    = $this->input->post('nama_pos');
        $ket_pos     = $this->input->post('ket_pos');

        $existing_pos = $this->Poskeuangan_Model->get_poskeuangan_by_nama($nama_pos);
        if ($existing_pos) {
            $this->session->set_flashdata('error_message', 'Pos Keuangan Telah Tersedia');
            redirect('bendahara/datakeuangan/poskeuangan');
            return;
        }
        $insert_data = array(
            'nama_pos'      => $nama_pos,
            'ket_pos'       => $ket_pos
        );
        $insert_result = $this->Poskeuangan_Model->simpan_poskeuangan($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data POS Keuangan berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data POS Keuangan.');
        }
        redirect('bendahara/datakeuangan/poskeuangan');
    }


    public function update_poskeuangan()
    {
        $pos_id     = $this->input->post('editPosId');
        $data       = array(
            'nama_pos'   => $this->input->post('editNamaPos'),
            'ket_pos'    => $this->input->post('editKeterangan')
        );
        $result = $this->Poskeuangan_Model->update_poskeuangan($pos_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data POS Keuangan berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan POS Keuangan');
            echo json_encode(array('success' => false));
        }
    }




    public function hapus_poskeuangan($pos_id)
    {
        if (is_null($pos_id) || !is_numeric($pos_id)) {
            $this->session->set_flashdata('error_message', 'ID Kelas tidak valid.');
            redirect('bendahara/datakeuangan/poskeuangan');
            return;
        }

        $jenispembayaran = $this->Poskeuangan_Model->get_poskeuangan_by_id($pos_id);
        if ($jenispembayaran && $this->Poskeuangan_Model->is_poskeuangan_digunakan($jenispembayaran->id_pos)) {
            $this->session->set_flashdata('error_message', 'Gagal menghapus  POS Keuangan karena masih digunakan pada jenis pembayaran.');
        } else {
            $result = $this->Poskeuangan_Model->hapus_poskeuangan($pos_id);
            if ($result) {
                $this->session->set_flashdata('success_message', ' POS Keuangan dihapus.');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menghapus  POS Keuangan.');
            }
        }
        redirect('bendahara/datakeuangan/poskeuangan');
    }











    public function jenispembayaran()
    {
        $logo_data                  = $this->admin->get_logo();
        $data['current_user']       = $this->auth_admin->current_user();
        $data['logo']               = $logo_data['logo'];
        $data['profilsekolah']      = $this->admin->get_profilsekolah_data();
        $data['jenispembayaran']    = $this->Poskeuangan_Model->get_jenispembayaran();
        $data['pos']                = $this->Poskeuangan_Model->get_poskeuangan();
        $data['tahunpelajaran']     = $this->Poskeuangan_Model->get_tahunpelajaran();
        $data['tipepembayaran']     = $this->Poskeuangan_Model->get_tipepembayaran();
        $data['kelas']              = $this->Poskeuangan_Model->get_kelas();

        $this->load->view('bendahara/jenispembayaran', $data);
    }


    public function simpan_jenispembayaran()
    {
        $kode_pos               = $this->input->post('kode_pos');
        $kode_tahunpelajaran    = $this->input->post('kode_tahunpelajaran');
        $tipe_pembayaran        = $this->input->post('tipe_pembayaran');

        $existing_jenispos = $this->Poskeuangan_Model->get_jenispembayaran_by_kode($kode_pos, $kode_tahunpelajaran);
        if ($existing_jenispos) {
            $this->session->set_flashdata('error_message', 'Jenis Pembayaran Telah Tersedia');
            redirect('bendahara/datakeuangan/jenispembayaran');
            return;
        }
        $insert_data = array(
            'kode_pos'              => $kode_pos,
            'kode_tahunpelajaran'   => $kode_tahunpelajaran,
            'tipe_pembayaran'       => $tipe_pembayaran
        );
        $insert_result = $this->Poskeuangan_Model->simpan_jenispembayaran($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Jenis Pembayaran berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Jenis Pembayaran.');
        }
        redirect('bendahara/datakeuangan/jenispembayaran');
    }


    public function hapus_jenispembayaran($jenispembayaran_id)
    {
        if (is_null($jenispembayaran_id) || !is_numeric($jenispembayaran_id)) {
            $this->session->set_flashdata('error_message', 'ID Kelas tidak valid.');
            redirect('bendahara/datakeuangan/jenispembayaran');
            return;
        }

        $jenispembayaran = $this->Poskeuangan_Model->get_jenispembayaran_by_id($jenispembayaran_id);
        if ($jenispembayaran && $this->Poskeuangan_Model->is_jenispembayaran_digunakan($jenispembayaran->id_jenispembayaran)) {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Jenis Pembayaran karena masih digunakan pada tarif pembayaran.');
        } else {
            $result = $this->Poskeuangan_Model->hapus_jenispembayaran($jenispembayaran_id);
            if ($result) {
                $this->session->set_flashdata('success_message', ' POS Keuangan dihapus.');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menghapus  POS Keuangan.');
            }
        }
        redirect('bendahara/datakeuangan/jenispembayaran');
    }






    public function tarifpembayaran()
    {
        $logo_data                  = $this->admin->get_logo();
        $data['current_user']       = $this->auth_admin->current_user();
        $data['logo']               = $logo_data['logo'];
        $data['profilsekolah']      = $this->admin->get_profilsekolah_data();
        $data['tarifpembayaran']    = $this->Poskeuangan_Model->get_tarifsiswa();

        $this->load->view('bendahara/tarifpembayaran', $data);
    }






    public function simpan_tarifpembayaran()
    {
        $kode_pembayaran = $this->input->post('kode_pembayaran');
        $jumlah_tarif    = $this->input->post('jumlah_tarif');
        $kode_kelas      = $this->input->post('kode_kelas');

        // Menghapus format rupiah dari jumlah_tarif
        $jumlah_tarif_clean = preg_replace('/\D/', '', $jumlah_tarif);

        // Validasi minimal satu kelas harus dipilih
        if (empty($kode_kelas)) {
            $this->session->set_flashdata('error_message', 'Minimal satu kelas harus dipilih.');
            redirect('bendahara/datakeuangan/tarifpembayaran');
            return;
        }

        // Validasi existing tarif pembayaran
        $existing_tarifpembayaran = array();
        foreach ($kode_kelas as $kelas) {
            $existing = $this->Poskeuangan_Model->get_tarifpembayaran_by_kode($kelas, $kode_pembayaran);
            if ($existing) {
                $existing_tarifpembayaran[] = $existing;
            }
        }

        if (!empty($existing_tarifpembayaran)) {
            $this->session->set_flashdata('error_message', 'Beberapa jenis pembayaran sudah tersedia untuk kelas yang dipilih.');
            // Anda bisa menambahkan lebih detail pesan error atau menampilkan detail existing tarif pembayaran
            redirect('bendahara/datakeuangan/tarifpembayaran');
            return;
        }

        // Jika semua validasi berhasil, simpan data tarif pembayaran
        $this->load->model('Poskeuangan_Model');

        $insert_data = array();
        foreach ($kode_kelas as $kelas) {
            $insert_data[] = array(
                'kode_pembayaran' => $kode_pembayaran,
                'jumlah_tarif' => $jumlah_tarif_clean,
                'kode_kelas' => $kelas
            );
        }

        $insert_result = $this->Poskeuangan_Model->simpan_tarifpembayaran($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data tarif pembayaran berhasil disimpan');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data tarif pembayaran');
        }

        redirect('bendahara/datakeuangan/tarifpembayaran');
    }


    public function hapus_tarifpembayaran($tarifpembayaran_id)
    {
        $result = $this->Poskeuangan_Model->hapus_tarifpembayaran($tarifpembayaran_id);
        if ($result) {
            $this->session->set_flashdata('success_message', 'Tarif Pembayaran berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Tarif pembayaran.');
        }
        redirect('bendahara/datakeuangan/tarifpembayaran');
    }
}
