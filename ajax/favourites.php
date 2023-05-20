<?php
require_once("../bootstrap.php");


$favourits = Favourite::getFavourites($_POST['promptId'], ((int)$_SESSION["userid"]));


if (isset($_POST)) {
    if (!empty($_POST)) {
        $promptId = $_POST['promptId'];
        $userId = $_SESSION["userid"];

        $f = new Favourite();
        $f->setPromptId($promptId);
        $f->setUserId($userId);
        $f->removeFavourite();

        $result = [
            "status" => "success",
            "message" => "Favourite was removed"
        ];
    }
}else{
    if (!isset($_POST)) {
        $promptId = $_POST['promptId'];
        $userId = $_SESSION['userid'];

        // Add favourite
        $f = new Favourite();
        $f->setPromptId($promptId);
        $f->setUserId($userId);
        $f->save();

        $result = [
            "status" => "success",
            "message" => "Favourite was saved"
        ];
    }
}

echo json_encode($result);
