<?php 
require_once("../bootstrap.php");

$likes = Like::getLikes($_POST['promptId'], ((int)$_SESSION["userid"]));


if($likes){
    if (!empty($_POST)) {
        $promptId = $_POST['promptId'];
        $userId = $_SESSION["userid"];
    
        $l = new Like();
        $l->setPromptId($promptId);
        $l->setUserId($userId);
        $l->removeLike();
    
        $p = new Prompts();
        $p->setId($promptId);
        $likes = $p->getLikes();
    
        $result = [
            "status" => "success",
            "message" => "Like was saved",
            "likes" => $likes 
        ];
    }

}else{

if (!empty($_POST)) {
    $promptId = $_POST['promptId'];
    $userId = $_SESSION["userid"];

    $l = new Like();
    $l->setPromptId($promptId);
    $l->setUserId($userId);
    $l->save();

    $p = new Prompts();
    $p->setId($promptId);
    $likes = $p->getLikes();

    $result = [
        "status" => "success",
        "message" => "Like was saved",
        "likes" => $likes 
    ];

    }
}
    echo json_encode($result);
