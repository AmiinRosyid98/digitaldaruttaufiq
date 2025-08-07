<?php

// File: application/models/Admin.php
class Model_landing extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Pastikan database di-load
        $this->load->dbforge(); // Load dbforge untuk manipulasi tabel
    }


    public function execute_sql_file($file_path)
    {
        if (!file_exists($file_path)) {
            return false; // Return false jika file tidak ada
        }

        $sql = file_get_contents($file_path);
        $queries = explode(';', $sql);

        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                try {
                    $this->db->query($query);
                } catch (Exception $e) {
                    log_message('error', 'Query failed: ' . $query . ' - ' . $e->getMessage());
                    return false; // Return false jika terjadi error
                }
            }
        }

        return true; // Return true jika semua query berhasil
    }

    public function table_exists($table_name)
    {
        return $this->db->table_exists($table_name);
    }

    public function create_table($table_name)
    {
        if (!$this->table_exists($table_name)) {
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'title' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ),
                'description' => array(
                    'type' => 'TEXT',
                    'null' => TRUE,
                ),
                'created_at' => array(
                    'type' => 'TIMESTAMP',
                    'default' => 'CURRENT_TIMESTAMP',
                ),
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE); // Set Primary Key
            $this->dbforge->create_table($table_name, TRUE);
        }
    }

    // Menambahkan metode untuk memeriksa status instalasi
    public function is_installed()
    {
        return $this->table_exists('perusahaan');
    }



    public function get_site()
    {
        $this->db->select('*');
        $this->db->from('perusahaan');
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    public function total_siswa()
    {
        // Hitung jumlah siswa dengan status_kelulusan 0
        $this->db->where('status_kelulusan', 0);
        return $this->db->count_all_results('siswa');
    }

    public function total_guru()
    { // Hitung Total guru
        return $this->db->count_all('ptk');
    }

    public function total_alumni()
    {
        // Hitung jumlah siswa dengan status_kelulusan 0
        $this->db->where('status_kelulusan', 1);
        return $this->db->count_all_results('siswa');
    }


    public function total_kelas()
    { // Hitung Total kelas
        return $this->db->count_all('kelas');
    }


    public function get_guru()
    {
        $this->db->select('ptk.nama_ptk, ptk.avatar ');
        $this->db->from('ptk');
        $this->db->order_by('id_guru', 'asc');
        return $this->db->get();
    }

    public function get_link_dinamis()
    {
        $this->db->from('link_dinamis');
        //$this->db->order_by('id_guru', 'asc');
        return $this->db->get();
    }

    public function get_version()
    {
        $this->db->select('*');
        $this->db->from('version');
        $this->db->where('id', 1); // Menambahkan kondisi WHERE id = 1
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    public function get_berita()
    {
        $this->db->select('*');
        $this->db->from('berita');
        $this->db->order_by('id_berita', 'DESC');
        return $this->db->get();
    }


    public function simpan_pesertappdb($data)
    {
        $this->db->insert('ppdb', $data);
        return $this->db->affected_rows() > 0;
    }

    public function cari_siswa_dengan_nis($nis)
    {
        $this->db->select('siswa.nama_siswa, siswa.nis, siswa.status_kelulusan');
        $this->db->from('siswa');
        $this->db->where('nis', $nis); // Melakukan pencarian persis sesuai dengan NIS
        $this->db->order_by('id_siswa', 'DESC');
        $result = $this->db->get()->result();

        if (empty($result)) {
            return null; // Atau bisa juga return array kosong: return [];
        } else {
            return $result;
        }
    }

    public function get_site_with_status()
    {
        $this->db->select('*');
        $this->db->from('templateskl');
        $this->db->where('status_pengumuman', 1);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    public function get_target_time()
    {
        // Ambil target_time dari database (misalnya dari tabel 'kelulusan')
        $this->db->select('target_time');
        $this->db->from('templateskl'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query = $this->db->get();
        return $query->row(); // Kembalikan satu baris hasil query
    }

    //  Buku Digital
    public function get_books($limit = null, $offset = null)
    {
        $this->db->select('id_buku, nama_buku, file_buku, file_size, timestamp_buku');
        $this->db->where('file_buku !=', ''); // Hanya buku yang memiliki file
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('buku')->result();
    }



    public function count_all_books()
    {
        return $this->db->count_all('buku');
    }


    //Fungsi Portal KELULUSAN
    public function get_portalkelulusan_with_status()
    {
        $this->db->select('*');
        $this->db->from('templateskl');
        $this->db->where('status_pengumuman', 1);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }


    //Fungsi Portal PPDB
    public function get_portalppdb_with_status()
    {
        $this->db->select('*');
        $this->db->from('ppdb_setting');
        $this->db->where('status_ppdb', 1);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    public function get_portalppdb()
    {
        $this->db->select('*');
        $this->db->from('templateppdb');
        return $this->db->get();
    }



    public function get_jalurppdb()
    {
        $this->db->select('ppdbjalur.*, COUNT(ppdb.id) as siswa_pendaftar');
        $this->db->from('ppdbjalur');
        $this->db->join('ppdb', 'ppdb.jalur = ppdbjalur.id', 'left');
        $this->db->group_by('ppdbjalur.id');
        return $this->db->get();
    }


    public function get_jalur()
    {
        $this->db->select('*');
        $this->db->from('ppdbjalur');
        return $this->db->get();
    }

    public function total_pendaftar()
    { // Hitung Total pendaftar
        return $this->db->count_all('ppdb');
    }



    //  Minat dan bakat siswa

    public function get_hobby_stats()
    {
        // Data kegemaran olahraga (top 5)
        $hobbies = $this->db->select('kegemaran_olahraga as kegemaran, COUNT(*) as total')
            ->where('kegemaran_olahraga !=', '')
            ->group_by('kegemaran_olahraga')
            ->order_by('total', 'DESC')
            ->limit(5)
            ->get('siswa')
            ->result_array();

        // Data bakat seni (top 5)
        $talents = $this->db->select('kegemaran_kesenian as kegemaran, COUNT(*) as total')
            ->where('kegemaran_kesenian !=', '')
            ->group_by('kegemaran_kesenian')
            ->order_by('total', 'DESC')
            ->limit(5)
            ->get('siswa')
            ->result_array();

        return [
            'hobbies' => $hobbies,
            'talents' => $talents
        ];
    }
}
