<?php

spl_autoload_register(function ($class) {
    require_once(__DIR__ . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . $class . ".php");
});
// interfaces
//require_once("interfaces/User.php");


// functions
require_once("functions/functions.php");
// traits
require_once("traits/Json.php");
//plugins
require_once("src/PHPMailer.php");
require_once("src/SMTP.php");
require_once("src/Exception.php");
