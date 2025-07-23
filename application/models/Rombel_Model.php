<?php
// File: application/models/Admin.php

class Rombel_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
	private $_table = "admin";
	const SESSION_KEY = 'admin_id';


    public function get_siswa_by_kelas_paginated($kelas_id, $limit, $offset) {
        // Ambil data siswa berdasarkan kelas yang dipilih dengan join tabel kelas, dengan batasan limit dan offset
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.no_kelas = siswa.kode_kelas');
        $this->db->where('siswa.status_kelulusan', 0);
        $this->db->where('siswa.kode_kelas', $kelas_id);
        $this->db->limit($limit, $offset); // Batasan limit dan offset
        $query = $this->db->get();
    
        return $query->result_array();
    }
    
    public function count_siswa_by_kelas($kelas_id) {
        // Hitung jumlah total data siswa berdasarkan kelas yang dipilih
        $this->db->where('kode_kelas', $kelas_id);
        $this->db->where('siswa.status_kelulusan', 0);
        $this->db->from('siswa');
        return $this->db->count_all_results();
    }
    
    public function update_kode_kelas($siswa_id, $new_kelas_id)
    {
        // Pastikan $siswa_id dan $new_kelas_id memiliki nilai
        if (!empty($siswa_id) && !empty($new_kelas_id)) {
            // Lakukan update kode_kelas untuk siswa tertentu
            $data = array('kode_kelas' => $new_kelas_id);
            $this->db->where('id_siswa', $siswa_id);
            $this->db->update('siswa', $data);
        } else {
            // Jika parameter tidak valid, lempar pesan error
            throw new Exception("Invalid parameters for updating kode_kelas.");
        }
    }

    public function update_status_kelulusan($siswa_id, $new_status)
    {
        // Pastikan $siswa_id dan $new_status memiliki nilai
        if (!empty($siswa_id) && $new_status !== null) {
            // Lakukan update status kelulusan untuk siswa tertentu
            $data = array('status_kelulusan' => $new_status);
            $this->db->where('id_siswa', $siswa_id);
            $this->db->update('siswa', $data);
        } else {
            // Jika parameter tidak valid, lempar pesan error
            throw new Exception("Invalid parameters for updating status kelulusan.");
        }
    }
   
}

?>