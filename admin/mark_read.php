<?php
include("../db.php");

mysqli_query($conn,"
UPDATE admin_notifications 
SET status='read' 
WHERE status='unread'
");

echo "done";