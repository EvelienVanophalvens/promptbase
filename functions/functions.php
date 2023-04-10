<?php
    function check_login(){
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
            header("Location: login.php");
            exit;
        }
    }