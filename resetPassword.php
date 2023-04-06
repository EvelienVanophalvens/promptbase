<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once(__DIR__."/bootstrap.php");

//FUNCTIE
function generate_password($length = 10) {
    // Define a set of characters to use in the password
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+={}[]|\:;"<>,.?/';

    // Shuffle the characters to ensure a random order
    $chars = str_shuffle($chars);

    // Generate a password using the first $length characters of the shuffled string
    $password = substr($chars, 0, $length);

    return $password;
};


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user's email address from the form submission
    $email = $_POST['email'];

    // Generate a new password for the user
    $new_password = generate_password();

    // Update the user's password in the database
    $success = User::update($email, $new_password);

    if ($success == NULL) {
        // Send an email to the user with the new password
        $subject = 'Your password has been reset';
        $message = "Your password has been reset to: $new_password";
        $headers = 'From: webmaster@example.com' . "\r\n" .
                   'Reply-To: webmaster@example.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
    
        $mail_sent = mail($email, $subject, $message, $headers);

        if ($mail_sent) {
            // Redirect the user back to the reset password page with a success message
            header('Location: resetPassword.php?status=success');
            exit();
        } else {
            // Redirect the user back to the reset password page with an error message
            header('Location: resetPassword.php?status=error');
            exit();
        }
    } else {
        // Redirect the user back to the reset password page with an error message
        header('Location: resetPassword.php?status=error');
    };
};
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
        <div class="info">
            <p>Hey, we received a request to reset your password. Let's get you a new one!</p>
            <?php if(isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                <p>An email has been sent to your email address with instructions on how to reset your password.</p>
            <?php elseif(isset($_GET['status']) && $_GET['status'] === 'error'): ?>
                <p>There was an error resetting your password. Please try again later.</p>
            <?php else: ?>
                <form method="POST" action="resetPassword.php">
                    <label for="email">Enter your email address:</label>
                    <input type="email" id="email" name="email" required>
                    <button type="submit" class="submit">
                        Reset my password
                    </button>
                </form>
            <?php endif; ?>
            <p>Didn't request a password reset? You can ignore this message.</p>
        </div>
    </div>
</div>
</body>
</html>