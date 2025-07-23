<?php
defined('BASEPATH') or exit('No direct script access allowed');

class New_table_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat database
    }

    public function create_new_tables()
    {
        // Query untuk membuat tabel mapel
        $query1 = "
            CREATE TABLE IF NOT EXISTS mapel (
                id_mapel INT(11) NOT NULL AUTO_INCREMENT,
                nama_mapel VARCHAR(100) NOT NULL,
                kelompok_mapel VARCHAR(100) NOT NULL,
                nourut_mapel VARCHAR(100) NOT NULL,
                PRIMARY KEY (id_mapel)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        // Eksekusi query untuk membuat tabel mapel
        $this->db->query($query1);

        // Query untuk membuat tabel berita
        $query2 = "
            CREATE TABLE IF NOT EXISTS berita (
                id_berita INT(11) NOT NULL AUTO_INCREMENT,
                judul_berita VARCHAR(100) NOT NULL,
                isi_berita TEXT NOT NULL,
                gambar_berita VARCHAR(100) NOT NULL,
                PRIMARY KEY (id_berita)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        // Eksekusi query untuk membuat tabel berita
        $this->db->query($query2);
    }
}
