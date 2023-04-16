<?php
    include_once(__DIR__."/bootstrap.php");    
    include_once (__DIR__."/navbar.php");
    authenticated();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn profiel</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">

</head>
<body>
    <div class="context">
        <h2>Edit profile of <?php echo $_SESSION['auth_user']['username']; ?>
        <h3>Your password</h3>
        <p>Attention: You are currently logged in as <?php echo $_SESSION['auth_user']['username']; ?>. <br>When you change your password you will have to log in again with your new password.</p>
        <button class="submit small"><a href="resetPassword.php">Edit password</a></button>
    </div>
</body>
</html>