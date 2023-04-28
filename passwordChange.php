<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
            <h2>Change your password</h2>
        </div>
        <div class="info" <?php if(isset($_SESSION['status'])) {
            echo 'style="display: none"';
        } ?>>
                <form method="POST" action="resetPasswordCode.php">
                    <div class="form-element">
                        <input type="hidden" id="token" name="token" value="<?php if(isset($_GET['token'])) {
                            echo $_GET['token'];
                        } ?>">
                        <div class="passwordChange-input">
                            <label for="email">Enter your email address:</label>
                            <input type="email" id="email" name="email" value="<?php if(isset($_GET['email'])) {
                                echo $_GET['email'];
                            } ?>" required>
                        </div>
                        <div class="passwordChange-input">
                            <label for="newPassword">Enter your new password:</label>
                            <input type="password" id="password" name="newPassword" required>
                        </div>
                        <div class="passwordChange-input">
                            <label for="newpasswordConfirmation">Confirm your new password:</label>
                            <input type="password" id="password" name="confirmationPassword" required>
                        </div>
                    </div>
                    <div class="form-element">
                        <button type="submit" class="submit" name="passwordUpdate">
                            Reset my password
                        </button>
                    </div>
                    
                </form>
        </div>
        <div>
            <?php
                if(isset($_SESSION['status'])) {
                    ?>
                    <div class="alert-succes">
                        <h5><?php echo $_SESSION['status'];?></h5>
                    </div>
                    <div>
                        <a href="login.php">Opnieuw inloggen</a>
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