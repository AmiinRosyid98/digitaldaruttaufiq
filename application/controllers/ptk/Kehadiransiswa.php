<?php

class Kehadiransiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ptk');
        $this->load->model('Absensi_Model');
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
        // Ambil nilai dari form jika ada
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $kelas_id = $this->input->get('kelas');

        // Set default tanggal jika kosong
        if (empty($start_date)) {
            $start_date = date('Y-m-d');
        }
        if (empty($end_date)) {
            $end_date = date('Y-m-d');
        }

        if ($current_user) {

            $id_guru                    = $current_user->id_guru;
            $data['profilsekolah']      = $this->Ptk->get_profilsekolah_data();
            $data['absensionline']      = $this->Absensi_Model->get_absensionline($start_date, $end_date, $kelas_id);
            $data['list_kelas']         = $this->Ptk->get_kelasmengajar($id_guru);
            $data['start_date']         = $start_date;
            $data['end_date']           = $end_date;
            $data['selected_kelas']     = $kelas_id;

            $data['current_user']       = $current_user;
            $this->load->view('ptk/kehadiransiswa', $data);
        } else {
            redirect('auth/loginptk');
        }
    }



    public function simpan_banksoal()
    {
        $id_guru = $this->input->post('id_guru');
        $nama_arsip = $this->input->post('nama_arsip');
        $upload_path = './upload/filebanksoal/';

        // Konfigurasi upload
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'pdf|doc|zip|rar|docx'; // Izinkan file pdf dan word
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
                'file_arsip' => $file_path
            );

            // Simpan data ke database
            $insert_result = $this->Arsip_Model->simpan_banksoal($insert_data);
            if ($insert_result) {
                $this->session->set_flashdata('success_message', 'Data Buku berhasil disimpan');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menyimpan data Buku');
            }
        }
        // Load kembali halaman
        redirect('ptk/filearsip/banksoal');
    }



    public function hapus_banksoal($banksoal_id)
    {
        $file_banksoal = $this->Arsip_Model->get_nama_file_buku_by_id($banksoal_id);

        // Hapus Banksoal dari database
        $result = $this->Arsip_Model->hapus_banksoal($banksoal_id);

        // Jika Banksoal berhasil dihapus dari database
        if ($result) {
            // Hapus file Banksoal dari direktori penyimpanan
            $upload_path = './upload/filebanksoal/';
            $file_path = $upload_path . $file_banksoal;

            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file dari direktori penyimpanan
            }

            $this->session->set_flashdata('success_message', 'Bank Soal berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Buku.');
        }
        redirect('ptk/filearsip/banksoal');
    }
}
