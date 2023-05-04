<?php
include_once(__DIR__."/bootstrap.php");



if(!empty($_POST)) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // genereert een willekeurige tekenreeks en versleutelt deze met het MD5-hash-algoritme (email)
    $verified = md5(rand());


    $options = [
        'cost' => 14,
    ];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT, $options);


    //gesubmit
    //inputs uitlezen
    //USERNAME VALIDATIE
    if(empty($_POST['username'])) {
        $usernameError = "Please, don't forget your username!";
    } else {
        $username = $_POST['username'];
    };
    // EMAIL VALIDATIE
    if(empty($_POST['email'])) {
        $emailError = "Please, don't forget your email!";
    } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailError = "Sorry, this is a invalid email.";
    } else {
        $email = $_POST['email'];
    };

    //WACHTWOORD VALIDATIE
    //Controleer of het wachtwoord lang genoeg is (meer dan vijf karakters)
    if(empty($_POST['password'])) {
        $passwordError = "Please, don't forget your password!";
    } elseif(strlen($_POST['password'])<5) {
        $passwordError = "Your password needs to be at least 5 characters long.";
    } else {
        //als alle validaties slagen kunnen we de gebruiker opslaan in de database
        if(empty($usernameError) && empty($emailError) && empty($passwordError)) {
            try {
                $user = new User();
                $user->setUsername($_POST['username']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->setVerified($verified);
                //save database -> de gebruiker op te slaan
                $res = $user->save();
                //de data zit in onze database en we worden doorgestuurd naar de login pagina
                sendemail_verify($username, $email, $verified);
                header("Location: login.php");
            } catch(Throwable $e) {
                echo $e->getMessage();
                var_dump($e);
            }
        }
    };
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <!--A new user wants to make a account before they can login-->
</head>
<body>
  <div class="canvas">
    <div class="box">
        <div class="title">
        <h2>Make your account</h2>
        </div>
        <div class="alert">
            <?php
                if(isset($_SESSION['status'])) {
                    echo '<h4>'.$_SESSION['status'].'</h4>';
                    unset($_SESSION['status']);
                }
            ?>
        </div>
        <form class="" action="" method="POST">
        <input type="hidden" name="remember" value="true">
        <div class="form-element">
        <div class="login-input">
                <?php if(!empty($usernameError)) { ?>
                    <p class="error"><?php echo $usernameError; ?></p>
                <?php } ?>
            <label for="username" class="hidden">Username</label>
            <input id="username" name="username" type="text" autocomplete="username" placeholder="Username">
            </div>
            <div class="login-input">
                <?php if(!empty($emailError)) { ?>
                    <p class="error"><?php echo $emailError; ?></p>
                <?php } ?>
            <label for="email-address" class="hidden">Email address</label>
            <input id="email-address" name="email" type="email" autocomplete="email" placeholder="Email address">
            </div>
            <div class="login-input">
                <?php if(!empty($passwordError)) { ?>
                    <p class="error"><?php echo $passwordError; ?></p>
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
            <a href="#" class="forgot hidden">Forgot your password?</a>
            </div>
        </div>
        <div class="form-element">
            <button type="submit" class="submit" name="submit_btn">
            <span>
                <svg class="" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                </svg>
            </span>
            Sign up
            </button>
        </div>
        </form>
    </div>
  </div>
  <script>
    //Controleren of het email al dan niet bestaat.
    //de juiste HTML-elementen selecteren
    let typedEmail = document.getElementById("email-address");
    let errorMessage = document.querySelector(".alert");
    //FUNCTIE: dez word enkel uitgevoerd wanneer het element veranderd
    typedEmail.addEventListener("change",function(e){
        //autorefresh voorkomen
        e.preventDefault();
        // Maak een AJAX-request naar getUserByEmail.php
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "getUserByEmail.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Het resultaat van de functie is in xhr.responseText beschikbaar
                let result = JSON.parse(xhr.responseText);
                if(result.status === "error") {
                    typedEmail.classList.add("error");
                    errorMessage.innerText = result.message;
                }
                else {
                    typedEmail.classList.remove("error");
                    errorMessage.innerText = "";
                }
            }
        };
        xhr.send("email=" + typedEmail.value);

        console.log("gesubmit");
    })
  </script>
</body>
</html>