<?php
// File: application/models/Admin.php

class Soalpg_model extends CI_Model
{
    public function get_by_tugas($id_tugas)
    {
        return $this->db->get_where('soal_pg', ['id_tugas' => $id_tugas])->result_array();
    }

    public function get_by_id($id_soal)
    {
        return $this->db->get_where('soal_pg', ['id_soal' => $id_soal])->row_array();
    }
}
