<?php

include_once(__DIR__."/bootstrap.php");

if(isset($_GET['token'])) {
    $token = $_GET['token'];

    $emailVerified = User::verifiedEmail($token);


    if($emailVerified) {
        $_SESSION['status'] = "Your Account has been verified Succesfully!";
        header("Location: login.php");
    } else {
        $_SESSION['status'] = "Email Already Verified. Please Login";
        header("Location: login.php");
    }
} else {
    $_SESSION['status'] = "Not Allowed";
    header("Location: login.php");
}
