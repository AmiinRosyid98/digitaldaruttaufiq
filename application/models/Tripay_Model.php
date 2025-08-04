<?php
/*defined('BASEPATH') OR exit('No direct script access allowed');

class Tripay_model extends CI_Model {

    public function createTransaction($payload, $apiKey) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT     => true,
            // CURLOPT_URL               => "https://tripay.co.id/api/transaction/create",
            CURLOPT_URL               => "https://tripay.co.id/api-sandbox/transaction/create",
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR       => false,
            CURLOPT_POST              => true,
            CURLOPT_POSTFIELDS        => http_build_query($payload),
            CURLOPT_IPRESOLVE         => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) return ['success' => false, 'message' => $error];
        return json_decode($response, true);
    }
}*/

class Tripay_Model extends CI_Model
{
    private $table = 'transaksi';

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_reference($reference)
    {
        return $this->db->get_where($this->table, ['reference' => $reference])->row_array();
    }

    public function update_status($reference, $status)
    {
        return $this->db->update($this->table, ['status' => $status], ['reference' => $reference]);
    }

    public function all()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function expire_unpaid_before($user_email)
    {
        $this->db->where('status', 'UNPAID');
        $this->db->where('customer_email', $user_email);
        $this->db->where('expired_at >', date('Y-m-d H:i:s'));
        return $this->db->update('transaksi', ['status' => 'EXPIRED']);
    }

    public function get_metode_pembayaran_by_kode($kode)
    {
        // $this->db->order_by('id', 'ASC');
        // $query = $this->db->get('metode_pembayaran');

        $query = $this->db->select("kategori_channel_pembayaran.kategori, metode_pembayaran.*")
                        ->from("metode_pembayaran")
                        ->join("kategori_channel_pembayaran", "metode_pembayaran.id_kategori = kategori_channel_pembayaran.id", "left")
                        ->where('metode_pembayaran.kode', $kode)
                        ->order_by('metode_pembayaran.id', 'ASC')->get();
        return $query->row();
    }

}
