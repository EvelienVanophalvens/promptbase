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
    <title>moderator</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<div class="canvas">
            <div class="box2">
                <?php if(isset($_SESSION['status'])) { ?>
                    <div class="alert">
                        <h5><?= $_SESSION['status']; ?></h5>
                    </div>
                    <?php unset($_SESSION['status']); ?>
                <?php } ?>
                <div class="context">                    
                    <h2><?php
if (isset($_SESSION['auth_user'])) {
    echo "<h2>Hello " . htmlspecialchars($_SESSION['auth_user']['username']) . "! <br>Choose one of the moderating actions below</h2>";
}else{
    echo "<h2>Hello! <br>Welcome to collectivePrompts.</h2>";
}
?></h2>
                   
                </div>
                <div class="illustration">
                    <img src="../uploads/illustration_team.png" alt="team">
                </div>
            </div>
        </div>

        <div class="moderateOptions">
        <button id="moderate"><a href="usersM.php" >Moderate users</a></button>
        <button id="moderate"><a href="promptsM.php" >Moderate prompts</a></button>
        <button id="moderate"><a href="addModerator.php" >Edit moderators</a></button>
    </div>
</body>
</html>