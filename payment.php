<?php



$apiKey = '1f630c910bd11438da5320ce708da63c71e5f80a4113b58398';



$url = 'https://payment.nexuscloudsoft.com/api/checkout/redirect';



$data = [

    'full_name' => 'Test Customer',

    'email_address' => 'test@example.com',

    'mobile_number' => '01700000000',

    'amount' => '100',

    'currency' => 'BDT',



    'metadata' => json_encode([

        'invoice_id' => 'TEST-001',

    ]),



    'return_url' => 'https://nexuscloudsoft.com/payment-success',



    'webhook_url' => 'https://nexuscloudsoft.com/payment-webhook',

];



$ch = curl_init($url);



curl_setopt_array($ch, [

    CURLOPT_POST => true,

    CURLOPT_RETURNTRANSFER => true,



    CURLOPT_HTTPHEADER => [

        'MHS-PIPRAPAY-API-KEY: ' . $apiKey,

        'Content-Type: application/json',

        'Accept: application/json',

    ],



    CURLOPT_POSTFIELDS => json_encode($data),



    CURLOPT_TIMEOUT => 30,

]);



$response = curl_exec($ch);



$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$curlError = curl_error($ch);



curl_close($ch);



if ($response === false) {

    die('cURL Error: ' . $curlError);

}



$result = json_decode($response, true);



echo '<pre>';

echo "HTTP CODE: " . $httpCode . "\n\n";

echo "RAW RESPONSE:\n";

echo htmlspecialchars($response);

echo "\n\nDECODED RESPONSE:\n";

print_r($result);

echo '</pre>';



if (!empty($result['pp_url'])) {

    header('Location: ' . $result['pp_url']);

    exit;

}