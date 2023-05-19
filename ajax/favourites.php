<?php
require_once("../bootstrap.php");

//config file
require_once("../config/config.ini");

//favourites
$favourites = Favourite::getFavouritePrompt($userId, $promptId);

//add favourites

if (isset($_POST['add_favourite'])) {
    $promptId = $_POST['promptId'];
    $userId = $_SESSION['userid'];

    $f = new Favourite();
    $f->setPromptId($promptId);
    $f->setUserId($userId);
    $f->save();

    $result = [
        "status" => "success",
        "message" => "Favourite was saved"
    ];
}
//delete favourites
if (isset($_POST['delete_favourite'])) {
    $promptId = $_POST['promptId'];
    $userId = $_SESSION['userid'];

    $f = new Favourite();
    $f->setPromptId($promptId);
    $f->setUserId($userId);
    $f->removeFavourite();

    $result = [
        "status" => "success",
        "message" => "Favourite was removed"
    ];
}

echo json_encode($result);