<?php

require_once("../bootstrap.php");

//follow/unfollow user

$result = [
    "status" => "error",
    "message" => "Something went wrong"
];

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    if (!isset($_POST['follow'])) {
        // Follow user
        $follow = User::followUser($userId);

        $result = [
            "status" => "success",
            "message" => "User was followed"
        ];
    } else {
        // Unfollow user if already followed
        if (User::isFollowingUser($userId)) {
            $unfollow = User::unfollowUser($userId);

            $result = [
                "status" => "success",
                "message" => "User was unfollowed"
            ];
        } else {
            $result = [
                "status" => "error",
                "message" => "User is not currently followed"
            ];
        }
    }
}

echo json_encode($result);