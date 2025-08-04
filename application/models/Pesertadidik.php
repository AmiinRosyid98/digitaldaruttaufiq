<?php
// File: application/models/Admin.php

class Pesertadidik extends CI_Model
{
    private $_table = "siswa";
    const SESSION_KEY = 'siswa_id';



    public function get_siswa_by_qr_code($qr_code)
    {
        $this->db->where('id_siswa', $qr_code);
        $query = $this->db->get('siswa');
        return $query->row();
    }


    public function update_profile($id, $data)
    {
        $this->db->where('id_siswa', $id); // Lakukan update data profil berdasarkan ID pengguna
        $this->db->update($this->_table, $data);

        return $this->db->affected_rows() > 0; // Periksa apakah proses update berhasil
    }


    public function update_avatar($user_id, $avatar_filename)
    {
        $data = array(
            'avatar' => $avatar_filename
        );

        $this->db->where('id_siswa', $user_id);
        $this->db->update($this->_table, $data);

        return $this->db->affected_rows() > 0;
    }

    public function get_perusahaan_data()
    {
        return $this->db->get('perusahaan')->row_array();
    }



    public function get_datasiswa($id_siswa)
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');

        $this->db->where('id_siswa', $id_siswa);
        $query = $this->db->get();
        return $query->row_array(); // Mengembalikan satu baris data sebagai array asosiatif
    }

    public function get_dataraport($id_siswa)
    {
        $this->db->select('*');
        $this->db->from('raport');
        $this->db->join('kelas', 'raport.id_kelas = kelas.id_kelas');
        $this->db->join('ptk', 'ptk.id_guru = raport.id_guru');

        $this->db->where('raport.id_siswa', $id_siswa);
        $this->db->group_by("raport.id_kelas")
        ;
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan satu baris data sebagai array asosiatif
    }

    // Model Pesertadidik
    public function get_buku_by_siswa_kode_kelas($siswa_kode_kelas)
    {
        $this->db->select('buku.*, kelas.nama_kelas, ptk.nama_ptk,'); // Memilih kolom yang diperlukan, termasuk nama_guru dari tabel ptk
        $this->db->from('buku');
        $this->db->join('kelas', 'buku.kode_kelas = kelas.no_kelas', 'left');
        $this->db->join('ptk', 'buku.id_guru = ptk.id_guru', 'left');
        $this->db->like('buku.kode_kelas', $siswa_kode_kelas); // Menggunakan like untuk mencocokkan kode_kelas siswa dengan kode_kelas buku
        $this->db->order_by('buku.id_buku', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    // Di dalam model Pesertadidik.php
    public function get_materi_by_kode_kelas($kode_kelas)
    {
        $this->db->select('materi.*, mapel.nama_mapel, kelas.nama_kelas, ptk.nama_ptk');
        $this->db->from('materi');
        $this->db->join('mapel', 'mapel.id_mapel = materi.id_mapel', 'left');
        $this->db->join('kelas', 'kelas.id_kelas = materi.id_kelas', 'left');
        $this->db->join('ptk', 'ptk.id_guru = materi.id_guru', 'left');
        $this->db->where('kelas.no_kelas', $kode_kelas);
        $this->db->order_by('materi.tanggal_dibuat', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_materi_detail($id_materi)
    {
        $this->db->select('materi.*, mapel.nama_mapel, kelas.nama_kelas, ptk.nama_ptk');
        $this->db->from('materi');
        $this->db->join('mapel', 'mapel.id_mapel = materi.id_mapel', 'left');
        $this->db->join('kelas', 'kelas.id_kelas = materi.id_kelas', 'left');
        $this->db->join('ptk', 'ptk.id_guru = materi.id_guru', 'left');
        $this->db->where('materi.id_materi', $id_materi);
        return $this->db->get()->row_array();
    }

    public function get_tugas_by_materi($id_materi)
    {
        $this->db->select('*');
        $this->db->from('tugas_materi');
        $this->db->where('id_materi', $id_materi);
        $this->db->order_by('tanggal_dibuat', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_tugas_detail($id_tugas)
    {
        return $this->db->get_where('tugas_materi', ['id_tugas' => $id_tugas])->row_array();
    }
    public function get_soal_pg($id_tugas)
    {
        $this->db->select('*');
        $this->db->from('soal_pg');
        $this->db->where('id_tugas', $id_tugas);
        $query = $this->db->get();

        return $query->result_array(); // Mengembalikan semua soal dalam bentuk array
    }

    public function simpan_jawaban_pg($id_siswa, $id_soal, $jawaban)
    {
        $data = array(
            'id_siswa' => $id_siswa,
            'id_soal' => $id_soal,
            'jawaban' => $jawaban
        );

        // Cek apakah jawaban siswa sudah ada untuk soal ini
        $this->db->where('id_siswa', $id_siswa);
        $this->db->where('id_soal', $id_soal);
        $query = $this->db->get('jawaban_pg');

        if ($query->num_rows() > 0) {
            // Jika sudah ada, update jawaban siswa
            $this->db->where('id_siswa', $id_siswa);
            $this->db->where('id_soal', $id_soal);
            $this->db->update('jawaban_pg', $data);
        } else {
            // Jika belum ada, insert jawaban baru
            $this->db->insert('jawaban_pg', $data);
        }
    }

    public function simpan_jawaban($data)
    {
        $cek = $this->db->get_where('jawaban_tugas', [
            'id_tugas' => $data['id_tugas'],
            'id_siswa' => $data['id_siswa']
        ])->row();

        if ($cek) {
            // Update jika sudah pernah mengumpulkan
            $this->db->where('id_tugas', $data['id_tugas']);
            $this->db->where('id_siswa', $data['id_siswa']);
            $this->db->update('jawaban_tugas', $data);
        } else {
            // Insert baru
            $this->db->insert('jawaban_tugas', $data);
        }
    }
    public function get_jawaban_pg($id_siswa, $id_tugas)
    {
        $this->db->select('jawaban_pg.id_soal, jawaban_pg.jawaban');
        $this->db->from('jawaban_pg');
        $this->db->join('soal_pg', 'soal_pg.id_soal = jawaban_pg.id_soal');
        $this->db->where('jawaban_pg.id_siswa', $id_siswa);
        $this->db->where('soal_pg.id_tugas', $id_tugas);
        $query = $this->db->get();

        $result = [];
        foreach ($query->result() as $row) {
            $result[$row->id_soal] = $row->jawaban;
        }

        return $result;
    }


    public function get_jawaban_siswa($id_tugas, $id_siswa)
    {
        return $this->db->get_where('jawaban_tugas', ['id_tugas' => $id_tugas, 'id_siswa' => $id_siswa])->row_array();
    }













    //Fungsi Pembayaran
    public function get_pembayarann($id_siswa)
    {
        $this->db->select('*, SUM(pembayaran.jumlah_pembayaran) as jumlah_pembayaran');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->join('tarifpembayaran', 'siswa.kode_kelas = tarifpembayaran.kode_kelas');
        $this->db->join('jenispembayaran', 'tarifpembayaran.kode_pembayaran = jenispembayaran.id_jenispembayaran', 'left');
        $this->db->join('tahunpelajaran', 'jenispembayaran.kode_tahunpelajaran = tahunpelajaran.id_tahunpelajaran', 'left');
        $this->db->join('pembayaran', 'tahunpelajaran.id_tahunpelajaran = pembayaran.id_tahunpelajaran', 'left');
        $this->db->join('poskeuangan', 'jenispembayaran.kode_pos = poskeuangan.id_pos', 'left');
        $this->db->join('tipepembayaran', 'jenispembayaran.tipe_pembayaran = tipepembayaran.id_tipepembayaran', 'left');
        $this->db->group_by('siswa.id_siswa, poskeuangan.id_pos');
        $this->db->where('siswa.id_siswa', $id_siswa);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_pembayaran($id_siswa)
    {
        
        $get_pembayaran = $this->db->query("
            SELECT * FROM tarifpembayaran 
            LEFT JOIN jenispembayaran jp ON jp.id_jenispembayaran = tarifpembayaran.kode_pembayaran 
            LEFT JOIN poskeuangan pk ON pk.id_pos = jp.kode_pos 
            LEFT JOIN kelas k on k.no_kelas = tarifpembayaran.kode_kelas
            LEFT JOIN tahunpelajaran tp on tp.id_tahunpelajaran = jp.kode_tahunpelajaran
            WHERE tarifpembayaran.kode_kelas = '" . $this->Pesertadidik->get_datasiswa($id_siswa)['kode_kelas'] . "'
        ");

        $result = array(); // Array akhir

        foreach($get_pembayaran->result() as $key){
            $this->db->select('
                siswa.id_siswa, siswa.nis, siswa.nama_siswa, kelas.nama_kelas, 
                poskeuangan.nama_pos, pembayaran.id_pembayaran, pembayaran.jumlah_tarif, 
                tahunpelajaran.tahun_pelajaran, 
                SUM(pembayaran.jumlah_pembayaran) as jumlah_pembayaran,
                pembayaran.* 
            ');
            $this->db->from('pembayaran');
            $this->db->join('siswa', 'pembayaran.id_siswa = siswa.id_siswa', 'left');
            $this->db->join('kelas', 'pembayaran.id_kelas = kelas.no_kelas', 'left');
            $this->db->join('poskeuangan', 'pembayaran.id_pos = poskeuangan.id_pos', 'left');
            $this->db->join('tahunpelajaran', 'pembayaran.id_tahunpelajaran = tahunpelajaran.id_tahunpelajaran', 'left');

            $this->db->where('siswa.id_siswa', $id_siswa);
            $this->db->where('id_pembayaran', $key->id_pembayaran );
            $this->db->group_by('pembayaran.id_pos, pembayaran.id_tahunpelajaran, pembayaran.id_kelas');
            $this->db->order_by('kelas.nama_kelas, tahunpelajaran.tahun_pelajaran', 'ASC');


            $query = $this->db->get();
            // var_dump($this->db->last_query());die;

            if($query->num_rows()>0){
                foreach ($query->result_array() as $row) {
                     $result[] = [
                        'id_siswa'          => $row['id_siswa'],
                        'nis'               => $row['nis'],
                        'nama_siswa'        => $row['nama_siswa'],
                        'nama_kelas'        => $row['nama_kelas'],
                        'nama_pos'          => $row['nama_pos'],
                        'id_pembayaran'     => $row['id_pembayaran'],
                        'id_pembayaran_enc' => urlencode($this->encryption->encrypt($row['id_pembayaran'])),
                        'jumlah_tarif'      => $row['jumlah_tarif'],
                        'tahun_pelajaran'   => $row['tahun_pelajaran'],
                        'jumlah_pembayaran' => $row['jumlah_pembayaran'],
                        'metode_pembayaran' => $row['metode_pembayaran'],
                    ];
                }
            } else {
                $result[] = [
                        'id_siswa'          => $id_siswa,
                        'nis'               => $this->Pesertadidik->get_datasiswa($id_siswa)['nis'],
                        'nama_siswa'        => $this->Pesertadidik->get_datasiswa($id_siswa)['nama_siswa'],
                        'nama_kelas'        => $key->nama_kelas,
                        'nama_pos'          => $key->nama_pos,
                        'id_pembayaran'     => $key->id_pembayaran,
                        'id_pembayaran_enc' => urlencode($this->encryption->encrypt($key->id_pembayaran)),
                        'jumlah_tarif'      => $key->jumlah_tarif,
                        'tahun_pelajaran'   => $key->tahun_pelajaran,
                        'jumlah_pembayaran' => "0",
                        'metode_pembayaran' => $row['metode_pembayaran'],
                        
                    ];
            }
        }
        return $result;
        //asdas
        //adasds
        // echo "<pre>";
        // var_dump($result);die;



        // $this->db->select('siswa.id_siswa, siswa.nis, siswa.nama_siswa, kelas.nama_kelas, poskeuangan.nama_pos, pembayaran.id_pembayaran, pembayaran.jumlah_tarif, tahunpelajaran.tahun_pelajaran, SUM(pembayaran.jumlah_pembayaran) as jumlah_pembayaran');
        // $this->db->from('pembayaran');
        // $this->db->join('siswa', 'pembayaran.id_siswa = siswa.id_siswa', 'left');
        // $this->db->join('kelas', 'pembayaran.id_kelas = kelas.no_kelas', 'left');
        // $this->db->join('poskeuangan', 'pembayaran.id_pos = poskeuangan.id_pos', 'left');
        // $this->db->join('tahunpelajaran', 'pembayaran.id_tahunpelajaran = tahunpelajaran.id_tahunpelajaran', 'left');

        // $this->db->group_by('pembayaran.id_pos, pembayaran.id_tahunpelajaran, pembayaran.id_kelas, '); // Mengelompokkan berdasarkan id_siswa dan id_pos
        // //$this->db->where('siswa.status_kelulusan', 0);
        // $this->db->where('siswa.id_siswa', $id_siswa);
        // $this->db->order_by('kelas.nama_kelas, tahunpelajaran.tahun_pelajaran', 'ASC');

        // $query = $this->db->get();
        // var_dump($this->db->last_query());die;
        // return $query->result_array();
    }
}
