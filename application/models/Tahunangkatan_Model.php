<?php
// File: application/models/Admin.php

class Tahunangkatan_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
	private $_table = "admin";
	const SESSION_KEY = 'admin_id';


    //Fungsi Tahun Ajaran

    public function get_tahunangkatan() {
        $this->db->order_by('tahun', 'DESC'); // Mengurutkan berdasarkan manajerial_tanggal terbaru
        $query = $this->db->get('tahunangkatan');
        return $query->result_array();
    }

    public function get_tahunangkatan_by_id($tahun_id){
        return $this->db->get_where('tahunangkatan', array('id_tahunangkatan' => $tahun_id))->row_array();
    }

    public function get_tahunangkatan_by_tahun($tahun) {
        $this->db->where('tahun', $tahun);
        $query = $this->db->get('tahunangkatan');
        return $query->row();
    }

    public function simpan_tahunangkatan($data){
        $this->db->insert('tahunangkatan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_tahunangkatan($tahun_id, $data){
        $this->db->where('id_tahunangkatan', $tahun_id);
        $this->db->update('tahunangkatan', $data);
        return $this->db->affected_rows() > 0;
        }

    public function hapus_tahunangkatan($tahun_id) {
        $this->db->where('id_tahunangkatan', $tahun_id);
        $result = $this->db->delete('tahunangkatan');
        return $result;
    }


    



}

?>