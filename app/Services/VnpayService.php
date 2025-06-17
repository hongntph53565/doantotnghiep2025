<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VnpayService
{
    protected $TmnCode;
    protected $HashSecret;
    protected $Enpoint;
    protected $IpAddr;
    public function __construct()
    {
        $this->TmnCode = config('vnpay.vnp_TmnCode');
        $this->HashSecret = config('vnpay.vnp_HashSecret');
        $this->Enpoint = config('vnpay.vnp_Enpoint');
        $this->IpAddr = $_SERVER['REMOTE_ADDR'];
    }
    public function createPaymentLink($amount, $description, $returnUrl)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $expire = date('YmdHis', strtotime('+15 minutes'));

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->TmnCode,
            "vnp_Amount" => $amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $this->IpAddr,
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => "Thanh toan GD:" . time(),
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $returnUrl,
            "vnp_TxnRef" => $description,
            "vnp_ExpireDate" => $expire,
        );

        ksort($inputData);
        $hashdata = http_build_query($inputData, '', '&');
        $vnp_Url = $this->Enpoint . "?" . $hashdata;
        
        if (isset($this->HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->HashSecret);
            $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        }

        $response = array(
            'code' => 200,
            'message' => 'Success',
            'payment_url' => $vnp_Url,
            'txn_ref' => $description
        );
        return json_encode($response);
    }
}
