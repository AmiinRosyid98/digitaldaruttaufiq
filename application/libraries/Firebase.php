<?php
// application/libraries/Firebase.php

use GuzzleHttp\Client;

class Firebase
{

    protected $apiKey;
    protected $apiUrl = 'https://fcm.googleapis.com/fcm/send';

    public function __construct()
    {
        $this->apiKey = 'YOUR_FIREBASE_SERVER_KEY'; // Ganti dengan server key Firebase Anda
    }

    public function sendNotification($token, $message)
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'key=' . $this->apiKey,
                'Content-Type' => 'application/json'
            ]
        ]);

        $body = [
            'to' => $token,
            'notification' => $message
        ];

        $response = $client->post($this->apiUrl, [
            'json' => $body
        ]);

        return $response->getBody()->getContents();
    }
}
