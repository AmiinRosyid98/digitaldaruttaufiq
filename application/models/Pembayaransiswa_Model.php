<?php
// File: application/models/Admin.php

class Pembayaransiswa_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "admin";
    const SESSION_KEY = 'admin_id';



    public function filter_siswa_by_kelas_dan_poskeuangan($kode_kelas = null, $id_pos = null, $id_tahunpelajaran = null)
    {
        $this->db->select(" 
            (SELECT sum(jumlah_pembayaran) FROM `pembayaran` p
            where p.id_siswa = siswa.id_siswa
            AND p.id_kelas = tarifpembayaran.kode_kelas
            AND p.nama_tipepembayaran = jenispembayaran.tipe_pembayaran
            AND p.id_pos = poskeuangan.id_pos
            AND p.id_pembayaran = tarifpembayaran.id_pembayaran
            AND p.id_tahunpelajaran = tahunpelajaran.id_tahunpelajaran
            AND p.statuspembayaran = '1'
            GROUP BY p.id_siswa, p.id_kelas, p.nama_tipepembayaran, p.id_pos, p.id_pembayaran, p.id_tahunpelajaran) as total_bayar,

            siswa.*, kelas.*, tarifpembayaran.*, jenispembayaran.*, poskeuangan.*, tipepembayaran.*, tahunpelajaran.* ");
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas', 'left');
        $this->db->join('tarifpembayaran', 'siswa.kode_kelas = tarifpembayaran.kode_kelas', 'left');
        $this->db->join('jenispembayaran', 'tarifpembayaran.kode_pembayaran = jenispembayaran.id_jenispembayaran', 'left');
        $this->db->join('poskeuangan', 'jenispembayaran.kode_pos = poskeuangan.id_pos', 'left');
        $this->db->join('tipepembayaran', 'jenispembayaran.tipe_pembayaran = tipepembayaran.id_tipepembayaran', 'left');
        $this->db->join('tahunpelajaran', 'jenispembayaran.kode_tahunpelajaran = tahunpelajaran.id_tahunpelajaran', 'left');

        if ($kode_kelas) {
            $this->db->where('siswa.kode_kelas', $kode_kelas);
        }

        if ($id_pos) {
            $this->db->where('poskeuangan.id_pos', $id_pos);
        }
        if ($id_tahunpelajaran) {
            $this->db->where('tahunpelajaran.id_tahunpelajaran', $id_tahunpelajaran);
        }
        $this->db->where('siswa.status_kelulusan', 0);
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        $this->db->order_by('nama_pos', 'ASC');
        $this->db->order_by('siswa.no_absen', 'ASC');
        $query = $this->db->get();
        // var_dump($this->db->last_query());die;
        // sdsdsas
        return $query->result_array();
    }




    public function get_siswa_by_nis($nis)
    {
        $this->db->select(" 
            (SELECT sum(jumlah_pembayaran) FROM `pembayaran` p
            where p.id_siswa = siswa.id_siswa
            AND p.id_kelas = tarifpembayaran.kode_kelas
            AND p.nama_tipepembayaran = jenispembayaran.tipe_pembayaran
            AND p.id_pos = poskeuangan.id_pos
            AND p.id_pembayaran = tarifpembayaran.id_pembayaran
            AND p.id_tahunpelajaran = tahunpelajaran.id_tahunpelajaran
            AND p.statuspembayaran = '1'
            GROUP BY p.id_siswa, p.id_kelas, p.nama_tipepembayaran, p.id_pos, p.id_pembayaran, p.id_tahunpelajaran) as total_bayar,

            siswa.*, kelas.*, tarifpembayaran.*, jenispembayaran.*, poskeuangan.*, tipepembayaran.*, tahunpelajaran.* ");
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas', 'left');
        $this->db->join('tarifpembayaran', 'siswa.kode_kelas = tarifpembayaran.kode_kelas', 'left');
        $this->db->join('jenispembayaran', 'tarifpembayaran.kode_pembayaran = jenispembayaran.id_jenispembayaran', 'left');
        $this->db->join('poskeuangan', 'jenispembayaran.kode_pos = poskeuangan.id_pos', 'left');
        $this->db->join('tipepembayaran', 'jenispembayaran.tipe_pembayaran = tipepembayaran.id_tipepembayaran', 'left');
        $this->db->join('tahunpelajaran', 'jenispembayaran.kode_tahunpelajaran = tahunpelajaran.id_tahunpelajaran', 'left');
        $this->db->where('siswa.nis', $nis);
        $this->db->order_by('tahunpelajaran.tahun_pelajaran', 'DESC');
        $query = $this->db->get();
        // var_dump($this->db->last_query());die;
        return $query->result_array();
    }



    public function get_jumlah_pembayaran_by_id_siswa($id_siswa)
    {
        $this->db->select_sum('jumlah_pembayaran');

        $this->db->where('id_siswa', $id_siswa);
        $query = $this->db->get('pembayaran');
        if ($query->num_rows() > 0) {
            return $query->row()->jumlah_pembayaran;
        } else {
            return 0; // Jika tidak ada pembayaran, kembalikan 0
        }
    }



    public function get_historypembayaran($no_kelas=null, $pos_keuangan=null, $tahun_pelajaran=null)
    {
        if($no_kelas != ""){

            // Query untuk mendapatkan semua siswa dari kelas tertentu
            $this->db->select('siswa.id_siswa, siswa.nis, siswa.nama_siswa, kelas.nama_kelas');
            $this->db->from('siswa');
            $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
            $this->db->where('siswa.kode_kelas', $no_kelas);
            $this->db->order_by('siswa.no_absen', 'ASC');
            $querySiswa = $this->db->get()->result_array();

            // Ambil id_siswa dari hasil query siswa
            $id_siswa = array_column($querySiswa, 'id_siswa');

            // Jika tidak ada siswa, kembalikan hasil kosong
            if (empty($id_siswa)) {
                return [];
            }
        }

        $this->db->select('siswa.id_siswa, siswa.nis, siswa.nama_siswa, kelas.nama_kelas, poskeuangan.nama_pos, pembayaran.id_pembayaran, pembayaran.jumlah_tarif, tahunpelajaran.tahun_pelajaran, SUM(pembayaran.jumlah_pembayaran) as jumlah_pembayaran');
        $this->db->from('pembayaran');
        $this->db->join('siswa', 'pembayaran.id_siswa = siswa.id_siswa', 'left');
        $this->db->join('kelas', 'pembayaran.id_kelas = kelas.no_kelas', 'left');
        $this->db->join('poskeuangan', 'pembayaran.id_pos = poskeuangan.id_pos', 'left');
        $this->db->join('tahunpelajaran', 'pembayaran.id_tahunpelajaran = tahunpelajaran.id_tahunpelajaran', 'left');
        if($no_kelas != ""){
            $this->db->where_in('siswa.id_siswa', $id_siswa);
            
        }
        if($pos_keuangan != ""){
            $this->db->where('poskeuangan.id_pos', $pos_keuangan);

        }
        if($tahun_pelajaran != ""){
            $this->db->where('pembayaran.id_tahunpelajaran', $tahun_pelajaran);
        }
        $this->db->group_by('pembayaran.id_pos, pembayaran.id_tahunpelajaran, pembayaran.id_kelas, siswa.id_siswa'); // Mengelompokkan berdasarkan id_siswa dan id_pos
        $this->db->order_by('tahunpelajaran.tahun_pelajaran', 'DESC');
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        $this->db->order_by('siswa.no_absen', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }



    public function get_historypembayaran_by_kelssas($no_kelas)
    {
        $this->db->where('kode_kelas', $no_kelas);
        $this->db->select('siswa.id_siswa, siswa.nis, siswa.nama_siswa, kelas.nama_kelas, poskeuangan.nama_pos, pembayaran.id_pembayaran, pembayaran.jumlah_tarif, tahunpelajaran.tahun_pelajaran, SUM(pembayaran.jumlah_pembayaran) as jumlah_pembayaran');
        $this->db->from('pembayaran');
        $this->db->join('siswa', 'pembayaran.id_siswa = siswa.id_siswa', 'left');
        $this->db->join('kelas', 'pembayaran.id_kelas = kelas.no_kelas', 'left');
        $this->db->join('poskeuangan', 'pembayaran.id_pos = poskeuangan.id_pos', 'left');
        $this->db->join('tahunpelajaran', 'pembayaran.id_tahunpelajaran = tahunpelajaran.id_tahunpelajaran', 'left');

        $this->db->group_by('pembayaran.id_pos, pembayaran.id_tahunpelajaran, pembayaran.id_kelas, siswa.id_siswa'); // Mengelompokkan berdasarkan id_siswa dan id_pos
        $this->db->order_by('siswa.no_absen', 'ASC');
        $this->db->order_by('tahunpelajaran.tahun_pelajaran', 'DESC');
        $this->db->order_by('kelas.nama_kelas', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_historypembayaran_by_kelas($no_kelas, $pos_keuangan, $tahun_pelajaran)
    {
        // Query untuk mendapatkan semua siswa dari kelas tertentu
        $this->db->select('siswa.id_siswa, siswa.nis, siswa.nama_siswa, kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->where('siswa.kode_kelas', $no_kelas);
        $this->db->order_by('siswa.no_absen', 'ASC');
        $querySiswa = $this->db->get()->result_array();

        // Ambil id_siswa dari hasil query siswa
        $id_siswa = array_column($querySiswa, 'id_siswa');

        // Jika tidak ada siswa, kembalikan hasil kosong
        if (empty($id_siswa)) {
            return [];
        }

        // Query untuk informasi pembayaran berdasarkan id_siswa dan tahun_pelajaran
        $this->db->select('siswa.id_siswa, pembayaran.id_pembayaran, poskeuangan.nama_pos, pembayaran.jumlah_tarif, pembayaran.jumlah_pembayaran, tahunpelajaran.tahun_pelajaran, SUM(pembayaran.jumlah_pembayaran) as total_pembayaran, SUM(pembayaran.jumlah_pembayaran) as jumlah_pembayaran');
        $this->db->from('pembayaran');
        $this->db->join('poskeuangan', 'pembayaran.id_pos = poskeuangan.id_pos', 'left');
        $this->db->join('tahunpelajaran', 'pembayaran.id_tahunpelajaran = tahunpelajaran.id_tahunpelajaran', 'left');
        $this->db->join('siswa', 'siswa.id_siswa = pembayaran.id_siswa');
        $this->db->where_in('siswa.id_siswa', $id_siswa);
        $this->db->where('poskeuangan.id_pos', $pos_keuangan);
        $this->db->where('pembayaran.id_tahunpelajaran', $tahun_pelajaran);
        $this->db->group_by('siswa.id_siswa, poskeuangan.id_pos');

        // Urutan hasil
        $this->db->order_by('tahunpelajaran.tahun_pelajaran', 'DESC');
        $this->db->order_by('siswa.no_absen', 'ASC');
        $this->db->order_by('poskeuangan.nama_pos', 'ASC');

        $queryPembayaran = $this->db->get()->result_array();

        // Gabungkan hasil query siswa dan pembayaran
        $result = [];
        foreach ($querySiswa as $siswa) {
            $siswa_id = $siswa['id_siswa'];
            $result[$siswa_id] = [
                'id_siswa'   => $siswa['id_siswa'],
                'nis'        => $siswa['nis'],
                'nama_siswa' => $siswa['nama_siswa'],
                'nama_kelas' => $siswa['nama_kelas'],
                'pembayaran' => []
            ];
        }

        foreach ($queryPembayaran as $pembayaran) {
            $siswa_id = $pembayaran['id_siswa'];
            $result[$siswa_id]['pembayaran'][] = [
                'id_pembayaran' => $pembayaran['id_pembayaran'],
                'nama_pos' => isset($pembayaran['nama_pos']) ? $pembayaran['nama_pos'] : '-',
                'jumlah_tarif' => isset($pembayaran['jumlah_tarif']) ? $pembayaran['jumlah_tarif'] : '-',
                'jumlah_pembayaran' => isset($pembayaran['total_pembayaran']) ? $pembayaran['total_pembayaran'] : '-',
                'tahun_pelajaran' => isset($pembayaran['tahun_pelajaran']) ? $pembayaran['tahun_pelajaran'] : '-'
            ];
        }

        return array_values($result); // Mengubah hasil menjadi array indexed
    }





    public function get_detailpembayaran()
    {
        $this->db->select('*');
        $this->db->from('pembayaran');
        $this->db->join('siswa', 'pembayaran.id_siswa = siswa.id_siswa', 'left');
        $this->db->join('kelas', 'pembayaran.id_kelas = kelas.no_kelas', 'left');
        $this->db->join('poskeuangan', 'pembayaran.id_pos = poskeuangan.id_pos', 'left');
        $this->db->join('tahunpelajaran', 'pembayaran.id_tahunpelajaran = tahunpelajaran.id_tahunpelajaran', 'left');
        $this->db->order_by('pembayaran.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function hapus_pembayaran($pembayaran_id)
    {
        $this->db->where('id', $pembayaran_id);
        $result = $this->db->delete('pembayaran');
        return $result;
    }

    public function get_kelas()
    {
        $this->db->select('*');
        $this->db->from('kelas');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_poskeuangan()
    {
        $this->db->select('*');
        $this->db->from('poskeuangan');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_tahunpelajaran()
    {
        $this->db->select('*');
        $this->db->from('tahunpelajaran');
        $this->db->order_by('tahunpelajaran.tahun_pelajaran', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_siswa()
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function simpan_pembayaran($data)
    {
        $this->db->insert('pembayaran', $data);
    }
}
