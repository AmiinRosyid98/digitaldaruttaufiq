<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function tripay_api_key() {
    $CI =& get_instance();
    $CI->load->model('admin');
    $get = $CI->admin->get_profilsekolah_data();
    $string = '';
    if($get){
        if($get['tripay_api_key']!= ""){
            $string = $get['tripay_api_key'];

        } else {    
            $string = 'https://tripay.co.id/api-sandbox/';
        }
    }
    return $string;
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

function tripay_link() {
    $CI =& get_instance();
    $CI->load->model('admin');
    $get = $CI->admin->get_profilsekolah_data();

    $string = '';
    if($get){
        if($get['tripay_link']!= ""){
            $string = $get['tripay_link'];

        } else {    
            $string = 'https://tripay.co.id/api-sandbox/';
        }
    }
    return $string;
}

function tripay_private_key() {

    $CI =& get_instance();
    $CI->load->model('admin');
    $get = $CI->admin->get_profilsekolah_data();

    $string = ''; 
    if($get){
        if($get['tripay_private_key']!= ""){
            $string = $get['tripay_private_key'];

        } else {    
            $string = '8TJSt-Ec102-9UHnQ-L9ip5-2Nbrg';
        }
    }
    return $string;
}

function tripay_merchant_code() {
    $CI =& get_instance();
    $CI->load->model('admin');
    $get = $CI->admin->get_profilsekolah_data();

    $string = '';
    if($get){
        if($get['tripay_merchant_id']!= ""){
            $string = $get['tripay_merchant_id'];

        } else {    
            $string = 'T7222';
        }
    }
    return $string;
}

function tripay_signature($merchant_ref, $amount) {
    return hash_hmac('sha256', tripay_merchant_code() . $merchant_ref . $amount, tripay_private_key());
}

function tripay_post($url, $data = [])
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . tripay_api_key()],
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($data)
    ]);

    $response = curl_exec($curl);
    $error    = curl_error($curl);
    curl_close($curl);

    return $error ? ['success' => false, 'error' => $error] : json_decode($response, true);
}

function tripay_get($url)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . tripay_api_key()],
    ]);

    $response = curl_exec($curl);
    $error    = curl_error($curl);
    curl_close($curl);

    return $error ? ['success' => false, 'error' => $error] : json_decode($response, true);
}
