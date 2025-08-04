<?php

/*defined('BASEPATH') OR exit('No direct script access allowed');

class Tripay extends CI_Controller {

    private $apiKey = 'DEV-JFgjJz5prcYoGm5mqk9B4sRgBUD0sqlCFBgNKxeM';
    private $privateKey = '8TJSt-Ec102-9UHnQ-L9ip5-2Nbrg';
    private $merchantCode = 'T7222';

    public function __construct() {
        parent::__construct();
        $this->load->model('Tripay_Model');
    }

    public function index() {
        $this->load->view('tripay_checkout');
    }

    public function create_transaction() {
        
        // adas asdasdas
        $method = $this->input->post('method');
        $amount = $this->input->post('amount');
        $customer_name = $this->input->post('customer_name');
        $customer_email = $this->input->post('customer_email');

        $merchantRef = 'INV-' . time();
        $expiredTime = time() + (5 * 60); // 5 menit dalam detik

        $payload = [
            'method'         => $method,
            'merchant_ref'   => $merchantRef,
            'amount'         => (int)$amount,
            'customer_name'  => $customer_name,
            'customer_email' => $customer_email,
            'order_items'    => [
                [
                    'sku' => 'product-001',
                    'name' => 'Produk Contoh',
                    'price' => (int)$amount,
                    'quantity' => 1
                ]
            ],
            'callback_url'   => base_url('tripay/callback'),
            'return_url'     => base_url('tripay/thanks'),
            'expired_time'   => $expiredTime, // 24 jam
            'signature'      => hash_hmac('sha256', $this->merchantCode . $merchantRef . $amount, $this->privateKey)
        ];

        echo "<pre>";
        var_dump($payload);

        $result = $this->Tripay_Model->createTransaction($payload, $this->apiKey);

        // asdasd

        echo json_encode($result);
    }

    public function callback() {
        // kamu bisa isi logic verifikasi callback dari Tripay di sini
    }

    public function thanks() {
        echo "Terima kasih! Silakan cek email kamu untuk detail pembayaran.";
    }
}*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Tripay extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('tripay');
        $this->load->model('Tripay_Model');
        $this->load->model('Poskeuangan_Model');
        $this->load->model('Pesertadidik');
        $this->load->model('Pembayaransiswa_Model');
    }

    public function create()
    {
        $merchant_ref = 'INV-' . time();
        $amount = 10000;
        $method = $this->input->post('method'); // Misal: BCA, QRIS, DLL

        $data = [
            'method'         => $method,
            'merchant_ref'   => $merchant_ref,
            'amount'         => $amount,
            'customer_name'  => 'Nama Kamu',
            'customer_email' => 'email@contoh.com',
            'customer_phone' => '081234567890',
            'order_items'    => [
                [
                    'sku'      => 'PRODUK1',
                    'name'     => 'Produk A',
                    'price'    => $amount,
                    'quantity' => 1
                ]
            ],
            'callback_url'   => base_url('tripay/callback'),
            'return_url'     => base_url('tripay/selesai'),
            'expired_time'   => time() + (60 * 5),
            'signature'      => tripay_signature($merchant_ref, $amount)
        ];

        $result = tripay_post(tripay_link()."/transaction/create", $data);

        if (isset($result['success']) && $result['success'] == true) {
            $trx = $result['data'];
            $this->Tripay_Model->insert([
                'merchant_ref' => $trx['merchant_ref'],
                'reference'    => $trx['reference'],
                'method'       => $trx['payment_method'],
                'amount'       => $trx['amount'],
                'status'       => $trx['status'],
                'expired_at'   => date('Y-m-d H:i:s', strtotime($trx['expired_time']))
            ]);
            redirect($trx['checkout_url']); // atau tampilkan info pembayaran
        } else {
            echo 'Gagal membuat transaksi: ' . ($result['message'] ?? 'Unknown error');
        }
    }

    function formatTanggalIndo($datetime) {
        // Ubah ke timestamp
        $timestamp = strtotime($datetime);
        
        // Array nama bulan dalam Bahasa Indonesia
        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        $tgl = date('d', $timestamp);
        $bln = (int)date('m', $timestamp); // jadi integer untuk ambil dari array
        $thn = date('Y', $timestamp);
        $jam = date('H:i', $timestamp);

        return "$tgl {$bulanIndo[$bln]} $thn, Pukul $jam WIB";
    }

    public function create_ajax()
    {
        $this->load->helper('tripay');
        $this->load->model('Tripay_Model');

        $method                 = $this->input->post('method');

        $id_siswa               = $this->input->post('id_siswa');
        $id_kelas               = $this->input->post('id_kelas');
        $nama_tipepembayaran    = $this->input->post('nama_tipepembayaran');
        $id_pos                 = $this->input->post('id_pos');
        $id_pembayaran          = $this->input->post('id_pembayaran');
        $id_tahunpelajaran      = $this->input->post('id_tahunpelajaran');
        $jumlah_tarif           = $this->input->post('jumlah_tarif');
        $jumlah_pembayaran      = $this->input->post('jumlah_pembayaran');

        $expired_time = $this->get_expired_time_by_method($method);
        $expired_time_db = date("Y-m-d H:i:s", $expired_time);


        $merchant_ref = 'INV-' . time();
        // $amount = $jumlah_tarif;
        $pos = $this->Poskeuangan_Model->get_tarifpembayaran_by_id($id_pembayaran);
        $amount = $pos->jumlah_tarif;
        // var_dump($this->cekbiayaadmin($method, $amount));die;
        $biayaadmin = json_decode($this->cekbiayaadmin($method, $amount))->biayaadmin;

        $siswa = $this->Pesertadidik->get_datasiswa($id_siswa);

        $amount = $amount + $biayaadmin;

        $customer_email = 'daruttaufiq@email.com'; // ini bisa kamu ambil dari session/login nanti

        // Step 1: expire transaksi lama yang belum dibayar
        $this->Tripay_Model->expire_unpaid_before($customer_email);

        // Step 2: buat transaksi baru
        $data = [
            'method'         => $method,
            'merchant_ref'   => $merchant_ref,
            'amount'         => $amount,
            'customer_name'  => $siswa['nama_siswa'],
            'customer_email' => $customer_email,
            'customer_phone' => $siswa['nohp'],
            'order_items'    => [
                [
                    'sku'      => $merchant_ref,
                    'name'     => $pos->nama_pos,
                    'price'    => $amount,
                    'quantity' => 1
                ]
            ],
            'callback_url'   => base_url('tripay/callback'),
            'return_url'     => base_url('tripay/selesai'),
            'expired_time'   => $expired_time,
            'signature'      => tripay_signature($merchant_ref, $amount)
        ];

        $response = tripay_post(tripay_link()."/transaction/create", $data);

        if (isset($response['success']) && $response['success']) {
            $trx = $response['data'];
            $trx['expired_time_db'] = $this->formatTanggalIndo($expired_time_db);

            $barcodeUrl = null;
            foreach ($response['data']['instructions'] as $instruksi) {
                if (isset($instruksi['image_url'])) {
                    $barcodeUrl = $instruksi['image_url'];
                    break;
                }
            }

            $this->Tripay_Model->insert([
                'merchant_ref'    => $trx['merchant_ref'],
                'reference'       => $trx['reference'],
                'method'          => $trx['payment_method'],
                'amount'          => $trx['amount'],
                'amount_awal'     => $jumlah_tarif ,
                'biayaadmin'      => $biayaadmin ,
                'status'          => $trx['status'],
                // 'expired_at'      => date('Y-m-d H:i:s', strtotime($trx['expired_time'])),
                'expired_at'      => $expired_time_db,
                'created_at'      => date("Y-m-d H:i:s"),
                'customer_email'  => $customer_email,
                'pay_code'      => isset($trx['pay_code']) ? $trx['pay_code'] : null,
                'qr_url'        => ($trx['payment_method'] === 'OVO' || $trx['payment_method'] === 'DANA' || $trx['payment_method'] === 'SHOPEEPAY') 
                                    ? $trx['checkout_url'] 
                                    : (isset($trx['qr_url']) ? $trx['qr_url'] : null),
                'barcode_url' => $barcodeUrl,

                'id_siswa'            => $id_siswa,
                'id_kelas'            => $id_kelas,
                'nama_tipepembayaran' => $nama_tipepembayaran,
                'id_pos'              => $id_pos,
                'id_pembayaran'       => $id_pembayaran,
                'id_tahunpelajaran'   => $id_tahunpelajaran,
                'jumlah_tarif'        => $jumlah_tarif,
                'jumlah_pembayaran'   => $jumlah_pembayaran,
            ]);
            echo json_encode(['success' => true, 'data' => $trx]);
        } else {
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Error tidak diketahui']);
        }
    }


    public function create_ajax_bak()
    {
        $this->load->helper('tripay');
        $this->load->model('Tripay_Model');

        $method = $this->input->post('method');
        $merchant_ref = 'INV-' . time();
        $amount = 10000;

        $data = [
            'method'         => $method,
            'merchant_ref'   => $merchant_ref,
            'amount'         => $amount,
            'customer_name'  => 'Contoh User',
            'customer_email' => 'user@email.com',
            'customer_phone' => '081234567890',
            'order_items'    => [
                [
                    'sku'      => 'SKU1',
                    'name'     => 'Produk ABC',
                    'price'    => $amount,
                    'quantity' => 1
                ]
            ],
            'callback_url'   => base_url('tripay/callback'),
            'return_url'     => base_url('tripay/selesai'),
            'expired_time'   => time() + (60 * 5),
            'signature'      => tripay_signature($merchant_ref, $amount)
        ];

        $response = tripay_post(tripay_link()."/transaction/create", $data);

        if (isset($response['success']) && $response['success']) {
            $trx = $response['data'];
            $this->Tripay_Model->insert([
                'merchant_ref' => $trx['merchant_ref'],
                'reference'    => $trx['reference'],
                'method'       => $trx['payment_method'],
                'amount'       => $trx['amount'],
                'status'       => $trx['status'],
                'expired_at'   => date('Y-m-d H:i:s', strtotime($trx['expired_time']))
            ]);
            echo json_encode(['success' => true, 'data' => $trx]);
        } else {
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Error tidak diketahui']);
        }
    }


    /*public function callback()
    {
        $json = file_get_contents('php://input');
        $callback = json_decode($json, true);

        if ($callback && isset($callback['reference'])) {
            $this->Tripay_Model->update_status($callback['reference'], $callback['status']);
        }
    }*/

    public function cekpembayaran(){
        $ID = $_POST['ID'];

        $db = $this->db->select('*')
                        ->from("transaksi")
                        ->where("reference", $ID)
                        ->limit(1)
                        ->get()->row();
        if($db->status == "PAID"){
            echo json_encode(array(
                "status" => "success"
            ));die;
        } else {
            echo json_encode(array(
                "status" => "tidak"
            ));die;
        }

    }

    public function cekbiayaadmin($param = null, $total = null){
        if(!$param){
            $method = $_POST['method'];
        }else{
            $method = $param;
        }
        $biayaadmin = 0;
        $status = "success";

        
        $data = $this->Tripay_Model->get_metode_pembayaran_by_kode($method);

        if($data){
            $biayaadmin = $data->biayaadmin;
        } else{
            $status = "error";
        }

        if(!$total){
            $totalnya = $_POST['total'];
        }else{
            $totalnya = $total;
        }

        $jumlahtotal = 0;

        if (strpos($biayaadmin, '%') !== false){

            $str = str_replace(" ", "", $biayaadmin);
            $str2 = str_replace(",", ".", $str);

            if (strpos($str2, '+') !== false){
                $exp = explode("+", $str2);
                $biaya = ((float)rtrim($exp[0], '%')/100)*$totalnya;

                $jumlahtotal = (int)$totalnya+ ceil($biaya);

                $jumlahtotal = $jumlahtotal + (int)$exp[1];

                $biayaadmin = ceil($biaya) + (int)$exp[1];

            }else{
                

                $biaya = ((float)$biayaadmin/100)*$totalnya;

                $jumlahtotal = (int)$totalnya+(int)$biaya;

                $biayaadmin = $biaya;

            }
        }else{
            $jumlahtotal = (int)$totalnya + (int)$biayaadmin;
            
        }
        
        if(!$param){
            echo json_encode(array(
                "status" => $status,
                //sadasda
                "biayaadmin" => $biayaadmin,
                "jumlahtotal" => $jumlahtotal,
                "biayaadmin_format" => number_format($biayaadmin, 0, ',', '.'),
                // sdsdfsd
            ));
            die;
        } else{
            return json_encode(array(
                "status" => $status,
                //sadasda
                "biayaadmin" => $biayaadmin,
                "jumlahtotal" => $jumlahtotal,
                "biayaadmin_format" => number_format($biayaadmin, 0, ',', '.'),
                // sdsdfsd
            ));
        }
    }

    public function callback() {
        // Ambil input JSON
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Validasi callback signature
        $callbackSignature = $_SERVER['HTTP_X_CALLBACK_SIGNATURE'];
        $privateKey = tripay_private_key(); // dari dashboard Tripay
        $validSignature = hash_hmac('sha256', $json, $privateKey);

        if ($callbackSignature !== $validSignature) {
            show_error('Invalid signature', 403);
        }

        // Validasi event
        if ($_SERVER['HTTP_X_CALLBACK_EVENT'] !== 'payment_status') {
            show_error('Invalid callback event', 403);
        }

        // Ambil data pembayaran
        $reference = $data['reference'];
        $status = $data['status'];

        $reference = $data['reference'];
        $merchant_ref = $data['merchant_ref'];
        $payment_method = $data['payment_method'];
        $payment_method_code = $data['payment_method_code'];
        $total_amount = $data['total_amount'];
        $amount_received = $data['amount_received'];
        $status = $data['status'];
        $paid_at = $data['paid_at'];
        $note = $data['note'];

        // Lakukan update ke database
        if ($status == 'PAID') {
            // contoh update status transaksi
            $this->db->where('reference', $reference);
            $this->db->update('transaksi', ['statuspembayaran' => 1, 'status' => $status, 'tanggal_pembayaran' => date("Y-m-d H:i:s")  ]); // 1 = lunas

            $getdata = $this->db->select("*")
                                ->from("transaksi")
                                ->where('reference', $reference)
                                ->get()->row();
            if($getdata){
                $id_siswa                   = $getdata->id_siswa;
                $nama_tipepembayaran        = $getdata->nama_tipepembayaran;
                $id_pos                     = $getdata->id_pos;
                $id_pembayaran              = $getdata->id_pembayaran;
                $id_tahunpelajaran          = $getdata->id_tahunpelajaran;
                $id_kelas                   = $getdata->id_kelas;
                $statuspembayaran           = $getdata->statuspembayaran;
                $jumlah_tarif               = $getdata->jumlah_tarif;
                $jumlah_pembayaran          = $getdata->jumlah_pembayaran;
                $tanggal_pembayaran         = $getdata->tanggal_pembayaran;
                $method                     = $getdata->method;
                $reference                  = $getdata->reference;
                $invoice                    = $getdata->merchant_ref;
                $pay_code                    = $getdata->pay_code;

                // Menghapus format rupiah dari jumlah_pembayaran
                $jumlah_pembayaran_clean = preg_replace('/\D/', '', $jumlah_pembayaran);


                $data = array(
                    'id_siswa'              => $id_siswa,
                    'nama_tipepembayaran'   => $nama_tipepembayaran,
                    'id_pos'                => $id_pos,
                    'id_pembayaran'         => $id_pembayaran,
                    'id_tahunpelajaran'     => $id_tahunpelajaran,
                    'id_kelas'              => $id_kelas,
                    'statuspembayaran'      => $statuspembayaran,
                    'jumlah_tarif'          => $jumlah_tarif,
                    'jumlah_pembayaran'     => $jumlah_pembayaran_clean,
                    'tanggal_pembayaran'    => $tanggal_pembayaran,
                    'created_at'            => date('Y-m-d H:i:s'),
                    'tempat_pembayaran'     => "online",
                    'metode_pembayaran'     => $method,
                    'reference'             => $reference,
                    'invoice'               => $invoice,
                    'amount'                => $total_amount,
                    'pay_code'              => $pay_code,
                );
                
                $this->Pembayaransiswa_Model->simpan_pembayaran($data);
            }

        } elseif ($status == 'EXPIRED' || $status == 'FAILED') {
            $this->db->where('reference', $reference);
            $this->db->update('transaksi', ['statuspembayaran' => 0, 'status' => $status ]); // 0 = gagal/belum bayar
        }

        echo json_encode(['success' => true]);
    }

    public function get_instruksi_ajax()
    {
        $reference = $this->input->post('reference');
        $apiKey = tripay_api_key(); // Ganti dengan API key Tripay kamu

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => tripay_link().'/transaction/detail?reference=' . $reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        echo $response;
    }

    function get_expired_time_by_method($method_code)
    {
        $now = time();

        // Ubah ke uppercase agar match dengan key mapping
        $method_code = strtoupper($method_code);

        // Map durasi expired dalam detik
        $expire_map = [
            // Bank VA - 24 jam
            'BCAVA'        => 60 * 60 * 24,
            'BNIVA'        => 60 * 60 * 24,
            'BRIVA'        => 60 * 60 * 24,
            'MANDIRIVA'    => 60 * 60 * 24,
            'PERMATAVA'    => 60 * 60 * 24,
            'MUAMALATVA'   => 60 * 60 * 2,
            'DANAMONVA'    => 60 * 60 * 24,
            'CIMBVA'       => 60 * 60 * 24,
            'OCBCVA'       => 60 * 60 * 24,
            'BSIVA'        => 60 * 60 * 2,
            'SAMPOERNAVA'  => 60 * 60 * 24,

            // Retail - 24 jam
            'ALFAMART'     => 60 * 60 * 24,
            'INDOMARET'    => 60 * 60 * 24,
            'ALFAMIDI'     => 60 * 60 * 24,

            // QRIS - 15 menit
            'QRIS'         => 60 * 60,

            // Ewallets
            'OVO'          => 60 * 60,
            'DANA'         => 60 * 60,
            'LINKAJA'      => 60 * 60,
            'SHOPEEPAY'    => 60 * 60,
            // hiihihihihi
        ];

        // Gunakan default 24 jam jika tidak ditemukan
        $expire_seconds = $expire_map[$method_code] ?? (60 * 60 * 24);


        // Return sebagai UNIX timestamp
        // var_dump($now + $expire_seconds);die;
        return $now + $expire_seconds;
    }



}
