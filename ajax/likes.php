<?php 
require_once("../bootstrap.php");

if (!empty($_POST)) {
    $promptId = $_POST['promptId'];
    $userId = 1;

    $l = new Like();
    $l->setPromptId($promptId);
    $l->setUserId($userId);
    $l->save();

    $p = new Prompts();
    $p->setId($promptId);
    $likes = $p->getLikes($promptId);

    $result = [
        "status" => "success",
        "message" => "Like was saved",
        "likes" => $likes 
    ];

    header('Content-Type: application/json');
    echo json_encode($result);
}