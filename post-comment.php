<?php
include_once(__DIR__."/bootstrap.php");

authenticated();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decodeer de JSON-gegevens vanuit de client
    $data = json_decode(file_get_contents('php://input'), true);
    //gegevens die we gaan doorsturen
    $promptId = $data["prompt"];
    $comment = $data['comment'];
    $userId = $_SESSION['userid'];

    // Voeg de comment toe aan de database
    Prompts::addComment($userId, $promptId, $comment);

    // Haal de volledige lijst van comments opnieuw op voor de AJAX response
    $comments = Prompts::getAllComments($promptId);

    // Zet de comments om naar een JSON array
    $jsonComments = json_encode($comments);

    // Stuur de JSON response terug naar de client
    header('Content-Type: application/json');
    echo $jsonComments;
}