<?php

namespace App\Utils;

use App\Models\VnpayRefund;
use GuzzleHttp\Client;

class Payment
{
    public static function Refund($params)
    {

        $vnp_TmnCode = "NEZTWORK"; //Ma website
        $vnp_HashSecret = "IU4WWY9O7N2X94ZO2U8SOAMU7HP2VIGH"; //Chuoi bi mat


        $creat_signature = [
            'vnp_RequestId' => $params['id'],
            'vnp_Version' => '2.1.0',
            'vnp_Command' => 'refund',
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_TransactionType' => '02',
            'vnp_TxnRef' => $params['request_expert_id'],
            'vnp_Amount' => $params['vnp_Amount'],
            'vnp_TransactionNo' => $params['vnp_TransactionNo'],
            'vnp_TransactionDate' => date('YmdHis'),
            'vnp_CreateBy' => $params['user_name'],
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_IpAddr' => $_SERVER['REMOTE_ADDR'],
            'vnp_OrderInfo' => 'Hoan tien don hang ' . $params['request_expert_id'],
        ];
        $checksum = self::createChecksum($vnp_HashSecret, $creat_signature);


        try {
            $client = new Client();

            $headers = [
                'Content-Type' => 'Application/json',

            ];

            $body = [
                'vnp_RequestId' => $params['id'],
                'vnp_Version' => '2.1.0',
                'vnp_Command' => 'refund',
                'vnp_TmnCode' => $vnp_TmnCode,
                'vnp_TransactionType' => '02',
                'vnp_TxnRef' => $params['request_expert_id'],
                'vnp_Amount' => $params['vnp_Amount'],
                'vnp_TransactionNo' => $params['vnp_TransactionNo'],
                'vnp_TransactionDate' => date('YmdHis'),
                'vnp_CreateBy' => $params['user_name'],
                'vnp_CreateDate' => date('YmdHis'),
                'vnp_IpAddr' => $_SERVER['REMOTE_ADDR'],
                'vnp_OrderInfo' => 'Hoan tien don hang ' . $params['request_expert_id'],
                'vnp_SecureHash' => $checksum
            ];

            $response = $client->post('https://sandbox.vnpayment.vn/merchant_webapi/api/transaction', [
                'headers' => $headers,
                'json' => $body
            ]);
            $data = json_decode($response->getBody(), true);
            if ($data['vnp_ResponseCode'] == '00') {
                $refund = VnpayRefund::find($params['id']);
                $refund->status = 1;
                $refund->vnp_ResponseCode = json_encode($data);
                $refund->body_content = json_encode($body);
                $refund->save();
            } else {
                $refund = VnpayRefund::find($params['id']);
                $refund->status = 2;
                $refund->vnp_ResponseCode = json_encode($data);
                $refund->body_content = json_encode($body);
                $refund->save();
            }
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return null;
    }

    public static function createChecksum($secretKey, $data)
    {
        // Tạo chuỗi dữ liệu từ các tham số
        $dataString = implode('|', $data);
        //return $dataString;
        // Băm chuỗi dữ liệu với thuật toán sha256 và khóa bí mật
        return hash_hmac('sha512', $dataString, $secretKey);
    }
}
