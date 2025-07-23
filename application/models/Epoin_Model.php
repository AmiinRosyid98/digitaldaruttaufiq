<?php
// File: application/models/Epoin_Model.php

class Epoin_Model extends CI_Model
{
    private $_table_poin_pelanggaran = "poinpelanggaran";
    private $_table_jenis_pelanggaran = "jenispelanggaran";
    private $_table_kelas = "kelas";
    private $_table_siswa = "siswa"; // Tambahkan tabel siswa

    public function __construct()
    {
        parent::__construct();
        // Load database di dalam konstruktor
        $this->load->database();
    }

    public function get_poinpelanggaran()
    {
        // Select semua kolom dari tabel poinpelanggaran dan siswa berdasarkan id_siswa
        $this->db->select('poinpelanggaran.*, siswa.*'); // Sesuaikan kolom yang ingin ditampilkan
        $this->db->from($this->_table_poin_pelanggaran);
        $this->db->join($this->_table_siswa, 'poinpelanggaran.id_siswa = siswa.id_siswa', 'left'); // Sesuaikan kondisi join
        $this->db->order_by('siswa.nama_siswa', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_jenispelanggaran()
    {
        $this->db->select('*'); // Sesuaikan kolom yang ingin ditampilkan
        $this->db->from($this->_table_jenis_pelanggaran);
        $this->db->order_by('jenispelanggaran.id', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_totalpoinpelanggaran()
    {
        $this->db->select('siswa.id_siswa, siswa.nama_siswa, siswa.kode_kelas, kelas.nama_kelas, SUM(poinpelanggaran.poin) as total_poin, poinpelanggaran.nama_pelanggaran'); // Menambahkan kolom tambahan
        $this->db->from($this->_table_siswa);
        $this->db->join($this->_table_kelas, 'siswa.kode_kelas = kelas.no_kelas', 'left'); // Kondisi join
        $this->db->join($this->_table_poin_pelanggaran, 'siswa.id_siswa = poinpelanggaran.id_siswa', 'left'); // Kondisi join
        $this->db->group_by('siswa.id_siswa'); // Mengelompokkan berdasarkan id_siswa
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        $this->db->where('status_kelulusan', 0); // Tambahkan kondisi di sini

        $query = $this->db->get();
        return $query->result_array();
    }



    public function get_siswa()
    {
        // Select semua kolom dari tabel siswa dengan status_kelulusan 0
        $this->db->select('siswa.*'); // Sesuaikan kolom yang ingin ditampilkan
        $this->db->from($this->_table_siswa);
        $this->db->where('status_kelulusan', 0); // Tambahkan kondisi di sini
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cari_siswa($term)
    {
        $this->db->select('id_siswa, nama_siswa'); // Kolom yang ingin ditampilkan
        $this->db->from('siswa');
        $this->db->like('nama_siswa', $term); // Mencocokkan kata kunci pencarian dengan nama siswa
        $query = $this->db->get();
        return $query->result_array();
    }


    public function simpan_jenis_pelanggaran($data)
    {
        // Simpan data pelanggaran ke dalam tabel poinpelanggaran
        $this->db->insert($this->_table_jenis_pelanggaran, $data);
        return $this->db->affected_rows() > 0;
    }


    public function simpan_data_pelanggaran($data)
    {
        // Simpan data pelanggaran ke dalam tabel poinpelanggaran
        $this->db->insert($this->_table_poin_pelanggaran, $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapus_jenispelanggaran($pelanggaran_id)
    {
        $this->db->where('id', $pelanggaran_id);
        $result = $this->db->delete('jenispelanggaran');
        return $result;
    }

    public function hapus_poinpelanggaran($pelanggaran_id)
    {
        $this->db->where('id', $pelanggaran_id);
        $result = $this->db->delete('poinpelanggaran');
        return $result;
    }
}
