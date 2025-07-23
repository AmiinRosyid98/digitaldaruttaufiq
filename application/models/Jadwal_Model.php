<?php
class Jadwal_Model extends CI_Model
{
    public function get_jadwalkbm($id_guru)
    {
        $this->db->select('*');
        $this->db->from('ptk_jadwalkbm');
        $this->db->join('ptk', 'ptk.id_guru = ptk_jadwalkbm.id_guru', 'LEFT');
        $this->db->join('kelas', 'kelas.id_kelas = ptk_jadwalkbm.id_kelas', 'LEFT');
        $this->db->join('mapel', 'mapel.id_mapel = ptk_jadwalkbm.id_mapel', 'LEFT');
        $this->db->where('ptk.id_guru', $id_guru);

        $query = $this->db->get();
        return $query->result_array();
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

    public function get_mapelmengajar($id_guru)
    {
        $this->db->select('*');
        $this->db->from('ptk_mapel');
        $this->db->join('ptk', 'ptk_mapel.id_guru = ptk.id_guru', 'left');
        $this->db->join('mapel', 'ptk_mapel.id_mapel = mapel.id_mapel', 'left');
        $this->db->where('ptk.id_guru', $id_guru);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function simpanjadwalkbm($data)
    {
        $this->db->insert('ptk_jadwalkbm', $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapusjadwalkbm($id)
    {
        return $this->db->delete('ptk_jadwalkbm', ['id' => $id]);
    }

    public function get_jadwal_by_id($id)
    {
        return $this->db->get_where('ptk_jadwalkbm', ['id' => $id])->row_array();
    }

    public function update_jadwalkbm($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('ptk_jadwalkbm', $data);
    }
}
