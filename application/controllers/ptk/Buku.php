<?php

class Buku extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ptk');
        $this->load->model('Buku_Model');
        $this->load->model('Kelas_Model');
        $this->load->model('Auth_ptk');
        $this->load->library('pagination');
        $this->load->library('upload');
        if (!$this->Auth_ptk->current_user()) {
            redirect('auth/loginptk');
        }
    }


    public function index()
    {
        $current_user = $this->Auth_ptk->current_user();

        if ($current_user) {

            $id_guru                    = $current_user->id_guru;
            $data['profilsekolah']      = $this->Ptk->get_profilsekolah_data();
            $data['buku']               = $this->Buku_Model->get_buku($id_guru);
            $data['kelas']              = $this->Buku_Model->get_kelasmengajar($id_guru);
            $data['bukutimeline']       = $this->Buku_Model->get_bukutimeline($id_guru);
            $data['current_user']       = $current_user;
            $this->load->view('ptk/buku', $data);
        } else {
            redirect('auth/loginptk');
        }
    }

    public function simpan_buku()
    {
        $id_guru            = $this->input->post('id_guru');
        $kode_buku          = $this->input->post('kode_buku');
        $nama_buku          = $this->input->post('nama_buku');
        $terbitan           = $this->input->post('terbitan');
        $kode_kelas         = $this->input->post('kode_kelas');
        $file_buku          = $this->input->post('file_buku');
        $timestamp_buku     = $this->input->post('timestamp_buku');
        $upload_path        = './upload/filebuku/';

        // Validasi minimal satu checkbox dipilih
        if (empty($kode_kelas)) {
            $this->session->set_flashdata('error_message', 'Minimal satu kelas harus dipilih.');
        } else {
            // Pengaturan untuk unggahan file
            $config['upload_path']      = $upload_path;
            $config['allowed_types']    = 'pdf';
            $config['max_size']         = 70240;
            $config['file_name']        = 'buku_' . date('YmdHis');

            // Inisialisasi konfigurasi upload
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file_buku')) {
                // Jika gagal unggah file
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error_message', 'Gagal mengunggah file: ' . $error);
            } else {
                // Jika berhasil unggah file
                $upload_data = $this->upload->data();
                $file_path = $upload_data['file_name'];

                // Periksa apakah kode buku sudah ada
                $existing_kodebuku = $this->Buku_Model->get_buku_by_kodebuku($kode_buku);
                if ($existing_kodebuku) {
                    $this->session->set_flashdata('error_message', 'Kode Buku sudah Tersedia. Silakan Generate kode lain.');
                } else {
                    // Data untuk disimpan ke database
                    $insert_data = array(
                        'id_guru'      => $id_guru,
                        'kode_buku'    => $kode_buku,
                        'nama_buku'    => $nama_buku,
                        'terbitan'     => $terbitan,
                        'kode_kelas'   => implode(',', $kode_kelas),
                        'file_buku'    => $file_path
                    );

                    // Simpan data ke database
                    $insert_result = $this->Buku_Model->simpan_buku($insert_data);
                    if ($insert_result) {
                        $this->session->set_flashdata('success_message', 'Data Buku berhasil disimpan');
                    } else {
                        $this->session->set_flashdata('error_message', 'Gagal menyimpan data Buku');
                    }
                }
            }
        }

        // Load kembali halaman
        redirect('ptk/buku');
    }



    public function get_buku()
    {
        $buku_id   = $this->input->get('buku_id');
        $buku      = $this->Buku_Model->get_buku_by_id($buku_id);
        echo json_encode(array('buku' => $buku));
    }


    public function update_buku()
    {
        $buku_id   = $this->input->post('editBukuId');
        $data       = array(
            'nama_buku'   => $this->input->post('editNamaBuku')
        );
        $result = $this->Buku_Model->update_buku($buku_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Buku berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Buku');
            echo json_encode(array('success' => false));
        }
    }


    public function hapus_buku($buku_id)
    {
        // Dapatkan nama file buku dari database berdasarkan ID
        $file_buku = $this->Buku_Model->get_nama_file_buku_by_id($buku_id);

        // Hapus buku dari database
        $result = $this->Buku_Model->hapus_buku($buku_id);

        // Jika buku berhasil dihapus dari database
        if ($result) {
            // Hapus file buku dari direktori penyimpanan
            $upload_path = './upload/filebuku/';
            $file_path = $upload_path . $file_buku;

            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file dari direktori penyimpanan
            }

            $this->session->set_flashdata('success_message', 'Buku berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Buku.');
        }
        redirect('ptk/buku');
    }
}
