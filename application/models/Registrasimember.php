<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasimember extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
    }

    public function register($name, $avatar, $nama_lembaga, $alamat, $provinsi, $kabupaten, $kecamatan, $notelp, $email, $password) {
        // Buat data array untuk dimasukkan ke dalam database
        $data = array(
            'name'          => $name,
            'avatar'        => $avatar,
            'nama_lembaga'  => $nama_lembaga,
            'alamat'        => $alamat,
            'provinsi'      => $provinsi,
            'kabupaten'     => $kabupaten,
            'kecamatan'     => $kecamatan,
            'notelp'        => $notelp,
            'email'         => $email,
            'password'      => password_hash($password, PASSWORD_DEFAULT) // Hash password sebelum disimpan ke database
        );

        // Masukkan data ke dalam tabel 'users'
        $this->db->insert('member', $data);
    }
}
