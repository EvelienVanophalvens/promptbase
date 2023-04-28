<?php

include_once(__DIR__."/bootstrap.php");
if(!empty($_POST)) {
    //echo "hallo";
    $email = $_POST['email'];
    //var_dump($email);
    $user = User::getUserByEmail($email);
    //var_dump($user);
    if($user == false) {
        $result = [
            "status" => "success",
            "message" => "Email was saved"
        ];
    } else {
        $result = [
            "status" => "error",
            "message" => "Email isn't available anymore"
        ];
    }

    echo json_encode($result);

}
