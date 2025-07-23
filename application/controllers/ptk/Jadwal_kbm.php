<?php

class Jadwal_kbm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ptk');
        $this->load->model('Jadwal_Model');
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
            $data['jadwalkbm']          = $this->Jadwal_Model->get_jadwalkbm($id_guru);
            $data['kelas']              = $this->Jadwal_Model->get_kelasmengajar($id_guru);
            $data['mapel']              = $this->Jadwal_Model->get_mapelmengajar($id_guru);

            $data['current_user']       = $current_user;

            // Memuat view dengan data yang sudah disiapkan
            $this->load->view('ptk/jadwalkbm', $data);
        } else {
            redirect('auth/loginptk');
        }
    }


    public function simpan_jadwalkbm()
    {
        $id_guru        = $this->input->post('id_guru');
        $hari           = $this->input->post('hari');
        $jam_mulai      = $this->input->post('jam_mulai');
        $jam_selesai    = $this->input->post('jam_selesai');
        $id_kelas       = $this->input->post('id_kelas');
        $id_mapel       = $this->input->post('id_mapel');

        $insert_data = array(
            'id_guru'      => $id_guru,
            'hari'         => $hari,
            'jam_mulai'    => $jam_mulai,
            'jam_selesai'  => $jam_selesai,
            'id_kelas'     => $id_kelas,
            'id_mapel'     => $id_mapel
        );
        $insert_result = $this->Jadwal_Model->simpanjadwalkbm($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Jadwal KBM berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan Jadwal KBM .');
        }
        redirect('ptk/Jadwal_kbm');
    }


    public function hapus_jadwalkbm($id)
    {
        $hapus = $this->Jadwal_Model->hapusjadwalkbm($id);
        if ($hapus) {
            $this->session->set_flashdata('success_message', 'Jadwal KBM berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Jadwal KBM.');
        }
        redirect('ptk/Jadwal_kbm');
    }



    public function update_jadwalkbm()
    {
        $id = $this->input->post('id');
        $data = array(
            'hari'      => $this->input->post('hari'),
            'id_kelas'  => $this->input->post('id_kelas'),
            'jam_mulai'  => $this->input->post('jam_mulai'),
            'jam_selesai'  => $this->input->post('jam_selesai'),

            'id_mapel'  => $this->input->post('id_mapel')
        );

        $update = $this->Jadwal_Model->update_jadwalkbm($id, $data);
        if ($update) {
            $this->session->set_flashdata('success_message', 'Jadwal KBM berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal memperbarui Jadwal KBM.');
        }

        redirect('ptk/Jadwal_kbm');
    }
}
