<?php

require_once("../bootstrap.php");

//follow user

 
if (!isset($_POST['follow'])) {
    $userId = $_POST['userId'];
    $follow = User::followUser($userId);

    $result = [
        "status" => "success",
        "message" => "User was followed"
    ];
}
else{
    if(isset($_POST['follow'])){
        $userId = $_POST['userId'];
        $follow = User::unfollowUser($userId);
    
        $result = [
            "status" => "success",
            "message" => "User was unfollowed"
        ];
    }
    else{
        $result = [
            "status" => "error",
            "message" => "Something went wrong"
        ];
    }
}

echo json_encode($result);