<?php 

session_start();
include_once(__DIR__."/bootstrap.php");

if(isset($_POST['submit_btn']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verified = md5(rand());

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $pdo = Db::getInstance(); // Get the PDO connection

    // Email Exists or not
    $check_email_query = "SELECT email FROM users WHERE email=:email LIMIT 1";
    $stmt = $pdo->prepare($check_email_query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if($stmt->rowCount() > 0)
    {
        // Email already exists
        $_SESSION['status'] = "Email Id already Exists";
        header("Location: signUp.php");
    }
    else
    {
        // Insert User / Registered User Data
        $query = "INSERT INTO users (username,password,email,verify_token) VALUES (:username, :password, :email, :verify_token)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':verify_token', $verified);

        if($stmt->execute())
        {
            sendemail_verify("$username", "$email", "$verified");

            $_SESSION['status'] = "Registration Successfull! Please verify your Email Address.";
            header("Location: signUp.php");
        }
        else
        {
            $_SESSION['status'] = "Registration Failed";
            header("Location: signUp.php");
        }
    }
}

?>