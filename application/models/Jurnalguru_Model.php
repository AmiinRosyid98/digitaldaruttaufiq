<?php
// File: application/models/Admin.php

class Jurnalguru_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "ptk";
    private $_tablepos = "jurnalmaster";

    const SESSION_KEY = 'ptk_id';


    //Fungsi Jurnal Guru

    public function get_jurnal($id_guru)
    {
        $this->db->select('*');
        $this->db->from('jurnalguru');
        $this->db->join('ptk', 'jurnalguru.id_guru = ptk.id_guru');
        $this->db->where('ptk.id_guru', $id_guru);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_jurnalmaster($id_guru)
    {
        $this->db->select('jurnalmaster.*, ptk.nama_ptk, kelas.nama_kelas, COUNT(jurnalguru.id_master) as jumlah_jurnal');
        $this->db->from('jurnalmaster');
        $this->db->join('ptk', 'jurnalmaster.id_guru = ptk.id_guru');
        $this->db->join('kelas', 'jurnalmaster.kelas = kelas.no_kelas');
        $this->db->join('jurnalguru', 'jurnalmaster.id = jurnalguru.id_master', 'left');
        $this->db->where('ptk.id_guru', $id_guru);
        $this->db->group_by('jurnalmaster.id');
        $this->db->order_by('kelas.nama_kelas', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }



    public function simpan_jurnalmaster($data)
    {
        $this->db->insert('jurnalmaster', $data);
        return $this->db->affected_rows() > 0;
    }



    public function hapus_jurnalmaster($jurnalmaster_id)
    {
        $jurnalguru = $this->get_masterjurnal_id($jurnalmaster_id);

        if ($jurnalguru && $this->is_masterjurnal_digunakan($jurnalguru->id)) {
            return false;
        }
        $this->db->where('id', $jurnalmaster_id);
        $result = $this->db->delete($this->_tablepos);
        if (!$result) {
            log_message('error', 'Gagal menghapus Master Jurnal dengan ID: ' . $jurnalmaster_id);
        }
        return $result;
    }




    public function get_masterjurnal_id($jurnalmaster_id)
    {
        $this->db->where('id', $jurnalmaster_id);
        return $this->db->get($this->_tablepos)->row();
    }


    public function is_masterjurnal_digunakan($id)
    {
        $this->db->where('id_master', $id);
        $query = $this->db->get('jurnalguru');
        return $query->num_rows() > 0;
    }
















    public function get_masterjurnal_by_id($masterjurnal_id)
    {
        return $this->db->get_where('jurnalmaster', array('id' => $masterjurnal_id))->row_array();
    }

    public function get_jurnal_by_masterjurnal($id_master)
    {
        $this->db->select('
        jurnalguru.*, 
        kelas.nama_kelas, 
        ptk.*, 
        GROUP_CONCAT(DISTINCT mapel.nama_mapel ORDER BY mapel.nama_mapel SEPARATOR ", ") AS mapel_diajar
    ');
        $this->db->from('jurnalguru');
        $this->db->join('ptk', 'jurnalguru.id_guru = ptk.id_guru', 'left');
        $this->db->join('ptk_mapel', 'ptk.id_guru = ptk_mapel.id_guru', 'left');
        $this->db->join('mapel', 'ptk_mapel.id_mapel = mapel.id_mapel', 'left');
        $this->db->join('jurnalmaster', 'jurnalguru.id_master = jurnalmaster.id', 'left');
        $this->db->join('kelas', 'jurnalmaster.kelas = kelas.no_kelas', 'left');
        $this->db->where('jurnalguru.id_master', $id_master);
        $this->db->group_by('jurnalguru.id'); // Penting untuk menghindari duplikat
        $this->db->order_by('jurnalguru.tanggal', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }








    public function simpan_jurnal($data)
    {
        $this->db->insert('jurnalguru', $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapus_jurnaldetail($jurnaldetail_id)
    {
        $this->db->where('id', $jurnaldetail_id);
        $result = $this->db->delete('jurnalguru');
        return $result;
    }




    public function get_profilsekolah_data()
    {
        $this->db->select('*'); // Pilih kolom yang ingin Anda ambil
        $this->db->from('perusahaan'); // Tabel utama
        $this->db->join('tahunpelajaran', 'tahunpelajaran.id_tahunpelajaran = perusahaan.tahun_pelajaran'); // JOIN dengan kondisi

        return $this->db->get()->row_array(); // Ambil satu baris hasil sebagai array
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
