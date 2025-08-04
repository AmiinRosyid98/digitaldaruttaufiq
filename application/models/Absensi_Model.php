<?php
class Absensi_Model extends CI_Model
{

    private $_table_absensionline = "absensionline";

    const SESSION_KEY = 'admin_id';


    

    //Fungsi Siswa Berdasarkan Kelas
    public function get_absensimanual()
    {
        $this->db->select('kelas.id_kelas, kelas.no_kelas, kelas.nama_kelas, kelas.kode_tingkat, SUM(CASE WHEN siswa.status_kelulusan = 0 THEN 1 ELSE 0 END) as jumlah_siswa');
        $this->db->from('kelas');
        $this->db->join('siswa', 'kelas.no_kelas = siswa.kode_kelas', 'left');
        $this->db->group_by('kelas.no_kelas');
        $this->db->order_by('nama_kelas', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_absensionline($start_date, $kelas_id = null)
    {
        // Format tanggal sesuai dengan format yang digunakan di database
        $startDateFormatted = date('Y-m-d', strtotime($start_date));

        // Pilih kolom yang akan ditampilkan
        $this->db->select('
            siswa.id_siswa, 
            siswa.nama_siswa, 
            siswa.jeniskelamin, 
            siswa.nis, 
            siswa.no_absen, 
            kelas.nama_kelas, 
            COALESCE(absensionline.absen, "Tidak Masuk") AS absen, 
            absensionline.timestamp
        ');
        $this->db->from('siswa');

        // Bergabung dengan tabel kelas dan absensionline
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas', 'left');
        $this->db->join('absensionline', 'siswa.id_siswa = absensionline.id_siswa 
            AND DATE(absensionline.timestamp) = ' . $this->db->escape($startDateFormatted), 'left');

        // Filter berdasarkan kelas jika ada
        if ($kelas_id !== null && $kelas_id != "") {
            $this->db->where('kelas.id_kelas', $kelas_id);
        }

        // Urutkan hasil
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        $this->db->order_by('siswa.no_absen', 'ASC');

        // Eksekusi query
        $query = $this->db->get();

        // Debug: Tampilkan query untuk pemecahan masalah
        // Uncomment the line below if you want to see the generated SQL query for debugging
        // echo $this->db->last_query();

        // Kembalikan hasil dalam bentuk array
        return $query->result_array();
    }

    public function get_absensionline_bulanan($month, $year, $kelas_id)
    {
         // Format tanggal sesuai dengan format yang digunakan di database
        // $startDateFormatted = date('Y-m-d', strtotime($start_date));

        // Pilih kolom yang akan ditampilkan
        $this->db->select('
            siswa.id_siswa, 
            siswa.nama_siswa, 
            siswa.jeniskelamin, 
            siswa.nis, 
            siswa.no_absen, 
            kelas.nama_kelas, 
            kelas.kode_tingkat, 
            COALESCE(absensionline.absen, "Tidak Masuk") AS absen, 
            absensionline.timestamp
        ');
        $this->db->from('siswa');

        // Bergabung dengan tabel kelas dan absensionline
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas', 'left');
        $this->db->join('absensionline', 'siswa.id_siswa = absensionline.id_siswa 
            AND MONTH(absensionline.timestamp) = ' . $this->db->escape($month) . ' AND YEAR(absensionline.timestamp) = ' . $this->db->escape($year), 'left');

        // Filter berdasarkan kelas jika ada
        // gaiso langsung update


        if ($kelas_id !== null && $kelas_id != "") {
            $this->db->where('kelas.id_kelas', $kelas_id);
        }

        // Urutkan hasil
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        $this->db->order_by('siswa.no_absen', 'ASC');

        // Eksekusi query
        $query = $this->db->get();

        // Debug: Tampilkan query untuk pemecahan masalah
        // Uncomment the line below if you want to see the generated SQL query for debugging
        // echo $this->db->last_query();

        // Kembalikan hasil dalam bentuk array
        return $query->result_array();
    }





    public function get_absensiguru($start_date)
    {
        // Format tanggal sesuai dengan format yang digunakan di database
        $startDateFormatted = date('Y-m-d', strtotime($start_date));

        // Query untuk mengambil data berdasarkan satu tanggal
        $this->db->select('ptk.id_guru, ptk.nama_ptk, ptk.nip, absensiguru.absen, absensiguru.timestamp');
        $this->db->from('ptk');
        $this->db->join('absensiguru', 'ptk.id_guru = absensiguru.id_guru AND DATE(absensiguru.timestamp) = ' . $this->db->escape($startDateFormatted), 'left');
        $this->db->order_by('nama_ptk', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_absensiguru_bulanan($month, $year)
    {
        // Query untuk mengambil data berdasarkan bulan dan tahun dari kolom timestamp
        $this->db->select('ptk.id_guru, ptk.nama_ptk, ptk.nip, absensiguru.absen, absensiguru.timestamp');
        $this->db->from('ptk');
        $this->db->join('absensiguru', 'ptk.id_guru = absensiguru.id_guru AND MONTH(absensiguru.timestamp) = ' . $this->db->escape($month) . ' AND YEAR(absensiguru.timestamp) = ' . $this->db->escape($year), 'left');
        $this->db->order_by('nama_ptk', 'ASC');
    
        $query = $this->db->get();
        return $query->result_array();
    }
    
    

    public function get_list_kelas()
    {
        $this->db->select('id_kelas, nama_kelas');
        $this->db->from('kelas');
        $this->db->order_by('nama_kelas', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_absensionline_by_date_range($start_date, $end_date)
    {
        $this->db->select('siswa.id_siswa, siswa.nama_siswa, siswa.no_absen, kelas.nama_kelas, absensionline.absen, absensionline.timestamp');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas', 'left');
        $this->db->join('absensionline', 'siswa.id_siswa = absensionline.id_siswa AND DATE(absensionline.timestamp) BETWEEN ' . $this->db->escape($start_date) . ' AND ' . $this->db->escape($end_date), 'left');
        $this->db->order_by('nama_kelas', 'ASC');
        $this->db->order_by('no_absen', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }



    public function get_siswa_by_kelas($kode_kelas)
    {

        $this->db->select('siswa.*');
        $this->db->where('siswa.kode_kelas', $kode_kelas);
        $query = $this->db->get('siswa');


        return $query->result_array();
    }




    public function get_siswaactive()
    {
        // Select semua kolom dari tabel siswa dengan status_kelulusan 0
        $this->db->select('siswa.*'); // Sesuaikan kolom yang ingin ditampilkan
        $this->db->from('siswa');
        $this->db->where('status_kelulusan', 0); // Tambahkan kondisi di sini
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_izinsiswa()
    {
        $this->db->select('*');
        $this->db->from('absensionline');
        $this->db->join('siswa', 'absensionline.id_siswa = siswa.id_siswa', 'left');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas', 'left');
        $this->db->where('absensionline.absen', 'Sakit');
        $this->db->or_where('absensionline.absen', 'Izin');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function simpan_izinsiswa($data)
    {
        // Simpan data pelanggaran ke dalam tabel poinpelanggaran
        $this->db->insert($this->_table_absensionline, $data);
        return $this->db->affected_rows() > 0;
    }


    public function cari_siswa($term)
    {
        $this->db->select('id_siswa, nama_siswa, nama_kelas'); // Kolom yang ingin ditampilkan
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kode_kelas = kelas.no_kelas', 'left');
        $this->db->like('nama_siswa', $term); // Mencocokkan kata kunci pencarian dengan nama siswa
        $query = $this->db->get();
        return $query->result_array();
    }




    public function get_nama_kelas($kode_kelas)
    {
        $this->db->select('nama_kelas');
        $this->db->where('no_kelas', $kode_kelas);
        $query = $this->db->get('kelas');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->nama_kelas;
        } else {
            return "Kelas tidak ditemukan";
        }
    }


    public function get_settingabsensi()
    {
        return $this->db->get('templateabsensi')->row_array();
    }

    public function update_settingabsensi($profilsekolah_data)
    {
        $lembagasettingabsensi_id = 1;
        $this->db->where('id', $lembagasettingabsensi_id);
        return $this->db->update('templateabsensi', $profilsekolah_data);
    }





    //fungsi pada siswa

    public function submit_absensi($data)
    {
        $this->db->insert('absensionline', $data);
    }


    public function get_absensi_harian($id_siswa, $tanggal)
    {
        $this->db->select('*');
        $this->db->from('absensionline');
        $this->db->where('id_siswa', $id_siswa);
        $this->db->where('DATE(timestamp)', $tanggal);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_tanggal_absen_terakhir($id_siswa)
    {
        $this->db->select('timestamp');
        $this->db->where('id_siswa', $id_siswa);
        $this->db->order_by('timestamp', 'DESC');
        $query = $this->db->get('absensionline', 1); // Sesuaikan dengan nama tabel yang digunakan
        $result = $query->row_array();

        if ($result) {
            return $result['timestamp'];
        } else {
            return null;
        }
    }
    public function status_absen_masuk()
    {
        // Ambil batas waktu absen masuk dari tabel templateabsensi
        $this->db->select('batas_waktu_absen_masuk');
        $query = $this->db->get('templateabsensi');
        $result = $query->row_array();
        return $result['batas_waktu_absen_masuk'];
    }

    public function status_absen_pulang()
    {
        // Ambil batas waktu absen pulang dari tabel templateabsensi
        $this->db->select('batas_waktu_absen_pulang');
        $query = $this->db->get('templateabsensi');
        $result = $query->row_array();
        return $result['batas_waktu_absen_pulang'];
    }

    public function get_batas_waktu_absen_masuk()
    {
        // Ambil batas waktu absen masuk, latitude, longitude, dan radius absen dari tabel templateabsensi
        $this->db->select('batas_waktu_absen_masuk, latitude, longitude, radius_absen');
        $query = $this->db->get('templateabsensi');
        return $query->row_array();
    }

    public function get_batas_waktu_absen_pulang()
    {
        // Ambil batas waktu absen pulang, latitude, longitude, dan radius absen dari tabel templateabsensi
        $this->db->select('batas_waktu_absen_pulang, latitude, longitude, radius_absen');
        $query = $this->db->get('templateabsensi');
        return $query->row_array();
    }










    public function get_ptk_by_qr_code($qr_code)
    {
        $this->db->where('id_guru', $qr_code);
        $query = $this->db->get('ptk');
        return $query->row();
    }

    public function get_tanggal_absen_terakhir_ptk($id_guru)
    {
        $this->db->select('timestamp');
        $this->db->where('id_guru', $id_guru);
        $this->db->order_by('timestamp', 'DESC');
        $query = $this->db->get('absensiguru', 1); // Sesuaikan dengan nama tabel yang digunakan
        $result = $query->row_array();

        if ($result) {
            return $result['timestamp'];
        } else {
            return null;
        }
    }

    public function submit_absensiptk($data)
    {
        $this->db->insert('absensiguru', $data);
    }
}
