<?php
// File: application/models/Admin.php

class Ebook_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "admin";
    private $_tablekelas = "buku";
    const SESSION_KEY = 'admin_id';



    public function get_buku($order_by = 'id_buku', $order_type = 'ASC')
    {
        $this->db->select('buku.*, ptk.nama_ptk');
        $this->db->from('buku');
        $this->db->join('ptk', 'buku.id_guru = ptk.id_guru', 'left');
        $this->db->order_by($order_by, $order_type);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function get_bukutimeline($order_by = 'timestamp_buku', $order_type = 'DESC')
    {
        $this->db->select('buku.*, ptk.nama_ptk');
        $this->db->from('buku');
        $this->db->join('ptk', 'buku.id_guru = ptk.id_guru', 'left');
        $this->db->order_by($order_by, $order_type);
        $this->db->limit(4); // Menambahkan batasan jumlah data menjadi 4
        $query = $this->db->get();

        return $query->result_array();
    }


















    public function hapus_kelas($kelas_id)
    {
        // Dapatkan no_kelas dari id_kelas
        $kelas = $this->get_kelas_by_id($kelas_id);

        if ($kelas && $this->is_kelas_digunakan($kelas->no_kelas)) {
            return false; // Gagal menghapus karena ada siswa yang menggunakan kelas ini
        }

        // Lanjutkan dengan penghapusan jika tidak ada siswa yang menggunakan kelas ini
        $this->db->where('id_kelas', $kelas_id);
        $result = $this->db->delete($this->_tablekelas);
        if (!$result) {
            log_message('error', 'Gagal menghapus kelas dengan ID: ' . $kelas_id);
        }
        return $result;
    }

    public function is_kelas_digunakan($no_kelas)
    {
        $this->db->where('kode_kelas', $no_kelas);
        $query = $this->db->get('siswa');
        return $query->num_rows() > 0;
    }

    public function get_kelas_by_id($kelas_id)
    {
        $this->db->where('id_kelas', $kelas_id);
        return $this->db->get($this->_tablekelas)->row();
    }




    //Fungsi Kelas








    public function get_kelasmengajar($order_by = 'nama_kelas', $order_type = 'ASC')
    {
        $query = $this->db->get('kelas');
        return $query->result_array();
    }








    public function get_kelas_by_no($no_kelas)
    {
        $this->db->where('no_kelas', $no_kelas);
        $query = $this->db->get('kelas');
        return $query->row();
    }

    public function get_kelas_by_nama($nama_kelas)
    {
        $this->db->where('nama_kelas', $nama_kelas);
        $query = $this->db->get('kelas');
        return $query->row();
    }

    public function simpan_kelas($data)
    {
        $this->db->insert('kelas', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_kelas($kelas_id, $data)
    {
        $this->db->where('id_kelas', $kelas_id);
        $this->db->update('kelas', $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapus_kelassss($kelas_id)
    {
        $this->db->where('id_kelas', $kelas_id);
        $result = $this->db->delete('kelas');
        return $result;
    }
}
