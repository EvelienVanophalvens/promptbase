<?php
include_once(__DIR__."/bootstrap.php");

if(isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "You are already logged in";
    header("Location: index.php");

}
//kijken of post niet leeg is
if(!empty($_POST)) {
    //kijken of email niet leeg is ander error
    if(!empty($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $usernameError = "Please enter your username";
    }
    //kijken of password niet leeg is ander error
    if(!empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $passwordError = "Please enter your password";
    }
    //als beide error niet leeg zijn, dan kan je inloggen
    if(empty($usernameError) && empty($passwordError)) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $userid = User::login($username, $password);
            if($userid) {
                header("Location: index.php");
                session_start();
                $_SESSION['userid'] = $userid ;
                $_SESSION['authenticated'] = true;

            } else {
                $loginError = "Username or password is incorrect";
            }

    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">

    <!--The excisting user wants to log in their account-->
</head>
<body>
<div class="canvas">



    <div class="box">
   
        <div class="title">
        <h2>Log in to your account</h2> 
        <?php if(isset($_SESSION['status'])) { ?>
    <div class="alert succes">
        <h5><?= $_SESSION['status']; ?></h5>
    </div>
    <?php unset($_SESSION['status']); ?>
<?php } ?>
        </div>
        <form class="" method="POST">
      
        <div class="form-element">
            <?php if(!empty($loginError)) { ?>
                <p class="errormessage"><?php echo $loginError; ?></p>
            <?php } ?>
            <div class="login-input">
                <?php if(!empty($usernameError)) { ?>
                    <p class="errormessage"><?php echo $usernameError; ?></p>
                <?php } ?>
            <label for="username" class="hidden">Username</label>
            <input type="text" id="username" name="username" placeholder="Username">
            </div>
            <div class="login-input">
                <?php if(!empty($passwordError)) { ?>
                    <p class="errormessage"><?php echo $passwordError; ?></p>
                <?php } ?>
            <label for="password" class="hidden">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Password">
            </div>
        </div>
        <div class="form-element">
           <div class="items-center remember"> 
            <input id="remember-me" name="remember-me" type="checkbox" class="checkbox">
            <label for="remember-me" class="checkmark">Remember me</label>
            </div>
            <div class="items-center">
            <a href="resetPassword.php" class="forgot">Forgot your password?</a>
            </div>
        </div>
            
        
        <button type="submit" class="submit">
            <span>
                <svg class="" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                </svg>
            </span>
            Log in
            </button>
        </form>
    </div>
  </div>
</body>
</html>