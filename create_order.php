<?php
session_start();

header('Content-Type: application/json'); // ✅ IMPORTANT

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("db.php");
include("razorpay_config.php");

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){
    echo json_encode(["error"=>"login required"]);
    exit;
}

// GET CART
$cart = mysqli_query($conn,"SELECT * FROM cart WHERE user_id='$user_id'");

if(!$cart){
    echo json_encode(["error"=>"DB error"]);
    exit;
}

$total = 0;

while($c = mysqli_fetch_assoc($cart)){
    $total += $c['price'] * $c['quantity'];
}

// GST
$gst = round($total * 0.18, 2);
$grand_total = $total + $gst;

try {

    // CREATE ORDER
    $order = $api->order->create([
        'receipt' => 'order_'.time(),
        'amount'  => $grand_total * 100,
        'currency'=> 'INR'
    ]);

    echo json_encode([
        "success" => true,
        "id" => $order['id'],
        "amount" => $order['amount']
    ]);

} catch(Exception $e){

    echo json_encode([
        "error" => $e->getMessage()
    ]);
}