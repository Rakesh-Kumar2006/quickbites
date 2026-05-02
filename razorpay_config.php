<?php
require __DIR__ . '/vendor/autoload.php';

use Razorpay\Api\Api;

$keyId     = "rzp_test_SipD325fcq3F72";   // 🔴 replace
$keySecret = "gVTJK1SYI8PS3ncf0tq10RNY";     // 🔴 replace

$api = new Api($keyId, $keySecret);