<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once(__DIR__."/bootstrap.php");

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//require './plugins/PHPMailer-master/src/Exception.php';
//require './plugins/PHPMailer-master/src/PHPMailer.php';
//require './plugins/PHPMailer-master/src/SMTP.php';


//Load Composer's autoloader
require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email,$token)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    /* $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'promptbase@yahoo.com';                     //SMTP username
    $mail->Password   = 'WachtwoordPrompt123';                              //SMTP password
 */
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'lindsay.prompt@gmail.com';                     //SMTP username
    $mail->Password   = 'xenfawrsbprsfzta';                              //SMTP password
    
    //$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('lindsay.prompt@gmail.com', 'PromptBase');
    $mail->addAddress($get_email, $get_name);     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset Password Notification';
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $email_template = "
    <h2>Hello</h2>
    <h3>You are receiving this email because we received a password reset request for your account.</h3>
    <br></br>
    <a href='http://localhost/promptbase/passwordChange.php?token=$token&email=$get_email'>Click me </a>";

    $mail->Body = $email_template;
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message sent!';
    }
}

if(isset($_POST['passwordResetLink'])){
    $conn = Db::getInstance();

    $email = $_POST['email'];
    $token = md5(rand());
    $check_email = "SELECT email, username FROM users WHERE email=:email LIMIT 1";
    $statement = $conn -> prepare($check_email);
    $statement->bindValue(":email", $email);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    var_dump($row);

    if($row !== false)
    {
        $get_name = $row['username'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET password='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = $conn->query($update_token);

        if($update_token_run)
        {
            send_password_reset($get_name, $get_email,$token);
            $_SESSION['status'] = "We e-mailed you a password reset link. <br> Go check in your e-mailbox.";
            header("Location: resetPassword.php");
            exit(0);
        }else{
            $_SESSION['status'] = "Something went wrong";
            header("Location: resetPassword.php");
            exit(0);
        }
    }else{
        $_SESSION['status'] = "No email found";
        header("Location: resetPassword.php");
        exit(0);
    }
}

if(isset($_POST['passwordUpdate']))
{
    $email = $_POST['email'];
    $token = $_POST['token'];
    $newPassword = $_POST['newPassword'];
    $confirmationPassword = $_POST['confirmationPassword'];

    // Hash wachtwoord met Bcrypt
    $options = [
        'cost' => 12, // Het aantal iteraties om de hash te berekenen, 12 wordt als veilig beschouwd voor de meeste toepassingen
    ];
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, $options);

    if(!empty($token))
    {
        if(!empty($email)&&!empty($newPassword)&&!empty($confirmationPassword))
        {
            $conn = Db::getInstance();
            //Validatie token
            $check_token = "SELECT password FROM users WHERE password=:password LIMIT 1";
            $statement = $conn -> prepare($check_token);
            $statement->bindValue(":password", $token);
            $statement->execute();
            $resl = $statement->fetch(PDO::FETCH_ASSOC);

            if($resl!==false)
            {
                //Validatie paswoord invoer
                if($newPassword == $confirmationPassword)
                {
                    $update_password = "UPDATE users SET password=:password WHERE password=:token LIMIT 1";
                    $statement = $conn -> prepare($update_password);
                    $statement->bindValue(":password", $hashedPassword);
                    $statement->bindValue(":token", $token);
                    $statement->execute();
                    
                    if($statement){
                        $_SESSION['status'] = "Confirmed new password!<br>You can log in with your new password.";
                        header("Location: passwordChange.php?token=$token&email=$email");
                        exit(0);
                    }
                }else
                {
                    $_SESSION['status'] = "Password and confirm password does not match";
                    header("Location: passwordChange.php?token=$token&email=$email");
                    exit(0);
                }
            }else
            {
                $_SESSION['status'] = "Invalid token";
                header("Location: passwordChange.php?token=$token&email=$email");
                exit(0);
            }
        }else
        {
            $_SESSION['status'] = "All fields are required!";
            header("Location: passwordChange.php?token=$token&email=$email");
            exit(0);
        }
    }else
    {
        $_SESSION['status'] = "No token avaible";
        header("Location: passwordChange.php");
        exit(0);
    }

}
?>