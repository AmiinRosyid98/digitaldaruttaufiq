<?php
// File: application/models/Admin.php

class Ptk_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "ptk";
    const SESSION_KEY = 'ptk_id';

    public function update_foto($id_guru, $file_name)
    {
        $this->db->where('id_guru', $id_guru);
        $this->db->update('ptk', ['avatar' => $file_name]); // Ganti 'ptk' dengan nama tabel yang sesuai
    }



    public function simpan_ptk_from_excel(
        $username,
        $password,
        $nip,
        $nama_ptk,
        $jeniskelamin,
        $agama,
        $tempatlahir_ptk,
        $tanggallahir_ptk
    ) {
        // Lakukan validasi data jika diperlukan

        // Buat array data PTK untuk disimpan ke dalam database
        $data = array(
            'username'          => $username,
            'password'          => $password,
            'nip'               => $nip,
            'nama_ptk'          => $nama_ptk,
            'jeniskelamin'      => $jeniskelamin,
            'agama'             => $agama,
            'tempatlahir_ptk'   => $tempatlahir_ptk,
            'tanggallahir_ptk'  => $tanggallahir_ptk,
            'avatar'            => 'default.png'
            // Isi kolom lainnya sesuai dengan struktur tabel PTK Anda
        );

        // Lakukan penyimpanan data ke dalam database
        $this->db->insert('ptk', $data);

        // Return nilai boolean untuk menunjukkan apakah penyimpanan berhasil atau tidak
        return $this->db->affected_rows() > 0;
    }

    public function update_qr_code_path($id_guru, $qr_code_path)
    {
        $data = array(
            'qrcode_ptk' => $qr_code_path
        );

        $this->db->where('id_guru', $id_guru);
        $this->db->update('ptk', $data);
    }

    //Fungsi PTK
    public function get_ptk()
    {
        // Subquery untuk mendapatkan daftar kelas
        $this->db->select('ptk.*, 
            GROUP_CONCAT(DISTINCT kelas.nama_kelas ORDER BY kelas.nama_kelas ASC SEPARATOR ", ") AS nama_kelas,
            GROUP_CONCAT(DISTINCT mapel.nama_mapel ORDER BY mapel.nama_mapel ASC SEPARATOR ", ") AS nama_mapel');

        $this->db->from('ptk');

        // Join untuk kelas (sama seperti sebelumnya)
        $this->db->join('kelas', 'FIND_IN_SET(kelas.no_kelas, ptk.kode_kelas) > 0', 'LEFT');

        // Join yang benar untuk multiple mapel
        $this->db->join('ptk_mapel', 'ptk_mapel.id_guru = ptk.id_guru', 'LEFT');
        $this->db->join('mapel', 'mapel.id_mapel = ptk_mapel.id_mapel', 'LEFT');

        $this->db->group_by('ptk.id_guru');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ptk_by_id($ptk_id)
    {
        $this->db->select('ptk.*, GROUP_CONCAT(kelas.nama_kelas SEPARATOR ", ") AS nama_kelas');
        $this->db->from('ptk');
        $this->db->join('kelas', 'FIND_IN_SET(kelas.no_kelas, ptk.kode_kelas) > 0', 'LEFT');
        $this->db->where('ptk.id_guru', $ptk_id);
        return $this->db->get()->row_array();
    }

    public function cek_nip($nip)
    {
        $this->db->where('nip', $nip);
        $query = $this->db->get('ptk');

        return $query->row();
    }

    public function cek_username($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('ptk');

        return $query->row();
    }

    public function simpan_ptk($data)
    {
        $this->db->insert('ptk', $data);
        return $this->db->affected_rows() > 0;
    }

    public function tambah_mapel_ptk($id_guru, $id_mapel)
    {
        $data = array(
            'id_guru' => $id_guru,
            'id_mapel' => $id_mapel
        );
        return $this->db->insert('ptk_mapel', $data);
    }

    public function update_ptk($ptk_id, $data)
    {
        $this->db->where('id_guru', $ptk_id);
        $this->db->update('ptk', $data);
        return $this->db->affected_rows() > 0;
    }



    public function hapus_ptk($ptk_id)
    {
        $this->db->where('id_guru', $ptk_id);
        $result = $this->db->delete('ptk');
        return $result;
    }

    public function hapus_mapel_ptk($id_guru)
    {
        $this->db->where('id_guru', $id_guru);
        return $this->db->delete('ptk_mapel');
    }

    public function kosongkan_ptk()
    {
        $this->db->empty_table('ptk');
    }

    public function get_mapel()
    {
        $this->db->order_by('kelompok_mapel', 'ASC');
        $this->db->order_by('nourut_mapel', 'ASC');
        $query = $this->db->get('mapel');
        return $query->result_array();
    }

    public function get_mapel_ptk($id_guru)
    {
        $this->db->select('id_mapel');
        $this->db->from('ptk_mapel');
        $this->db->where('id_guru', $id_guru);
        $query = $this->db->get();
        return $query->result_array();
    }
}
