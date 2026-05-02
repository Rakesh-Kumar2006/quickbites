<?php
include("db.php");

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM admin_restaurants WHERE hotel_id=$id");

header("Location: add_hotel.php");
?>