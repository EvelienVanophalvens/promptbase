<?php
include_once(__DIR__."/bootstrap.php");
authenticated();
include_once(__DIR__."/navbar.php");

$user = User::getUser($_SESSION['userid']);
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
    <div class="content-settings">
        <div class="actions">
            <h2>Edit profile of <?php echo htmlspecialchars($_SESSION['auth_user']['username']); ?>
            <h3>Your password</h3>
            <p>Attention: You are currently logged in as <?php echo htmlspecialchars($_SESSION['auth_user']['username']); ?>. <br>When you change your password you will have to log in again with your new password.</p>
            <button class="submit small"><a href="resetPassword.php">Edit password</a></button>
            <h3>Delete your account</h3>
            <p>Attention: You are currently logged in as <?php echo htmlspecialchars($_SESSION['auth_user']['username']); ?>. <br>When you delete this account, you wont be able to log in again!</p>
            <form action="deleteaccount.php" method="POST">
                <button  name="user_delete" class="submit small danger" type="submit" value="<?= htmlspecialchars($_SESSION['auth_user']['username']);?>">Delete account</button>
            </form>
        </div>
        <div class="credits">
            <h3>Credits</h3>
            <h3><?php echo htmlspecialchars($user['credits'])?></h3>
            <p>You have a amount of <strong><?php echo htmlspecialchars($user['credits'])?></strong> credits to spend. In order to receive more credits you need to make new prompts.</p>
            <div class="buyCredits">
            <h3>Buy credits</h3>
            <p>Do you want to buy more credits? <br>Click the button below to buy more credits.</p>
            <button class="submit small"><a href="buyCredits.php">Buy credits</a></button>
        </div>
        </div>
        
    </div>
</body>
</html>