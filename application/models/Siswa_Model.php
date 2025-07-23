<?php
// File: application/models/Admin.php

class Siswa_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
    private $_table = "admin";
    const SESSION_KEY = 'admin_id';


    //Fungsi Alumni
    public function get_alumni()
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->where('siswa.status_kelulusan', 1); // Hanya ambil siswa dengan status_kelulusan 0
        $this->db->order_by('nama_kelas', 'ASC');
        $this->db->order_by('no_absen');
        $query = $this->db->get();
        return $query->result_array();
    }


    //Fungsi Siswa
    public function get_siswa()
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->where('siswa.status_kelulusan', 0); // Hanya ambil siswa dengan status_kelulusan 0
        $this->db->order_by('nama_kelas', 'ASC');
        $this->db->order_by('no_absen');
        $query = $this->db->get();
        return $query->result_array();
    }



    public function simpan_siswa($data)
    {
        $this->db->insert('siswa', $data);
        return $this->db->affected_rows() > 0;
    }

    // Di dalam model Siswa
    public function simpan_siswa_from_excel(
        $username,
        $password,
        $nis,
        $nisn,
        $nama_siswa,
        $jeniskelamin,
        $agama,
        $tempatlahir,
        $tanggallahir,
        $kode_kelas,
        $no_absen,
        $tahun_angkatan,
        $anakke,
        $jumlahsaudara,
        $hobi,
        $citacita,
        $nohp,
        $siswa_alamat,
        $siswa_kelurahan,
        $siswa_kecamatan,
        $siswa_kabupaten,
        $siswa_provinsi,
        $siswa_jaraksekolah,
        $siswa_transportasi,
        $siswa_tinggal,
        $ayah_nama,
        $ayah_nik,
        $ayah_tempatlahir,
        $ayah_tanggallahir,
        $ayah_agama,
        $ayah_pendidikan,
        $ayah_pekerjaan,
        $ayah_penghasilan,
        $ayah_alamat,
        $ayah_desakel,
        $ayah_kecamatan,
        $ayah_kabupaten,
        $ayah_provinsi,
        $ayah_nohp,
        $ayah_status,
        $ibu_nama,
        $ibu_nik,
        $ibu_tempatlahir,
        $ibu_tanggallahir,
        $ibu_agama,
        $ibu_pendidikan,
        $ibu_pekerjaan,
        $ibu_penghasilan,
        $ibu_alamat,
        $ibu_desakel,
        $ibu_kecamatan,
        $ibu_kabupaten,
        $ibu_provinsi,
        $ibu_nohp,
        $ibu_status,
        $pendukung_golongandarah,
        $pendukung_penyakit,
        $pendukung_kelainanjasmani,
        $pendukung_tinggibadan,
        $pendukung_beratbadan,
        $asal_sekolah,
        $asal_noijazah,
        $asal_noskhu,
        $asal_tanggal,
        $wali_nama,
        $wali_nik,
        $wali_tempatlahir,
        $wali_tanggallahir,
        $wali_agama,
        $wali_pendidikan,
        $wali_pekerjaan,
        $wali_penghasilan,
        $wali_alamat,
        $wali_desakel,
        $wali_kecamatan,
        $wali_kabupaten,
        $wali_provinsi,
        $wali_nohp,
        $wali_status,
        $kegemaran_kesenian,
        $kegemaran_olahraga,
        $kegemaran_organisasi,
        $kegemaran_lainlain
    ) {
        // Lakukan validasi data jika diperlukan

        // Buat array data siswa untuk disimpan ke dalam database
        $data = array(
            'username'          => $username,
            'password'          => $password,
            'nis'               => $nis,
            'nisn'              => $nisn,
            'nama_siswa'        => $nama_siswa,
            'jeniskelamin'      => $jeniskelamin,
            'agama'             => $agama,
            'tempatlahir'       => $tempatlahir,
            'tanggallahir'      => $tanggallahir,
            'kode_kelas'        => $kode_kelas,
            'no_absen'          => $no_absen,
            'tahun_angkatan'    => $tahun_angkatan,
            'anakke'            => $anakke,
            'jumlahsaudara'     => $jumlahsaudara,
            'hobi'              => $hobi,
            'citacita'          => $citacita,
            'nohp'              => $nohp,
            'avatar'            => 'default.png',

            'siswa_alamat'        => $siswa_alamat,
            'siswa_kelurahan'     => $siswa_kelurahan,
            'siswa_kecamatan'     => $siswa_kecamatan,
            'siswa_kabupaten'     => $siswa_kabupaten,
            'siswa_provinsi'      => $siswa_provinsi,
            'siswa_jaraksekolah'  => $siswa_jaraksekolah,
            'siswa_transportasi'  => $siswa_transportasi,
            'siswa_tinggal'       => $siswa_tinggal,

            //Kesehatan Siswa
            'pendukung_golongandarah'   => $pendukung_golongandarah,
            'pendukung_penyakit'        => $pendukung_penyakit,
            'pendukung_kelainanjasmani' => $pendukung_kelainanjasmani,
            'pendukung_tinggibadan'     => $pendukung_tinggibadan,
            'pendukung_beratbadan'      => $pendukung_beratbadan,

            //ayah Siswa
            'ayah_nama'           => $ayah_nama,
            'ayah_nik'            => $ayah_nik,
            'ayah_tempatlahir'    => $ayah_tempatlahir,
            'ayah_tanggallahir'   => $ayah_tanggallahir,
            'ayah_agama'          => $ayah_agama,
            'ayah_pendidikan'     => $ayah_pendidikan,
            'ayah_pekerjaan'      => $ayah_pekerjaan,
            'ayah_penghasilan'    => $ayah_penghasilan,
            'ayah_alamat'         => $ayah_alamat,
            'ayah_desakel'        => $ayah_desakel,
            'ayah_kecamatan'      => $ayah_kecamatan,
            'ayah_kabupaten'      => $ayah_kabupaten,
            'ayah_provinsi'       => $ayah_provinsi,
            'ayah_nohp'           => $ayah_nohp,
            'ayah_status'         => $ayah_status,

            //ibu siswa
            'ibu_nama'            => $ibu_nama,
            'ibu_nik'             => $ibu_nik,
            'ibu_tempatlahir'     => $ibu_tempatlahir,
            'ibu_tanggallahir'    => $ibu_tanggallahir,
            'ibu_agama'           => $ibu_agama,
            'ibu_pendidikan'      => $ibu_pendidikan,
            'ibu_pekerjaan'       => $ibu_pekerjaan,
            'ibu_penghasilan'     => $ibu_penghasilan,
            'ibu_alamat'          => $ibu_alamat,
            'ibu_desakel'         => $ibu_desakel,
            'ibu_kecamatan'       => $ibu_kecamatan,
            'ibu_kabupaten'       => $ibu_kabupaten,
            'ibu_provinsi'        => $ibu_provinsi,
            'ibu_nohp'            => $ibu_nohp,
            'ibu_status'          => $ibu_status,

            'asal_sekolah'        => $asal_sekolah,
            'asal_noijazah'       => $asal_noijazah,
            'asal_noskhu'         => $asal_noskhu,
            'asal_tanggal'        => $asal_tanggal,

            'wali_nama'           => $wali_nama,
            'wali_nik'            => $wali_nik,
            'wali_tempatlahir'    => $wali_tempatlahir,
            'wali_tanggallahir'   => $wali_tanggallahir,
            'wali_agama'          => $wali_agama,
            'wali_pendidikan'     => $wali_pendidikan,
            'wali_pekerjaan'      => $wali_pekerjaan,
            'wali_penghasilan'    => $wali_penghasilan,
            'wali_alamat'         => $wali_alamat,
            'wali_desakel'        => $wali_desakel,
            'wali_kecamatan'      => $wali_kecamatan,
            'wali_kabupaten'      => $wali_kabupaten,
            'wali_provinsi'       => $wali_provinsi,
            'wali_nohp'           => $wali_nohp,
            'wali_status'         => $wali_status,

            'kegemaran_kesenian'   => $kegemaran_kesenian,
            'kegemaran_olahraga'   => $kegemaran_olahraga,
            'kegemaran_organisasi' => $kegemaran_organisasi,
            'kegemaran_lainlain'   => $kegemaran_lainlain,

            // Isi kolom lainnya sesuai dengan struktur tabel siswa Anda
        );

        // Lakukan penyimpanan data ke dalam database
        $this->db->insert('siswa', $data);

        // Return nilai boolean untuk menunjukkan apakah penyimpanan berhasil atau tidak
        return $this->db->affected_rows() > 0;
    }



    public function get_siswa_by_id($siswa_id)
    {
        $this->db->select('siswa.*, kelas.*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->where('siswa.id_siswa', $siswa_id);
        return $this->db->get()->row_array();
    }


    public function get_siswa_by_kodekelas($no_kelas)
    {
        $this->db->select('siswa.*, kelas.*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas');
        $this->db->where('siswa.id_siswa', $no_kelas);
        return $this->db->get()->row_array();
    }



    public function update_siswa($siswa_id, $data)
    {
        $this->db->where('id_siswa', $siswa_id);
        $this->db->update('siswa', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_qr_code_path($id_siswa, $qr_code_path)
    {
        $data = array(
            'qrcode_siswa' => $qr_code_path
        );

        $this->db->where('id_siswa', $id_siswa);
        $this->db->update('siswa', $data);
    }


    public function hapus_siswa($siswa_id)
    {
        $this->db->where('id_siswa', $siswa_id);
        $result = $this->db->delete('siswa');
        return $result;
    }

    public function kosongkan_siswa()
    {
        $this->db->empty_table('siswa');
    }

    public function export_siswa()
    {
        // Sesuaikan query ini dengan struktur tabel dan kolom yang sesuai dengan database Anda
        $query = $this->db->query("SELECT * FROM siswa");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
}
