<?php
class User_model extends CI_Model
{



    public function get_user_by_username($username)
    {
        $this->db->select('siswa.*, kelas.*');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas', 'left');
        $this->db->where('siswa.username', $username);
        $query = $this->db->get();
        return $query->row();
    }
}
