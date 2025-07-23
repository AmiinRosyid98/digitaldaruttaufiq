<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ppdb_Model extends CI_Model
{
    // Variabel untuk DataTables
    private $table = 'ppdb_pendaftar';
    private $column_order = array(null, 'nama_lengkap', 'nisn', 'asal_sekolah', 'status', 'created_at', null);
    private $column_search = array('nama_lengkap', 'nisn', 'asal_sekolah');
    private $order = array('created_at' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    // Dapatkan setting PPDB
    public function get_setting()
    {
        $this->db->from('ppdb_setting');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }


    // Update setting PPDB
    public function update_setting($data)
    {
        $this->db->trans_start();

        // Update setting
        $this->db->update('ppdb_setting', $data);

        // Jika nonaktifkan multi jalur, nonaktifkan semua jalur kecuali jalur utama
        if (isset($data['is_multi_jalur']) && $data['is_multi_jalur'] == 0) {
            $this->db->where('id !=', 1); // Jalur utama memiliki id=1
            $this->db->update('ppdb_jalur', array('is_active' => 0));
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }


    // Dapatkan semua jalur
    public function get_all_jalur()
    {
        return $this->db->get('ppdb_jalur')->result();
    }

    // Dapatkan jalur aktif
    public function get_active_jalur()
    {
        $this->db->where('is_active', 1);
        return $this->db->get('ppdb_jalur')->result();
    }

    // Dapatkan jalur by ID
    public function get_jalur_by_id($id)
    {
        return $this->db->get_where('ppdb_jalur', array('id' => $id))->row();
    }

    // Insert jalur baru
    public function insert_jalur($data)
    {
        $this->db->insert('ppdb_jalur', $data);
        return $this->db->insert_id();
    }

    // Update jalur
    public function update_jalur($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('ppdb_jalur', $data);
    }

    // Update status jalur
    public function update_jalur_status($id, $status)
    {
        $this->db->where('id', $id);
        return $this->db->update('ppdb_jalur', array('is_active' => $status));
    }

    // Hapus jalur
    public function delete_jalur($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('ppdb_jalur');
    }

    // Untuk mendapatkan total persentase kuota
    public function get_total_persentase_kuota()
    {
        $this->db->select_sum('persentase_kuota');
        $this->db->where('is_active', 1);
        $query = $this->db->get('ppdb_jalur');
        return $query->row()->persentase_kuota ?: 0;
    }

    // Untuk mendapatkan kuota per jalur berdasarkan persentase
    public function get_kuota_per_jalur($total_kuota)
    {
        $this->db->select('id, nama_jalur, persentase_kuota');
        $this->db->where('is_active', 1);
        $query = $this->db->get('ppdb_jalur');

        $result = array();
        foreach ($query->result() as $row) {
            $result[] = array(
                'id' => $row->id,
                'nama_jalur' => $row->nama_jalur,
                'kuota' => floor($total_kuota * $row->persentase_kuota / 100),
                'persentase' => $row->persentase_kuota
            );
        }

        return $result;
    }

    // Tambahkan log
    public function add_log($data)
    {
        $current_user = $this->auth_admin->current_user();

        if (!$current_user) {
            return false; // Tidak menyimpan log jika tidak ada user
        }

        $log_data = array(
            'user_id' => $current_user->id,
            'action' => $data['action'],
            'table_name' => $data['table'],
            'record_id' => $data['record_id'],
            'old_value' => isset($data['old_value']) ? json_encode($data['old_value']) : null,
            'new_value' => isset($data['new_value']) ? json_encode($data['new_value']) : null,
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('ppdb_logs', $log_data);
    }















    public function get_all_pendaftar()
    {
        $this->db->select('p.*, j.nama_jalur');
        $this->db->from('ppdb_pendaftaran p');
        $this->db->join('ppdb_jalur j', 'j.id = p.jalur_id', 'left');
        $this->db->order_by('p.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function create($data)
    {
        return $this->db->insert('ppdb_pendaftaran', $data);
    }

    public function get_by_no($no_pendaftaran)
    {
        $this->db->select('ppdb_pendaftaran.*, ppdb_jalur.nama_jalur');
        $this->db->from('ppdb_pendaftaran');
        $this->db->join('ppdb_jalur', 'ppdb_pendaftaran.jalur_id = ppdb_jalur.id', 'left');
        $this->db->where('ppdb_pendaftaran.no_pendaftaran', $no_pendaftaran);
        return $this->db->get()->row();
    }



    public function get_pendaftar($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('ppdb_pendaftar')->result_array();
    }

    public function count_pendaftar()
    {
        return $this->db->count_all('ppdb_pendaftar');
    }

    public function get_pendaftar_by_id($id)
    {
        $this->db->select('ppdb_pendaftaran.*, ppdb_jalur.nama_jalur');
        $this->db->from('ppdb_pendaftaran');
        $this->db->join('ppdb_jalur', 'ppdb_jalur.id = ppdb_pendaftaran.jalur_id', 'left');
        $this->db->where('ppdb_pendaftaran.id', $id);
        return $this->db->get()->row_array();
    }



    public function update_status_pendaftar($id, $status)
    {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s') // Tambah updated_at
        ];

        $this->db->where('id', $id);
        return $this->db->update('ppdb_pendaftaran', $data);
    }


    public function delete_pendaftaran($id)
    {
        $this->db->where('id', $id)->delete('ppdb_pendaftaran');
    }


    public function simpan_pendaftar($data)
    {
        return $this->db->insert('ppdb_pendaftar', $data);
    }

    // [Fungsi baru untuk DataTables Server-Side Processing]

    /**
     * Query utama untuk DataTables
     */
    private function _get_datatables_query()
    {
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    /**
     * Ambil data yang sudah difilter
     */
    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Hitung jumlah data yang difilter
     */
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Hitung jumlah semua data
     */
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /**
     * Ambil data untuk select filter (opsional)
     */
    public function get_unique_status()
    {
        $this->db->select('status');
        $this->db->distinct();
        $this->db->order_by('status', 'asc');
        return $this->db->get($this->table)->result();
    }
}
