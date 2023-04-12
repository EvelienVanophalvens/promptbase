<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once(__DIR__."/bootstrap.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your password</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">

</head>
<body>
<div class="canvas">
    <div class="box">
        <div class="title">
            <h2>Forgot your password?</h2>
        </div>
        <div class="info" <?php if(isset($_SESSION['status'])) {echo 'style="display: none"';} ?>>
            <p>Hey, we received a request to reset your password. Let's get you a new one!</p>
                <form method="POST" action="resetPasswordCode.php">
                    <label for="email">Enter your email address:</label>
                    <input type="email" id="email" name="email" required>
                    <button type="submit" class="submit" name="passwordResetLink">
                        Reset my password
                    </button>
                </form>
            <p>Didn't request a password reset? You can ignore this message.</p>
        </div>
        <div>
            <?php
                if(isset($_SESSION['status']))
                {
                    ?>
                    <div class="alert-succes">
                        <h5><?php echo $_SESSION['status'];?></h5>
                    </div>
                    <?php
                    unset($_SESSION['status']);
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>