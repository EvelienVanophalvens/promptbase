<?php 
include_once(__DIR__."/../bootstrap.php");
include_once(__DIR__."/navbarM.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<div class="content">
<a href="home.php" id="backbtn">< BACK TO OVERVIEW</a>

    <h1>Moderator</h1>
    <h2>Newest moderators</h2>
    <hr>
    <table>
    <tr>
            <th>name</th>
            <th>email</th>
           <th> <button>Remove</button></th>
        </tr>
        <tr>
            <th>name</th>
            <th>email</th>
           <th> <button>Remove</button></th>
        </tr>
        <tr>
            <th>name</th>
            <th>email</th>
           <th> <button>Remove</button></th>
        </tr>
        
    </table>
    
    <hr>
    <form action="addModeratorCode.php" method="POST">
        <div class="form-element">
            <label for="username">Name:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-element">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-element">
            <button type="submit" class="submit" name="addModerator">
                Add
            </button>
        </div>
</div>
</body>
</html>