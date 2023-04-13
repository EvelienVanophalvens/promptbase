<?php
    spl_autoload_register(function($class){
        require_once(__DIR__ . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . $class . ".php");
    });
    // interfaces
    //require_once("interfaces/User.php");


    // functions
    require_once("functions/functions.php");
    // traits
    require_once("traits/Json.php");
    //plugins
    require_once("plugins/PHPMailer-master/src/PHPMailer.php");
    require_once("plugins/PHPMailer-master/src/Exception.php");
    require_once("plugins/PHPMailer-master/src/SMTP.php");
?>