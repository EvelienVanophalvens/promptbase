<?php
require_once("../bootstrap.php");


$favourits = Favourite::getFavourites($_POST['promptId'], ((int)$_SESSION["userid"]));



    if(isset($_POST)){
        //add to favourites
        $promptId = $_POST['promptId'];
        $userId = $_SESSION["userid"];

        $f = new Favourite();
        $f->setPromptId($promptId);
        $f->setUserId($userId);
        $f->save();

        $result = [
            "status" => "success",
            "message" => "Favourite was saved"
        ];
    }else{
    //remove from favourites if already a favourite
    if(Favourite::getFavourites($_POST['promptId'], ((int)$_SESSION["userid"]))) {
        $promptId = $_POST['promptId'];
        $userId = $_SESSION["userid"];

        Favourite::removeFavourite($promptId, $userId);

        $result = [
            "status" => "success",
            "message" => "Favourite was removed"
        ];
    }
}
echo json_encode($result);
