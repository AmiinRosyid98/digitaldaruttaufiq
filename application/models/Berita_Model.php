<?php
// File: application/models/Admin.php

class Berita_Model extends CI_Model
{
    private $_table = "berita";
    const SESSION_KEY = 'admin_id';

    public function get_listberita($order_by = 'id_berita', $order_type = 'DESC')
    {
        $this->db->select('*');
        $this->db->from('berita');
        $this->db->order_by($order_by, $order_type);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function simpan_berita($data)
    {
        // Sanitasi data sebelum menyimpan
        $data = $this->security->xss_clean($data);

        $this->db->insert($this->_table, $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapus_berita($berita_id)
    {
        $this->db->where('id_berita', $berita_id);
        $result = $this->db->delete('berita');
        return $result;
    }

    public function get_berita_by_id($berita_id)
    {
        // Query untuk mengambil data berita berdasarkan ID
        $this->db->where('id_berita', $berita_id);
        $query = $this->db->get('berita');

        // Periksa apakah ada data berita dengan ID yang diberikan
        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan satu baris data berita sebagai objek
        } else {
            return null; // Mengembalikan null jika berita tidak ditemukan
        }
    }
}
