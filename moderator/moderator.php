<?php
include_once(__DIR__."/../bootstrap.php");
include_once(__DIR__."/navbarM.php");

if(User::isAdmin() === false) {
    header("Location: ../error.php");
    echo "you are not a moderator";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>moderator</title>
</head>
<body>
    
</body>
</html>