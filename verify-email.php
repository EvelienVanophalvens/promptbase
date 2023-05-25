<?php

include_once(__DIR__."/bootstrap.php");

if(isset($_GET['token'])) {
    $token = $_GET['token'];

    $emailVerified = User::verifiedEmail($token);


    if($emailVerified) {
        $_SESSION['status'] = "Your account has been verified succesfully!";
        header("Location: login.php");
    } else {
        $_SESSION['status'] = "Email already verified. Please login";
        header("Location: login.php");
    }
} else {
    $_SESSION['status'] = "Not allowed";
    header("Location: login.php");
}
