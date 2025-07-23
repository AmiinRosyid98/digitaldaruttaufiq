<?php
// File: application/models/Admin.php

class Manajemenpengguna_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "admin";
    const SESSION_KEY = 'admin_id';


    //Fungsi Manajemen Pengguna



    public function get_pengguna()
    {
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_kelas_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('admin');
        return $query->row();
    }


    public function simpan_pengguna($data)
    {
        $this->db->insert('admin', $data);
        return $this->db->affected_rows() > 0;
    }


    public function update_pengguna($pengguna_id, $data)
    {
        $this->db->where('id', $pengguna_id);
        $this->db->update('admin', $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_pengguna_by_id($pengguna_id)
    {
        return $this->db->get_where('admin', array('id' => $pengguna_id))->row_array();
    }


    public function hapus_pengguna($pengguna_id)
    {
        $this->db->where('id', $pengguna_id);
        $result = $this->db->delete('admin');
        return $result;
    }










    public function get_tingkat_by_nama($nama_tingkat)
    {
        $this->db->where('nama_tingkat', $nama_tingkat);
        $query = $this->db->get('tingkat');
        return $query->row();
    }

    public function simpan_tingkat($data)
    {
        $this->db->insert('tingkat', $data);
        return $this->db->affected_rows() > 0;
    }
}
