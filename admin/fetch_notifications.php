<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("db.php");

header('Content-Type: application/json');

// ✅ prevent accidental output
ob_clean();

$data = [];

$query = "SELECT * FROM admin_notifications ORDER BY notification_id DESC LIMIT 5";
$result = mysqli_query($conn, $query);

if(!$result){
    echo json_encode([
        "error" => mysqli_error($conn)
    ]);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
exit;