<?php
return [
    'client_id' => env('PAYOS_CLIENT_ID'),
    'api_key' => env('PAYOS_API_KEY'),
    'checksum_key' => env('PAYOS_CHECKSUM_KEY'),
    'base_url' => env('PAYOS_BASE_URL', 'https://api.payos.vn'),
];
