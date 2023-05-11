<?php 
    require_once("../bootstrap.php");
    
    if(!empty($_POST)){
        $userId = $_POST['userId'];
        User::blockUser($userId);
        User::RemoveReportedUser($userId);

        $blockedUsers = User::blockedUsers();
        

        $result = [
            "status" => "success",
            "message" => "User was blocked",
            "blockedUsers" => $blockedUsers
        ];
    }

    echo json_encode($result);
