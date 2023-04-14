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
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
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
        <h2>Hello! Welcome to the home page <?= $_SESSION['auth_user']['username']; ?>.</h2>
       
    </div>
    </div>
    </div>
</body>
</html>