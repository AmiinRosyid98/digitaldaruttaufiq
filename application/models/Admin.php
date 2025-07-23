<?php
// File: application/models/Admin.php

class Admin extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "admin";
    const SESSION_KEY = 'admin_id';



    public function update_profile($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows() > 0;
    }


    public function update_avatar($user_id, $avatar_filename)
    {
        $data = array(
            'avatar' => $avatar_filename
        );

        $this->db->where('id', $user_id);
        $this->db->update($this->_table, $data);

        return $this->db->affected_rows() > 0;
    }

    public function update_logo($logo_filename)
    {
        $data = array(
            'logo' => $logo_filename
        );

        $this->db->update($this->_tableperusahaan, $data);

        return $this->db->affected_rows() > 0;
    }

    public function update_logopemerintah($logo_filename)
    {
        $data = array(
            'logopemerintah' => $logo_filename
        );

        $this->db->update($this->_tableperusahaan, $data);

        return $this->db->affected_rows() > 0;
    }




    //Fungsi Profil Sekolah
    public function get_profilsekolah_data()
    {
        return $this->db->get('perusahaan')->row_array();
    }

    public function update_perusahaan($profilsekolah_data)
    {
        $perusahaan_id = 1; // Gantilah dengan ID perusahaan yang sesuai
        $this->db->where('id', $perusahaan_id);
        return $this->db->update('perusahaan', $profilsekolah_data);
    }
    public function get_logo()
    {
        $query = $this->db->get($this->_tableperusahaan); // Mengambil data dari tabel
        return $query->row_array(); // Mengembalikan satu baris data sebagai array
    }

    public function get_logopemerintah()
    {
        $query = $this->db->get($this->_tableperusahaan); // Mengambil data dari tabel
        return $query->row_array(); // Mengembalikan satu baris data sebagai array
    }


    //Fungsi Siswa
    public function get_siswa()
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->order_by('nama_kelas', 'ASC');
        $this->db->order_by('no_absen');
        $query = $this->db->get();
        return $query->result_array();
    }



    public function simpan_siswa($data)
    {
        $this->db->insert('siswa', $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_siswa_by_id($siswa_id)
    {
        return $this->db->get_where('siswa', array('id' => $siswa_id))->row_array();
    }

    public function update_siswa($siswa_id, $data)
    {
        $this->db->where('id', $siswa_id);
        $this->db->update('siswa', $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapus_siswa($siswa_id)
    {
        $this->db->where('id', $siswa_id);
        $result = $this->db->delete('siswa');
        return $result;
    }




    //Fungsi Layanan
    public function get_layanan()
    {
        $query = $this->db->get('layanan');
        return $query->result_array();
    }

    public function simpan_layanan($data)
    {
        $this->db->insert('layanan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function check_layanan_exist($kode_layanan)
    {
        $this->db->where('kode_layanan', $kode_layanan);
        $layanan = $this->db->get('layanan')->row_array();
        return !empty($layanan);
    }

    public function get_layanan_by_id($layanan_id)
    {
        return $this->db->get_where('layanan', array('id_layanan' => $layanan_id))->row_array();
    }

    public function update_layanan($layanan_id, $data)
    {
        $this->db->where('id_layanan', $layanan_id);
        $this->db->update('layanan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapus_layanan($layanan_id)
    {
        $this->db->where('id_layanan', $layanan_id);
        $result = $this->db->delete('layanan');
        return $result;
    }






    //Total fitur bendahara
    public function total_poskeuangan()
    { // Hitung Total poskeuangan
        return $this->db->count_all('poskeuangan');
    }

    public function total_jenispembayaran()
    { // Hitung Total poskeuangan
        return $this->db->count_all('jenispembayaran');
    }

    public function total_tarifpembayaran()
    { // Hitung Total poskeuangan
        return $this->db->count_all('tarifpembayaran');
    }

    //Total fitur BK
    public function total_jenispelanggaran()
    { // Hitung Total poskeuangan
        return $this->db->count_all('jenispelanggaran');
    }

    //Total fitur BK
    public function total_pelanggaran()
    { // Hitung Total poskeuangan
        return $this->db->count_all('poinpelanggaran');
    }






    public function total_guru()
    { // Hitung Total guru
        return $this->db->count_all('ptk');
    }


    public function total_siswa()
    {
        // Hitung jumlah siswa dengan status_kelulusan 0
        $this->db->where('status_kelulusan', 0);
        return $this->db->count_all_results('siswa');
    }

    public function total_siswalulus()
    {
        // Hitung jumlah siswa dengan status_kelulusan 0
        $this->db->where('status_kelulusan', 1);
        return $this->db->count_all_results('siswa');
    }


    public function total_kelas()
    { // Hitung Total kelas
        return $this->db->count_all('kelas');
    }
}
