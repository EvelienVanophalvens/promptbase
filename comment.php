<?php
include_once(__DIR__."/bootstrap.php");

authenticated();

if (!empty($_POST)) {
    //gegevens die we gaan doorsturen
    $promptId = $_POST["promptId"];
    $comment = $_POST['comment'];
    $userId = $_SESSION['userid'];

    // Voeg de comment toe aan de database
    $c = new Comment();
    $c->setPromptId($promptId);
    $c->setUserId($userId);
    $c->setComment($comment);
    $c->save();

    // Haal de volledige lijst van comments opnieuw op voor de AJAX response
    $comments = Comment::getAllComments($promptId);
    //$postedComment = Comment::getLastComment($promptId);
    //Houdt de status bij
    $result = [
        "status" => "success",
        "message" => "Comment was saved",
        "comments" => $comments 
    ];

    // Zet de comments om naar een JSON array
    $jsonComments = json_encode($result);

    // Stuur de JSON response terug naar de client
    echo $jsonComments;
}else{
    $jsonComments = "lukt niet";
    echo $jsonComments;
}
