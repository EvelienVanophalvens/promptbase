<?php
include_once(__DIR__."/bootstrap.php");

if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit();
}


if (isset($_POST['user_delete'])) {
    $id = $_POST['user_delete'];


    // Debug statement to check the ID value
    var_dump($id);

    $pdo = Db::getInstance();

    // Delete the user from the database
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(":id", $id);
    $stmt->execute();


    // Debug statement to check if the query executed successfully
    var_dump($stmt->errorInfo());

    header("Location: logout.php");
    exit();
}