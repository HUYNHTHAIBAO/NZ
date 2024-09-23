<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MailService
{
    protected $client;
    protected $apiUrl = 'https://appv4.zozo.vn/api/v1/email/send';
    protected $token = 'LFZbOhPmPaGPpb03q0iHTf5srr0ELvi1Q1AeM0yhRkXWNIHudAHQBcOfHkx8';
    protected $fromEmail = 'info@neztwork.com'; // Email cứng
    protected $fromName = 'NEZTWORK';           // Tên cứng
        protected $reply_to = 'info@neztwork.com';           // Tên cứng
    public function __construct()
    {
        $this->client = new Client();
    }

    public function sendMail($subject, $html, $plain , $to, $attachLinks, $params)
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'api_token' => $this->token,
                    'subject' => $subject,
                    'html' => $html,
                    'plain' => $plain,
                    'from_email' => $this->fromEmail,  // Sử dụng email cứng
                    'from_name' => $this->fromName,    // Sử dụng tên cứng
                    'reply_to' => $this->reply_to,
                    'to' => $to,
                    'params' => array_merge($params, ['attachments' => $attachLinks]),
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
            // Kiểm tra mã trạng thái và phản hồi
            return [
                'status' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents()
            ];
        } catch (RequestException $e) {
            // Xử lý lỗi từ Guzzle
            return [
                'status' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500,
                'body' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage()
            ];
        }
    }
}
