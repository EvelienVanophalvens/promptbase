<?php 
    if(!empty($_POST)){
		//gesubmit
        //inputs uitlezen
        // Controleer of het e-mailveld is ingevuld
        if(empty($_POST['email'])){
            $error = "Email veld is verplicht";
        }else{
            $email = $_POST['email'];
        };

		//2 tot de koste keer (14) keer hashen van het wachtwoord
		$options = [
			'cost' => 14,
		];

        //$password = md5($_POST['password']);  --> md5 onveilig
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);
		
		try{
			//meerdere databasestypes mogelijk
			$conn = new PDO('mysql:host=localhost;dbname=promptbase', "root", "root");
			//query voorbereiden voor beveiligd te worden = statement
			//: staat voor placeholder
			$statement = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password);");
			$statement->bindValue(":email", $email); // beveiliging sql injection
			$statement->bindValue(":password", $password);
			$statement->execute();
			//de data zit in onze database en we worden doorgestuurd naar de login pagina
			header("Location: login.php");

		}catch(Throwable $e) {
			//error genereren
			$error = $e->getMessage();
		}
	} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log in</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <!--A new user wants to make a account before they can login-->
</head>
<body>
  <div class="canvas">
    <div class="box">
        <div class="title">
        <h2>Sign in to your account</h2>
        </div>
        <form class="" action="#" method="POST">
        <input type="hidden" name="remember" value="true">
        <div class="form-element">
            <div class="login-input">
                <?php if(isset($error)) { ?>
                    <p class="error"><?php echo "Please don't forget you're email!"; ?></p>
                <?php } ?>
            <label for="email-address" class="hidden">Email address</label>
            <input id="email-address" name="email" type="email" autocomplete="email" placeholder="Email address">
            </div>
            <div class="login-input">
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
            <a href="#" class="forgot">Forgot your password?</a>
            </div>
        </div>
        <div class="form-element">
            <button type="submit" class="submit">
            <span>
                <svg class="" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                </svg>
            </span>
            Sign in
            </button>
        </div>
        </form>
    </div>
  </div>
</body>
</html>