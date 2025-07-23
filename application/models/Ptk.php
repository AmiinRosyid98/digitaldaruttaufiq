<?php
// File: application/models/Admin.php

class Ptk extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "ptk";
    const SESSION_KEY = 'ptk_id';


    public function get_dataguru($id_guru)
    {
        $this->db->select('*');
        $this->db->from('ptk');
        $this->db->where('id_guru', $id_guru);
        $query = $this->db->get();
        return $query->row_array(); // Mengembalikan satu baris data sebagai array asosiatif
    }

    public function update_qr_code_path($id_guru, $qr_code_path)
    {
        $data = array(
            'qrcode_ptk' => $qr_code_path
        );

        $this->db->where('id_guru', $id_guru);
        $this->db->update('ptk', $data);
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



    public function count_siswa_by_kelas($kelas_id)
    {
        $this->db->where('kode_kelas', $kelas_id);
        $this->db->where('siswa.status_kelulusan', 0);
        $this->db->from('siswa');
        return $this->db->count_all_results();
    }

    public function get_mapel_mengajar($id_guru)
    {
        $this->db->select('mapel.id_mapel, mapel.nama_mapel');
        $this->db->from('ptk_mapel');
        $this->db->join('mapel', 'mapel.id_mapel = ptk_mapel.id_mapel');
        $this->db->where('ptk_mapel.id_guru', $id_guru);
        $query = $this->db->get();
        return $query->result_array();
    }





    public function update_profile($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows() > 0;
    }


    public function update_avatar($user_id, $avatar_filename)
    {
        $data = array(
            'avatar' => $avatar_filename
        );

        $this->db->where('id', $user_id);
        $this->db->update($this->_table, $data);

        return $this->db->affected_rows() > 0;
    }







    //Fungsi Profil Sekolah
    public function get_profilsekolah_data()
    {
        return $this->db->get('perusahaan')->row_array();
    }

    public function get_logo()
    {
        $query = $this->db->get($this->_tableperusahaan); // Mengambil data dari tabel
        return $query->row_array(); // Mengembalikan satu baris data sebagai array
    }

    public function get_logopemerintah()
    {
        $query = $this->db->get($this->_tableperusahaan); // Mengambil data dari tabel
        return $query->row_array(); // Mengembalikan satu baris data sebagai array
    }


    // Menyimpan materi baru
    public function tambah_materi($data)
    {
        return $this->db->insert('materi', $data); // Menyimpan data ke tabel materi
    }


    // Ambil semua materi oleh guru tertentu
    public function get_materi_by_guru($id_guru)
    {
        $this->db->select('materi.*, mapel.nama_mapel, kelas.id_kelas, kelas.nama_kelas');
        $this->db->from('materi');
        $this->db->join('mapel', 'mapel.id_mapel = materi.id_mapel', 'left');
        $this->db->join('kelas', 'kelas.id_kelas = materi.id_kelas', 'left'); // Join dengan tabel kelas
        $this->db->where('materi.id_guru', $id_guru);
        return $this->db->get()->result_array();
    }


    public function get_detail_materi($id_materi)
    {
        $this->db->select('materi.*, kelas.nama_kelas, mapel.nama_mapel');
        $this->db->from('materi');
        $this->db->join('kelas', 'kelas.id_kelas = materi.id_kelas', 'left');
        $this->db->join('mapel', 'mapel.id_mapel = materi.id_mapel', 'left'); // Menggabungkan tabel mapel
        $this->db->where('materi.id_materi', $id_materi);
        return $this->db->get()->row();
    }

    public function get_tugas_by_materi($id_materi)
    {
        return $this->db->get_where('tugas_materi', ['id_materi' => $id_materi])->result();
    }
    public function get_jawaban_by_tugas($id_tugas)
    {
        return $this->db->select('jawaban_tugas.*, siswa.nama_siswa, siswa.nis')
            ->from('jawaban_tugas')
            ->join('siswa', 'siswa.id_siswa = jawaban_tugas.id_siswa')
            ->where('jawaban_tugas.id_tugas', $id_tugas)
            ->order_by('jawaban_tugas.tanggal_upload', 'DESC')
            ->get()
            ->result_array();
    }




    public function get_siswa_yang_mengerjakan($id_materi)
    {
        $this->db->select('siswa.id_siswa, siswa.nama_siswa, siswa.no_absen, kelas.no_kelas, tugas_materi.id_tugas, jawaban_tugas.file_jawaban, jawaban_tugas.isi_jawaban, jawaban_tugas.tanggal_upload, jawaban_tugas.nilai_essay,');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->join('materi', 'kelas.id_kelas = materi.id_kelas');
        $this->db->join('tugas_materi', 'materi.id_materi = tugas_materi.id_materi');
        $this->db->join('jawaban_tugas', 'tugas_materi.id_tugas = jawaban_tugas.id_tugas AND siswa.id_siswa = jawaban_tugas.id_siswa', 'left');
        $this->db->where('materi.id_materi', $id_materi); // Filter berdasarkan materi yang dimaksud
        $this->db->order_by('siswa.nama_siswa'); // Urutkan berdasarkan nama siswa (atau sesuai kebutuhan)

        $query = $this->db->get();

        return $query->result(); // Akan mengembalikan array objek siswa yang sudah mengumpulkan
    }

    public function get_nilai_pg_by_tugas($id_tugas)
    {
        $this->db->select('jp.id_siswa, COUNT(*) as total_benar');
        $this->db->from('jawaban_pg jp');
        $this->db->join('soal_pg sp', 'jp.id_soal = sp.id_soal');
        $this->db->where('sp.id_tugas', $id_tugas);
        $this->db->where('jp.jawaban = sp.jawaban_benar');
        $this->db->group_by('jp.id_siswa');
        $query = $this->db->get();

        $result = [];
        foreach ($query->result() as $row) {
            $result[$row->id_siswa] = $row->total_benar;
        }
        return $result; // Array dengan key = id_siswa, value = jumlah benar
    }


    public function get_soal_pg_by_tugas($id_tugas)
    {
        return $this->db->get_where('soal_pg', ['id_tugas' => $id_tugas])->result();
    }
    public function get_jawaban_pg_by_tugas($id_tugas)
    {
        $this->db->select('jawaban_pg.id_siswa, jawaban_pg.id_soal, jawaban_pg.jawaban');
        $this->db->from('jawaban_pg');
        $this->db->join('soal_pg', 'jawaban_pg.id_soal = soal_pg.id_soal');
        $this->db->where('soal_pg.id_tugas', $id_tugas);
        return $this->db->get()->result();
    }






    //Fungsi Siswa
    public function get_siswa()
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->order_by('nama_kelas', 'ASC');
        $this->db->order_by('no_absen');
        $query = $this->db->get();
        return $query->result_array();
    }




    public function get_siswa_by_id($siswa_id)
    {
        return $this->db->get_where('siswa', array('id' => $siswa_id))->row_array();
    }
}
