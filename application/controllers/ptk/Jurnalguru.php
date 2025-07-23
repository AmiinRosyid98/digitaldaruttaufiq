<?php

class Jurnalguru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ptk');
        $this->load->model('Jurnalguru_Model');
        $this->load->model('Auth_ptk');
        $this->load->library('pagination');
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
            $data['jurnal']             = $this->Jurnalguru_Model->get_jurnal($id_guru);
            $data['jurnalmaster']       = $this->Jurnalguru_Model->get_jurnalmaster($id_guru);
            $data['kelas']              = $this->Jurnalguru_Model->get_kelasmengajar($id_guru);
            $data['current_user']       = $current_user;
            // Memuat detail jurnal untuk setiap jurnalmaster
            $data['detailjurnal'] = array(); // Inisialisasi array untuk detail jurnal

            foreach ($data['jurnalmaster'] as $master) {
                $id_master = $master['id']; // Ambil id_master dari setiap jurnalmaster
                $data['detailjurnal'][$id_master] = $this->Jurnalguru_Model->get_jurnal_by_masterjurnal($id_master);
            }

            // Memuat view dengan data yang sudah disiapkan
            $this->load->view('ptk/jurnalguru', $data);
        } else {
            redirect('auth/loginptk');
        }
    }

    public function simpan_jurnalmaster()
    {
        $id_guru        = $this->input->post('id_guru');
        $kelas          = $this->input->post('kelas');
        $kode_master    = $this->input->post('kode_master');

        $insert_data = array(
            'id_guru'       => $id_guru,
            'kelas'         => $kelas,
            'kode_master'   => $kode_master
        );
        $insert_result = $this->Jurnalguru_Model->simpan_jurnalmaster($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Master Jurnal berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Master Jurnal .');
        }
        redirect('ptk/jurnalguru');
    }


    public function update_masterjurnal()
    {
        $jurnalmaster_id   = $this->input->post('editMasterjurnalId');
        $data              = array(
            'tanggal'      => $this->input->post('editTanggal'),
            'kelas'        => $this->input->post('editKelas')
        );
        $result = $this->Jurnalguru_Model->update_jurnalmaster($jurnalmaster_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Master Jurnal berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Master Jurnal');
            echo json_encode(array('success' => false));
        }
    }




    public function hapus_jurnalmaster($jurnalmaster_id)
    {
        if (is_null($jurnalmaster_id) || !is_numeric($jurnalmaster_id)) {
            $this->session->set_flashdata('error_message', 'ID Master Jurnal tidak valid.');
            redirect('ptk/jurnalguru');
            return;
        }

        $jurnalguru = $this->Jurnalguru_Model->get_masterjurnal_id($jurnalmaster_id);
        if ($jurnalguru && $this->Jurnalguru_Model->is_masterjurnal_digunakan($jurnalguru->id)) {
            $this->session->set_flashdata('error_message', 'Gagal menghapus  Karena masih terdapat Jurnal.');
        } else {
            $result = $this->Jurnalguru_Model->hapus_jurnalmaster($jurnalmaster_id);
            if ($result) {
                $this->session->set_flashdata('success_message', 'Master Jurnal dihapus.');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menghapus Master Jurnal.');
            }
        }
        redirect('ptk/jurnalguru');
    }






















    public function get_masterjurnal()
    {
        $masterjurnal_id   = $this->input->get('masterjurnal_id');
        $jurnalmaster      = $this->Jurnalguru_Model->get_masterjurnal_by_id($masterjurnal_id);
        echo json_encode(array('jurnalmaster' => $jurnalmaster));
    }











    public function simpan_jurnal()
    {
        $tanggal          = $this->input->post('tanggal');
        $id_master        = $this->input->post('id_master');
        $id_guru          = $this->input->post('id_guru');
        $kompetensi       = $this->input->post('kompetensi');
        $materi           = $this->input->post('materi');
        $indikator        = $this->input->post('indikator');
        $mulaijamke       = $this->input->post('mulaijamke');
        $sampaijamke      = $this->input->post('sampaijamke');

        $insert_data = array(
            'tanggal'         => $tanggal,
            'id_master'       => $id_master,
            'id_guru'         => $id_guru,
            'kompetensi'      => $kompetensi,
            'materi'          => $materi,
            'indikator'       => $indikator,
            'mulaijamke'      => $mulaijamke,
            'sampaijamke'     => $sampaijamke
        );
        $insert_result = $this->Jurnalguru_Model->simpan_jurnal($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Jurnal Guru berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Jurnal Guru.');
        }
        redirect('ptk/jurnalguru');
    }



    public function cetak_jurnalguru($id_master)
    {
        require_once APPPATH . 'third_party/tcpdf/tcpdf.php';

        // Memuat model-model yang diperlukan
        $this->load->model('Admin');
        $this->load->model('Jurnalguru_Model');

        // Mengambil daftar siswa berdasarkan kode kelas yang diberikan

        $lembaga                = $this->Admin->get_profilsekolah_data();
        $tahunajaran            = $this->Jurnalguru_Model->get_profilsekolah_data();

        $logo_data              = $this->Admin->get_logo();
        $data['logo']           = base_url('assets/web/' . $logo_data['logo']);
        $data['logopemerintah'] = base_url('assets/pemerintah/' . $logo_data['logopemerintah']);
        $jurnalguru             = $this->Jurnalguru_Model->get_jurnal_by_masterjurnal($id_master);

        if (empty($jurnalguru)) {
            echo "Belum ada Jurnal yang ditemukan untuk kelas tersebut.";
            return;
        }


        // Memuat konten view ke dalam sebuah variabel
        $pdfContent = $this->load->view('ptk/cetak/laporanjurnalguru',  ['jurnalguru' => $jurnalguru, 'lembaga' => $lembaga, 'tahunajaran' => $tahunajaran, 'data' => $data], true);
        $pdf = new TCPDF('L', 'pt', 'LEGAL', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nama Anda');
        $pdf->SetTitle('Jurnal Guru');
        $pdf->SetSubject('Jurnal Guru');
        $pdf->SetKeywords('Jurnal Guru, PDF');
        $pdf->SetPrintHeader(false);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML($pdfContent, true, false, true, false, '');
        $pdf->Output('Jurnal_Guru.pdf', 'I');
    }


    public function hapus_jurnaldetail($jurnaldetail_id)
    {
        $result = $this->Jurnalguru_Model->hapus_jurnaldetail($jurnaldetail_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Jurnal berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Jurnal.');
        }
        redirect('ptk/jurnalguru');
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
