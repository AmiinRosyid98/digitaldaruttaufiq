<?php
// File: application/models/Admin.php

class Arsipguru_Model extends CI_Model
{


    private $_tablekelas = "arsip_dokumen";
    const SESSION_KEY = 'admin_id';



    public function get_arsip($kategori = null, $order_by = 'id', $order_type = 'ASC')
    {
        $this->db->select('arsip_dokumen.*, ptk.nama_ptk');
        $this->db->from('arsip_dokumen');
        $this->db->join('ptk', 'arsip_dokumen.id_guru = ptk.id_guru', 'left');

        if (!empty($kategori)) {
            $this->db->where('arsip_dokumen.kategori', $kategori);
        }

        $this->db->order_by($order_by, $order_type);
        $query = $this->db->get();

        return $query->result_array();
    }


    public function get_arsiptimeline($order_by = 'timestamp_arsip', $order_type = 'DESC')
    {
        $this->db->select('arsip_dokumen.*, ptk.nama_ptk');
        $this->db->from('arsip_dokumen');
        $this->db->join('ptk', 'arsip_dokumen.id_guru = ptk.id_guru', 'left');
        $this->db->order_by($order_by, $order_type);
        $this->db->limit(4); // Menambahkan batasan jumlah data menjadi 4
        $query = $this->db->get();

        return $query->result_array();
    }
}
