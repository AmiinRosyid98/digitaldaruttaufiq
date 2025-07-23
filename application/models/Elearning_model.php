<?php
class Elearning_model extends CI_Model
{
    // Ambil semua materi oleh guru tertentu
    public function get_materi_by_guru($id_guru)
    {
        $this->db->select('materi.*, mapel.nama_mapel');
        $this->db->from('materi');
        $this->db->join('mapel', 'mapel.id_mapel = materi.id_mapel', 'left');
        $this->db->where('materi.id_guru', $id_guru);
        return $this->db->get()->result_array();
    }
}
