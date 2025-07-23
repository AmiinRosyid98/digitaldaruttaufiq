<?php
// File: application/models/Admin.php

class Mapel_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "admin";
    const SESSION_KEY = 'admin_id';


    //Fungsi Mapel

    public function get_mapel()
    {
        $this->db->order_by('kelompok_mapel', 'ASC');
        $this->db->order_by('nourut_mapel', 'ASC');
        $query = $this->db->get('mapel');
        return $query->result_array();
    }

    public function get_mapel_by_id($mapel_id)
    {
        return $this->db->get_where('mapel', array('id_mapel' => $mapel_id))->row_array();
    }

    public function get_mapel_by_nama($nama_mapel)
    {
        $this->db->where('nama_mapel', $nama_mapel);
        $query = $this->db->get('mapel');
        return $query->row();
    }



    public function simpan_mapel($data)
    {
        $this->db->insert('mapel', $data);
        return $this->db->affected_rows() > 0;
    }


    public function update_mapel($mapel_id, $data)
    {
        $this->db->where('id_mapel', $mapel_id);
        $this->db->update('mapel', $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapus_mapel($mapel_id)
    {
        $this->db->where('id_mapel', $mapel_id);
        $result = $this->db->delete('mapel');
        return $result;
    }
}
