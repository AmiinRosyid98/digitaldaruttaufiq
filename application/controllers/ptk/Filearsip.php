<?php

class Filearsip extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ptk');
        $this->load->model('Arsip_Model');
        $this->load->model('Auth_ptk');
        $this->load->library('pagination');
        $this->load->library('upload');
        if (!$this->Auth_ptk->current_user()) {
            redirect('auth/loginptk');
        }
    }


    public function dokumen()
    {
        $current_user = $this->Auth_ptk->current_user();

        if ($current_user) {

            $id_guru                    = $current_user->id_guru;
            $data['profilsekolah']      = $this->Ptk->get_profilsekolah_data();
            $data['banksoal']           = $this->Arsip_Model->get_banksoal($id_guru);
            $data['banksoaltimeline']   = $this->Arsip_Model->get_banksoaltimeline($id_guru);
            $data['current_user']       = $current_user;
            $this->load->view('ptk/dokumen', $data);
        } else {
            redirect('auth/loginptk');
        }
    }



    public function simpan_banksoal()
    {
        $id_guru = $this->input->post('id_guru');
        $nama_arsip = $this->input->post('nama_arsip');
        $kategori = $this->input->post('kategori');
        $upload_path = './upload/dokumen/';

        // Konfigurasi upload
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'pdf|doc|zip|rar|docx|xlsx'; // Izinkan file pdf dan word
        $config['max_size'] = 70240; // Ukuran maksimal dalam KB
        $config['file_name'] = 'Banksoal' . date('YmdHis');

        // Inisialisasi konfigurasi upload
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file_arsip')) {
            // Jika gagal unggah file
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error_message', 'Gagal mengunggah file: ' . $error);
        } else {
            // Jika berhasil unggah file
            $upload_data = $this->upload->data();
            $file_path = $upload_data['file_name'];

            // Data untuk disimpan ke database
            $insert_data = array(
                'id_guru' => $id_guru,
                'nama_arsip' => $nama_arsip,
                'kategori' => $kategori,
                'file_arsip' => $file_path
            );

            // Simpan data ke database
            $insert_result = $this->Arsip_Model->simpan_banksoal($insert_data);
            if ($insert_result) {
                $this->session->set_flashdata('success_message', 'Data Dokumen berhasil disimpan');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menyimpan Dokumen');
            }
        }
        // Load kembali halaman
        redirect('ptk/filearsip/dokumen');
    }



    public function hapus_banksoal($banksoal_id)
    {
        $file_banksoal = $this->Arsip_Model->get_nama_file_buku_by_id($banksoal_id);

        // Hapus Banksoal dari database
        $result = $this->Arsip_Model->hapus_banksoal($banksoal_id);

        // Jika Banksoal berhasil dihapus dari database
        if ($result) {
            // Hapus file Banksoal dari direktori penyimpanan
            $upload_path = './upload/dokumen/';
            $file_path = $upload_path . $file_banksoal;

            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file dari direktori penyimpanan
            }

            $this->session->set_flashdata('success_message', 'Bank Soal berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Buku.');
        }
        redirect('ptk/filearsip/dokumen');
    }
}
