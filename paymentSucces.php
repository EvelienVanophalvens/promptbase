<?php 

$credits = $_GET['credits'];

include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

$user = User::getUser($_SESSION['userid']);

User::updateBuyCredit($credits);


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
 <div class="row">
        <div class="col-12">
            <h1>Payment succesfull</h1>
            <p>Thank you for your payment</p>
            <a href="index.php">Go back to the home page</a>
        </div>
        </div>
    </div>

</body>
</html>