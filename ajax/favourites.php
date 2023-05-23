<?php
require_once("../bootstrap.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $promptId = $_POST['promptId'];
    $userId = $_SESSION["userid"];

    // Check if the prompt is already added as a favorite
    if (Favourite::getFavourites($promptId, $userId)) {
        Favourite::removeFavourite($promptId, $userId);
        $result = [
            "status" => "success",
            "message" => "Favourite was removed"
        ];
    } else {
        // Add the prompt as a favorite
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