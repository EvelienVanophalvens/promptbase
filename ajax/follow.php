<?php

require_once("../bootstrap.php");

//follow

if(!empty($_POST)){
    $followerId = $_POST['userId'];
    $followingId = $_SESSION['userid'];

    $f = new Follow();
    $f->setFollowerId($followerId);
    $f->setFollowingId($followingId);
    $f->save();

    $result = [
        "status" => "success",
        "message" => "Follower was saved"
    ];
}

echo json_encode($result);