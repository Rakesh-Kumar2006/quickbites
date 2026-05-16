<?php
session_start();
include("db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){
    die("Login required");
}

// ✅ SAFE INPUTS
$address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
$payment = mysqli_real_escape_string($conn, $_POST['payment'] ?? 'COD');

// ✅ PAYMENT STATUS
$payment_status = ($payment == 'ONLINE') ? 'paid' : 'pending';

// ✅ FETCH CART
$cart = mysqli_query($conn,"
SELECT 
    c.*, 
    f.name,
    f.hotel_id
FROM cart c
JOIN admin_food_items f 
ON f.food_id = c.food_id
WHERE c.user_id='$user_id'
");

if(mysqli_num_rows($cart) == 0){
    die("Cart is empty");
}

$total = 0;
$hotel_id = 0;

// ✅ CALCULATE TOTAL
while($c = mysqli_fetch_assoc($cart)){

    $total += $c['price'] * $c['quantity'];

    // GET HOTEL ID
    $hotel_id = $c['hotel_id'];
}

$gst = round($total * 0.18, 2);
$grand_total = $total + $gst;

// ✅ INSERT ORDER
mysqli_query($conn,"
INSERT INTO orders(
    user_id,
    hotel_id,
    total_amount,
    gst,
    grand_total,
    address,
    payment_method,
    payment_status,
    order_status,
    created_at
)
VALUES(
    '$user_id',
    '$hotel_id',
    '$total',
    '$gst',
    '$grand_total',
    '$address',
    '$payment',
    '$payment_status',
    'pending',
    NOW()
)
");

// ✅ ORDER ID
$order_id = mysqli_insert_id($conn);

// 🔁 FETCH CART AGAIN
$cart = mysqli_query($conn,"
SELECT 
    c.*, 
    f.name
FROM cart c
JOIN admin_food_items f 
ON f.food_id = c.food_id
WHERE c.user_id='$user_id'
");

// ✅ INSERT ORDER ITEMS
while($c = mysqli_fetch_assoc($cart)){

    mysqli_query($conn,"
    INSERT INTO order_items(
        order_id,
        food_id,
        name,
        price,
        quantity,
        variant
    )
    VALUES(
        '$order_id',
        '".$c['food_id']."',
        '".$c['name']."',
        '".$c['price']."',
        '".$c['quantity']."',
        '".$c['variant']."'
    )
    ");
}

// ✅ CLEAR CART
mysqli_query($conn,"
DELETE FROM cart 
WHERE user_id='$user_id'
");

// 🔔 ADMIN NOTIFICATION
$message = "🛒 New Order #$order_id received";

mysqli_query($conn,"
INSERT INTO admin_notifications(
    order_id,
    admin_id,
    message,
    status
)
VALUES(
    '$order_id',
    '1',
    '$message',
    'unread'
)
");

// ✅ SUCCESS REDIRECT
header("Location: success.php?order_id=".$order_id);
exit;
?>