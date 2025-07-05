<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZalopayService
{
    protected $appID;
    protected $key1;
    protected $key2;
    protected $enpoint;
    public function __construct()
    {
        $this->appID = config('zalopay.app_id');
        $this->key1 = config('zalopay.key1');
        $this->key2 = config('zalopay.key2');
        $this->enpoint = config('zalopay.endpoint');
    }
    public function createPaymentLink($amount, $description,$returnUrl)
    {
        $embeddata = json_encode(array(
            'redirecturl' => $returnUrl,
        ));
        $items = '[]';
        $transID = rand(0, 1000000);

        $order = [
            "app_id" => $this->appID,
            "app_time" => round(microtime(true) * 1000),
            "app_trans_id" => date("ymd") . "_" . $transID,
            "app_user" => "user123",
            "item" => $items,
            "embed_data" => $embeddata,
            "amount" => $amount,
            "description" => $description,
            "bank_code" => ""
        ];

        $value = $order["app_id"] . "|" . $order["app_trans_id"] . "|" . $order["app_user"] . "|" . $order["amount"]
            . "|" . $order["app_time"] . "|" . $order["embed_data"] . "|" . $order["item"];
        $order["mac"] = hash_hmac("sha256", $value, $this->key1);

        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($order)
            ]
        ]);

        $response = file_get_contents($this->enpoint, false, $context);
        return $response;
    }
}
