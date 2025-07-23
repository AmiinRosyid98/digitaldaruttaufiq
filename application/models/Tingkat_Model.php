<?php
// File: application/models/Admin.php

class Tingkat_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "admin";
    const SESSION_KEY = 'admin_id';


    //Fungsi Kelas

    public function get_tingkat($order_by = 'nama_tingkat', $order_type = 'ASC')
    {
        // Jika kolom yang diurutkan adalah angka, tambahkan CAST agar pengurutan dilakukan secara numerik
        if (preg_match('/^\d+$/', $order_by)) {
            $this->db->order_by('CAST(' . $order_by . ' AS SIGNED)', $order_type);
        } else {
            $this->db->order_by($order_by, $order_type);
        }

        $query = $this->db->get('tingkat');
        return $query->result_array();
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





    public function get_tingkat_by_id($tingkat_id)
    {
        return $this->db->get_where('tingkat', array('id_tingkat' => $tingkat_id))->row_array();
    }





    public function update_tingkat($tingkat_id, $data)
    {
        $this->db->where('id_tingkat', $tingkat_id);
        $this->db->update('tingkat', $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapus_tingkat($tingkat_id)
    {
        $this->db->where('id_tingkat', $tingkat_id);
        $result = $this->db->delete('tingkat');
        return $result;
    }
}
