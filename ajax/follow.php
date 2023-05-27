<?php
require_once("../bootstrap.php");

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $loggedInUserId = $_SESSION["userid"];

    $isFollowing = User::isFollowingUser($loggedInUserId, $userId);

    if ($isFollowing) {
        // Remove the follow if already following
        Follow::removeFollow($userId, $loggedInUserId);
        $result = [
            "status" => "success",
            "message" => "Follow was removed"
        ];
    } else {
        $f = new Follow();
        $f->setUserId($userId);
        $f->setFollowerId($loggedInUserId);
        $f->save();

        $result = [
            "status" => "success",
            "message" => "Follow was saved"
        ];
    }

    echo json_encode($result);
}