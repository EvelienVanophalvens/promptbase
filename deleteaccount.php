<?php

include_once(__DIR__."/bootstrap.php");



if (isset($_POST['user_delete'])) {
    $user = new User();
    $user->setUserId($_SESSION['userid']);
    $user->deleteUser();
    session_destroy();
    header("Location: login.php");
    exit();
}
