<?php
// File: application/models/Admin.php

class Poskeuangan_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "admin";
    private $_tablepos = "poskeuangan";
    private $_tablejenispembayaran = "jenispembayaran";
    const SESSION_KEY = 'admin_id';

    //Fungsi Pos Keuangan
    public function get_poskeuangan($order_by = 'nama_pos', $order_type = 'ASC')
    {
        $query = $this->db->get('poskeuangan');
        return $query->result_array();
    }


    public function get_poskeuangan_by_nama($nama_pos)
    {
        $this->db->where('nama_pos', $nama_pos);
        $query = $this->db->get('poskeuangan');
        return $query->row();
    }




    public function update_poskeuangan($pos_id, $data)
    {
        $this->db->where('id_pos', $pos_id);
        $this->db->update('poskeuangan', $data);
        return $this->db->affected_rows() > 0;
    }


    public function simpan_poskeuangan($data)
    {
        $this->db->insert('poskeuangan', $data);
        return $this->db->affected_rows() > 0;
    }



    public function get_poskeuangan_by_id($pos_id)
    {
        $this->db->where('id_pos', $pos_id);
        return $this->db->get($this->_tablepos)->row();
    }

    public function is_poskeuangan_digunakan($id_pos)
    {
        $this->db->where('kode_pos', $id_pos);
        $query = $this->db->get('jenispembayaran');
        return $query->num_rows() > 0;
    }


    public function hapus_poskeuangan($pos_id)
    {
        $jenispembayaran = $this->get_poskeuangan_by_id($pos_id);

        if ($jenispembayaran && $this->is_poskeuangan_digunakan($jenispembayaran->id_pos)) {
            return false;
        }
        $this->db->where('id_pos', $pos_id);
        $result = $this->db->delete($this->_tablepos);
        if (!$result) {
            log_message('error', 'Gagal menghapus kelas dengan ID: ' . $pos_id);
        }
        return $result;
    }




    //Fungsi Jenis Pembayaran
    public function get_jenispembayaran()
    {
        $this->db->select('*');
        $this->db->from('jenispembayaran');
        $this->db->join('poskeuangan', 'jenispembayaran.kode_pos = poskeuangan.id_pos');
        $this->db->join('tipepembayaran', 'jenispembayaran.tipe_pembayaran = tipepembayaran.id_tipepembayaran');
        $this->db->join('tahunpelajaran', 'jenispembayaran.kode_tahunpelajaran = tahunpelajaran.id_tahunpelajaran');
        $this->db->order_by('tahunpelajaran.tahun_pelajaran, poskeuangan.nama_pos', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_jenispembayaran_by_kode($kode_pos, $kode_tahunpelajaran)
    {
        $this->db->where('kode_pos', $kode_pos);
        $this->db->where('kode_tahunpelajaran', $kode_tahunpelajaran);
        $query = $this->db->get('jenispembayaran');
        return $query->row();
    }

    public function simpan_jenispembayaran($data)
    {
        $this->db->insert('jenispembayaran', $data);
        return $this->db->affected_rows() > 0;
    }



    public function hapus_jenispembayaran($jenispembayaran_id)
    {
        $jenispembayaran = $this->get_jenispembayaran_by_id($jenispembayaran_id);

        if ($jenispembayaran && $this->is_jenispembayaran_digunakan($jenispembayaran->id_jenispembayaran)) {
            return false;
        }
        $this->db->where('id_jenispembayaran', $jenispembayaran_id);
        $result = $this->db->delete($this->_tablejenispembayaran);
        if (!$result) {
            log_message('error', 'Gagal menghapus kelas dengan ID: ' . $jenispembayaran_id);
        }
        return $result;
    }


    public function get_jenispembayaran_by_id($jenispembayaran_id)
    {
        $this->db->where('id_jenispembayaran', $jenispembayaran_id);
        return $this->db->get($this->_tablejenispembayaran)->row();
    }

    public function is_jenispembayaran_digunakan($id_jenispembayaran)
    {
        $this->db->where('kode_pembayaran', $id_jenispembayaran);
        $query = $this->db->get('tarifpembayaran');
        return $query->num_rows() > 0;
    }






    // FUNGSI TARIF PEMBAYARAN
    public function get_pembayaran()
    {
        $this->db->select('*');
        $this->db->from('tarifpembayaran');
        $this->db->join('kelas', 'tarifpembayaran.kode_kelas = kelas.no_kelas');
        $this->db->order_by('id_kelas', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_tarifsiswa()
    {
        $this->db->select('*');
        $this->db->from('tarifpembayaran');
        $this->db->join('jenispembayaran', 'tarifpembayaran.kode_pembayaran = jenispembayaran.id_jenispembayaran');
        $this->db->join('poskeuangan', 'jenispembayaran.kode_pos = poskeuangan.id_pos');
        $this->db->join('kelas', 'tarifpembayaran.kode_kelas = kelas.no_kelas');
        $this->db->join('tahunpelajaran', 'jenispembayaran.kode_tahunpelajaran = tahunpelajaran.id_tahunpelajaran');
        $this->db->join('tipepembayaran', 'jenispembayaran.tipe_pembayaran = tipepembayaran.id_tipepembayaran');



        $this->db->order_by('tahun_pelajaran', 'DESC');
        $this->db->order_by('nama_pos', 'ASC');
        $this->db->order_by('nama_kelas', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_tarifpembayaran_by_kode($kode_kelas, $kode_pembayaran)
    {
        $this->db->where('kode_kelas', $kode_kelas);
        $this->db->where('kode_pembayaran', $kode_pembayaran);
        $query = $this->db->get('tarifpembayaran');
        return $query->row();
    }

    public function simpan_tarifpembayaran($data)
    {
        $this->db->insert_batch('tarifpembayaran', $data);
        return $this->db->affected_rows() > 0;
    }


    public function hapus_tarifpembayaran($tarifpembayaran_id)
    {
        $this->db->where('id_pembayaran', $tarifpembayaran_id);
        $result = $this->db->delete('tarifpembayaran');
        return $result;
    }








    // FUNGSI TIPE PEMBAYARAN
    public function get_tipepembayaran()
    {
        $this->db->order_by('nama_tipepembayaran', 'DESC');
        $query = $this->db->get('tipepembayaran');
        return $query->result_array();
    }



    //FUNGSI TAHUN PELAJARAN
    public function get_tahunpelajaran()
    {
        $this->db->order_by('tahun_pelajaran', 'DESC');
        $query = $this->db->get('tahunpelajaran');
        return $query->result_array();
    }



    //FUNGSI KELAS
    public function get_kelas()
    {
        $this->db->order_by('nama_kelas', 'ASC');
        $query = $this->db->get('kelas');
        return $query->result_array();
    }
}
