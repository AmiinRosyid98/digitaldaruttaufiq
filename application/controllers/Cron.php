<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function update_expired_status()
    {
        // Cek data yang expired
        $this->db->where('expired_at <', date('Y-m-d H:i:s'));
        $this->db->where('status =', 'UNPAID');
        $expiredData = $this->db->get('transaksi')->result();

        $totalUpdated = 0;

        if (!empty($expiredData)) {
            // Update semua jadi EXPIRED
            $this->db->where('expired_at <', date('Y-m-d H:i:s'));
            $this->db->where('status =', 'UNPAID');
            $this->db->update('transaksi', ['status' => 'EXPIRED']);

            $totalUpdated = $this->db->affected_rows();
        }

        // Simpan log ke tabel cron_log
        $this->db->insert('cron_log', [
            'job_name'      => 'update_expired_status',
            'total_updated' => $totalUpdated,
            'executed_at'   => date('Y-m-d H:i:s')
        ]);

        echo "Cron dijalankan: {$totalUpdated} data diupdate menjadi EXPIRED\n";
    }
}
