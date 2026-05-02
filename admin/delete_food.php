<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: food_items.php");
    exit();
}

$id = intval($_GET['id']);

// 🔥 FETCH FOOD
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin_food_items WHERE food_id=$id"));

if($data){

    // 🔥 DELETE IMAGE
    if(!empty($data['image']) && file_exists("uploads/".$data['image'])){
        unlink("uploads/".$data['image']);
    }

    // 🔥 DELETE VARIANTS FIRST (IMPORTANT)
    mysqli_query($conn, "DELETE FROM food_variants WHERE food_id=$id");

    // 🔥 DELETE FOOD
    mysqli_query($conn, "DELETE FROM admin_food_items WHERE food_id=$id");
}

// 🔥 REDIRECT
header("Location: food_items.php?msg=deleted");
exit();
?>