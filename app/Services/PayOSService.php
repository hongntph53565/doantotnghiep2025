<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayOSService
{
    protected $clientId;
    protected $apiKey;
    protected $checksumKey;
    protected $baseUrl;
    
    public function __construct()
    {
        $this->clientId = config('payos.client_id');
        $this->apiKey = config('payos.api_key');
        $this->checksumKey = config('payos.checksum_key');
        $this->baseUrl = config('payos.base_url');
    }

    public function createPaymentLink($amount, $description, $returnUrl)
    {
        $data = [
            'amount' => $amount,
            'cancelUrl' => route('payos.return',['description' => $description]),
            'description' => $description,
            'orderCode' => time(),
            'returnUrl' => $returnUrl,
        ];

        ksort($data);

        $hashData = '';
        foreach ($data as $key => $value) {
            if ($hashData !== '') {
                $hashData .= '&';
            }
            $hashData .= $key . '=' . $value;
        }

        $signature = hash_hmac('sha256', $hashData, $this->checksumKey);
        $data['signature'] = $signature;

        $response = Http::withHeaders([
            'x-client-id' => $this->clientId,
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/v2/payment-requests', $data);

        return $response->json();
    }
}
