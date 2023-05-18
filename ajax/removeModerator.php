<?php

include_once(__DIR__."/../bootstrap.php");

//remove moderator

if (isset($_POST['remove'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $remove = User::removeModerator($username, $email);
    

    $result = [
        "status" => "success",
        "message" => "Moderator was removed"
    ];

    

}

echo json_encode($result);