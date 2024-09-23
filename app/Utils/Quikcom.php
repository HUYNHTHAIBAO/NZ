<?php

namespace App\Utils;

use App\Models\VnpayRefund;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Quikcom
{

//    protected $auth = 'TGZ6RTQwanFtYklxeVpmUU4rdGpaSHl2R0xXNzZwTGhvSEI4QmZQeFplSGZ5REV1UnBUNHZ5bjViZFJPMDlCcw==';
    protected $auth = 'djNlVXRoN3dBK1pDS2NqRm95S0hNTEN6c2tiNkR1SUVlVXh6WXppYUxLOXNvK3JsWWd0WWZhaElXelNTM3pPNg==';
    protected $url_create_room = 'https://conference-api-prod.quickom.com/api/account/qrcode/create';
    protected $url_start_room = 'https://conference-api-prod.quickom.com/api/account/qrcode/host/url';
    public function createRoom($order_id, $expire_at, $start_date, $end_date) {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth,
            'authority' => 'conference-api-prod.quickom.com',
            'accept' => 'application/json, text/plain, */*',
            'accept-language' => 'en-US',

        ];

//        $body = [
//            "label" => $order_id,
//            "classroom" => true,
//            "valid_from" => 0,
//            "valid_to" => 0,
//            "expire_at" => $expire_at,
//            "class_name" => "",
//            "start_date" => $start_date,
//            "end_date" => $end_date,
//            "custom_student_url" => "",
//            "custom_tutor_url" => "",
//            'require_authorized' => true
//        ];

        $body = [
            "classroom"=> true,
            "label" => $order_id,
            "expire_at" => $expire_at,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "require_authorized" => true,
            "passcode"=> "",
            "description"=> "",
            //"event_mode" => event_mode
        ];



        try {
            $res = $client->request('POST', $this->url_create_room, [
                'headers' => $headers,
                'body' => json_encode($body)
            ]);
            $data = json_decode($res->getBody(), true);
            return $data;


        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error("RequestException: " . $e->getMessage());
            return ["error" => "RequestException: " . $e->getMessage()];

        } catch (\Exception $e) {
            Log::error("Exception: " . $e->getMessage());
            return ["error" => "Exception: " . $e->getMessage()];
        }
    }

    public function startroom($alias)
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth
        ];
        try {
            $res = $client->request('GET', $this->url_start_room.'?alias='.$alias, [
                'headers' => $headers,
            ]);
            $data = json_decode($res->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            Log::error("Exception: " . $e->getMessage());
            return ["error" => "Exception: " . $e->getMessage()];
        }
    }

}
