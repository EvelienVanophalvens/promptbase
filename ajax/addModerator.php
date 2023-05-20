<?php
include_once(__DIR__."/../bootstrap.php");

//add moderator


if (!isset($_POST['add'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $add = User::addModerator($username, $email);
    

    $result = [
        "status" => "success",
        "message" => "Moderator was added"
    ];

    

}

echo json_encode($result);