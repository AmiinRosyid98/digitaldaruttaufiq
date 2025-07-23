<?php
// File: application/models/Admin.php

class Linkdinamis_Model extends CI_Model
{



    public function get_link()
    {
        $this->db->select('*');
        $this->db->from('link_dinamis');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tambah_link($data)
    {
        $this->db->insert('link_dinamis', $data);
        return $this->db->affected_rows() > 0;
    }

    // Untuk mengambil data link berdasarkan ID
    public function get_link_by_id($id)
    {
        return $this->db->where('id', $id)->get('link_dinamis')->row();
    }

    public function update_link($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('link_dinamis', $data);
    }


    // Untuk menghapus data link
    public function hapus_link($id)
    {
        return $this->db->where('id', $id)->delete('link_dinamis');
    }
}
