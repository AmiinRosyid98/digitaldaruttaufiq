<?php
// File: application/models/Admin.php

class Arsip_Model extends CI_Model
{


    const SESSION_KEY = 'ptk_id';


    //Fungsi Bank Soal Digital

    public function get_banksoal($id_guru)
    {
        $this->db->select('*');
        $this->db->from('arsip_dokumen');
        $this->db->join('ptk', 'arsip_dokumen.id_guru = ptk.id_guru');
        $this->db->where('ptk.id_guru', $id_guru);
        $this->db->group_by('arsip_dokumen.id');
        $this->db->order_by('arsip_dokumen.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_nama_file_buku_by_id($banksoal_id)
    {
        $this->db->select('file_arsip');
        $this->db->where('id', $banksoal_id);
        $query = $this->db->get('arsip_dokumen');


        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->file_arsip;
        } else {
            return false;
        }
    }

    public function get_banksoaltimeline($id_guru)
    {
        $this->db->select('*');
        $this->db->from('arsip_dokumen');
        $this->db->join('ptk', 'arsip_dokumen.id_guru = ptk.id_guru');
        $this->db->where('ptk.id_guru', $id_guru);
        $this->db->group_by('arsip_dokumen.id');
        $this->db->order_by('arsip_dokumen.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }



    public function simpan_banksoal($data)
    {
        $this->db->insert('arsip_dokumen', $data);
        return $this->db->affected_rows() > 0;
    }


    public function hapus_banksoal($banksoal_id)
    {
        $this->db->where('id', $banksoal_id);
        $result = $this->db->delete('arsip_dokumen');
        return $result;
    }
}
