<?php
include("db.php");

$query = "SELECT COUNT(*) as total FROM admin_notifications WHERE status='unread'";
$result = mysqli_fetch_assoc(mysqli_query($conn, $query));

echo $result['total'];
?>