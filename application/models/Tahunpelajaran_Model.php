<?php
class Tahunpelajaran_Model extends CI_Model
{

    private $_tableperusahaan = "perusahaan";
    private $_tablesite = "site";
	private $_table = "admin";
	const SESSION_KEY = 'admin_id';


    //Fungsi Tahun Peljaran

    public function get_tahunpelajaran() {
        $this->db->order_by('tahun_pelajaran', 'DESC');
        $query = $this->db->get('tahunpelajaran');
        return $query->result_array();
    }

    public function get_tahunpelajaran_by_id($tahunpelajaran_id){
        return $this->db->get_where('tahunpelajaran', array('id_tahunpelajaran' => $tahunpelajaran_id))->row_array();
    }

    public function get_tahunpelajaran_by_tahun($tahun_pelajaran) {
        $this->db->where('tahun_pelajaran', $tahun_pelajaran);
        $query = $this->db->get('tahunpelajaran');
        return $query->row();
    }

    public function simpan_tahunpelajaran($data){
        $this->db->insert('tahunpelajaran', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_tahunpelajaran($tahunpelajaran_id, $data){
        $this->db->where('id_tahunpelajaran', $tahunpelajaran_id);
        $this->db->update('tahunpelajaran', $data);
        return $this->db->affected_rows() > 0;
        }

    public function hapus_tahunpelajaran($tahunpelajaran_id) {
        $this->db->where('id_tahunpelajaran', $tahunpelajaran_id);
        $result = $this->db->delete('tahunpelajaran');
        return $result;
    }


    



}

?>