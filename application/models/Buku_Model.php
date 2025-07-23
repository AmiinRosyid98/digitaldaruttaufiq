<?php
// File: application/models/Admin.php

class Buku_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "ptk";
    const SESSION_KEY = 'ptk_id';


    //Fungsi Buku Digital

    public function get_buku($id_guru)
    {
        $this->db->select('*, GROUP_CONCAT(kelas.nama_kelas ORDER BY kelas.nama_kelas ASC SEPARATOR ", ") AS nama_kelas');
        $this->db->from('buku');
        $this->db->join('ptk', 'buku.id_guru = ptk.id_guru');
        $this->db->join('kelas', 'FIND_IN_SET(kelas.no_kelas, buku.kode_kelas) > 0', 'LEFT');
        $this->db->where('ptk.id_guru', $id_guru);
        $this->db->group_by('buku.id_buku'); // Menambahkan group_by
        $this->db->order_by('buku.id_buku', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_bukutimeline($id_guru)
    {
        $this->db->select('*, GROUP_CONCAT(kelas.nama_kelas ORDER BY kelas.nama_kelas ASC SEPARATOR ", ") AS nama_kelas');
        $this->db->from('buku');
        $this->db->join('ptk', 'buku.id_guru = ptk.id_guru');
        $this->db->join('kelas', 'FIND_IN_SET(kelas.no_kelas, buku.kode_kelas) > 0', 'LEFT');
        $this->db->where('ptk.id_guru', $id_guru);
        $this->db->group_by('buku.id_buku'); // Menambahkan group_by
        $this->db->order_by('buku.id_buku', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }





    public function get_buku_by_id($buku_id)
    {
        return $this->db->get_where('buku', array('id_buku' => $buku_id))->row_array();
    }

    public function get_nama_file_buku_by_id($buku_id)
    {
        $this->db->select('file_buku');
        $this->db->where('id_buku', $buku_id);
        $query = $this->db->get('buku');


        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->file_buku;
        } else {
            return false;
        }
    }




    public function get_kelasmengajar($id_guru)
    {
        $this->db->select('*');
        $this->db->from('ptk');
        //$this->db->join('kelas', 'ptk.id_guru = kelas.no_kelas');
        $this->db->join('kelas', 'FIND_IN_SET(kelas.no_kelas, ptk.kode_kelas) > 0', 'LEFT');
        $this->db->where('ptk.id_guru', $id_guru);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function simpan_buku($data)
    {
        $this->db->insert('buku', $data);
        return $this->db->affected_rows() > 0;
    }


    public function update_buku($buku_id, $data)
    {
        $this->db->where('id_buku', $buku_id);
        $this->db->update('buku', $data);
        return $this->db->affected_rows() > 0;
    }


    public function get_buku_by_kodebuku($kode_buku)
    {
        $this->db->where('kode_buku', $kode_buku);
        $query = $this->db->get('buku');
        return $query->row();
    }

    public function hapus_buku($buku_id)
    {
        $this->db->where('id_buku', $buku_id);
        $result = $this->db->delete('buku');
        return $result;
    }










    public function get_kelas_by_id($kelas_id)
    {
        return $this->db->get_where('kelas', array('id_kelas' => $kelas_id))->row_array();
    }

    public function get_kelas_by_no($no_kelas)
    {
        $this->db->where('no_kelas', $no_kelas);
        $query = $this->db->get('kelas');
        return $query->row();
    }

    public function get_kelas_by_nama($nama_kelas)
    {
        $this->db->where('nama_kelas', $nama_kelas);
        $query = $this->db->get('kelas');
        return $query->row();
    }

    public function simpan_kelas($data)
    {
        $this->db->insert('kelas', $data);
        return $this->db->affected_rows() > 0;
    }
}
