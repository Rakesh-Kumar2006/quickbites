<?php
include("razorpay_config.php");

$data = json_decode(file_get_contents("php://input"), true);

$attributes = [
    'razorpay_order_id' => $data['razorpay_order_id'],
    'razorpay_payment_id' => $data['razorpay_payment_id'],
    'razorpay_signature' => $data['razorpay_signature']
];

try {
    $api->utility->verifyPaymentSignature($attributes);
    echo "success";
} catch(Exception $e){
    http_response_code(400);
    echo "failed";
}