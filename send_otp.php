<?php
// MUST be first
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOTP($email, $otp){

    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jiyanshutaksh@gmail.com';
        $mail->Password   = 'xznh ulyp worf vuus';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('jiyanshutaksh@gmail.com', 'QuickBites');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'OTP Code';
        $mail->Body    = "<h2>Your OTP is: $otp</h2>";

        $mail->send();
        return true;

    } catch (Exception $e){
        echo $mail->ErrorInfo;
        return false;
    }
}