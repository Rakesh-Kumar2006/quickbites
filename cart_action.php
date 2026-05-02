<?php
session_start();
include("db.php");

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){
    echo "Login required";
    exit();
}

// REMOVE ITEM
if(isset($_POST['remove'])){
    $id = $_POST['remove'];
    mysqli_query($conn,"DELETE FROM cart WHERE cart_id='$id'");
    include("cart_fetch.php");
    exit();
}

// UPDATE QTY
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $change = $_POST['change'];

    mysqli_query($conn,"
    UPDATE cart 
    SET quantity = GREATEST(quantity + $change,1)
    WHERE cart_id='$id'
    ");

    include("cart_fetch.php");
    exit();
}

// ADD ITEM (existing logic)
$food_id = $_POST['food_id'] ?? 0;
$qty     = $_POST['qty'] ?? 1;
$variant = $_POST['variant'] ?? '';

if($food_id == 0){
    echo "Invalid food";
    exit();
}

// PRICE
if($variant){
    preg_match('/₹(\d+)/', $variant, $m);
    $price = $m[1] ?? 0;
}else{
    $f = mysqli_fetch_assoc(mysqli_query($conn,"SELECT price FROM admin_food_items WHERE food_id='$food_id'"));
    $price = $f['price'];
}

// CHECK
$check = mysqli_query($conn,"
SELECT * FROM cart WHERE user_id='$user_id' AND food_id='$food_id' AND variant='$variant'
");

if(mysqli_num_rows($check)){
    mysqli_query($conn,"
    UPDATE cart SET quantity=quantity+$qty
    WHERE user_id='$user_id' AND food_id='$food_id' AND variant='$variant'
    ");
}else{
    mysqli_query($conn,"
    INSERT INTO cart(user_id,food_id,quantity,price,variant)
    VALUES('$user_id','$food_id','$qty','$price','$variant')
    ");
}

include("cart_fetch.php");