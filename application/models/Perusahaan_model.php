<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perusahaan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_nama_lembaga_by_id($id)
    {
        // Query untuk mendapatkan nama lembaga berdasarkan id
        $this->db->select('nama_lembaga');
        $this->db->where('id', $id); // Sesuaikan dengan nama kolom yang mengandung id lembaga
        $query = $this->db->get('perusahaan'); // Ganti dengan nama tabel lembaga Anda

        if ($query->num_rows() > 0) {
            return $query->row()->nama_lembaga;
        } else {
            return false; // Jika tidak ditemukan, return false atau sesuaikan dengan kebutuhan Anda
        }
    }
}
