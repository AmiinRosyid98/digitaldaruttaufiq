<?php
// File: application/models/Admin.php

class Kelulusan_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
	private $_table = "admin";
	const SESSION_KEY = 'admin_id';




    public function get_siswalulus() {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->where('siswa.status_kelulusan IN (1, 2)'); 
        $this->db->order_by('nama_kelas','ASC');
        $this->db->order_by('no_absen');
        $query = $this->db->get();
        return $query->result_array();
    }
    


    public function get_siswa_by_kelas_paginated($kelas_id, $tahun_angkatan, $limit, $offset) {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.no_kelas = siswa.kode_kelas');
        $this->db->join('tahunangkatan', 'tahunangkatan.tahun = siswa.tahun_angkatan');
        $this->db->where('siswa.status_kelulusan IN (1, 2)');
        $this->db->where('siswa.kode_kelas', $kelas_id);
        if (!empty($tahun_angkatan)) {
            $this->db->where('tahunangkatan.tahun', $tahun_angkatan);
        }
        $this->db->limit($limit, $offset); 
        $query = $this->db->get();
    
        return $query->result_array();
    }
    
    
    
    public function count_siswa_by_kelas($kelas_id) {
        $this->db->where('kode_kelas', $kelas_id);
        $this->db->where('siswa.status_kelulusan IN (1, 2)'); 
        $this->db->from('siswa');
        return $this->db->count_all_results();
    }
    


    public function update_kode_kelas($siswa_id, $new_kelas_id)
    {
        if (!empty($siswa_id) && !empty($new_kelas_id)) {
            $data = array('kode_kelas' => $new_kelas_id);
            $this->db->where('id_siswa', $siswa_id);
            $this->db->update('siswa', $data);
        } else {
            throw new Exception("Invalid parameters for updating kode_kelas.");
        }
    }



    public function update_status_kelulusan($siswa_id, $new_status)
    {
        if (!empty($siswa_id) && $new_status !== null) {
            $data = array('status_kelulusan' => $new_status);
            $this->db->where('id_siswa', $siswa_id);
            $this->db->update('siswa', $data);
        } else {
            throw new Exception("Invalid parameters for updating status kelulusan.");
        }
    }

    public function get_settingskl()
    {
        return $this->db->get('templateskl')->row_array();
    }
    
    public function update_skl($profilsekolah_data)
    {
        $perusahaan_id = 1; // Gantilah dengan ID perusahaan yang sesuai
        $this->db->where('id', $perusahaan_id);
        return $this->db->update('templateskl', $profilsekolah_data);
    }
   
}

?>