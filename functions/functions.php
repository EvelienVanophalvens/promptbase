<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require 'vendor/autoload.php';


function check_login()
{
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php");
        exit;
    }
}


function sendemail_verify($username, $email, $verified)
{
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'lindsay.prompt@gmail.com';
    $mail->Password = 'apjlogqclgpdlpzb';

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('lindsay.prompt@gmail.com', 'PromptBase');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Email Verification';

    $mail->Body = "<h1>Hi $username, Welcome to PromptBase</h1>
        <p>Click on the link below to verify your email address</p>
        <a href='http://localhost/promptbase/verify-email.php?token=$verified'>Click Here</a>";

    $mail->send();
    //echo 'Message has been sent';
}

function authenticated()
{

    if(!isset($_SESSION['authenticated'])) {
        $_SESSION['status'] = "Please Login to Access User Home!";
        header("Location: login.php");
        exit(0);
    }
}
