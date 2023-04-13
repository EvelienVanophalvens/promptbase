<?php
session_start();
include_once(__DIR__."/bootstrap.php");

if(isset($_GET['token']))
{
    $token = $_GET['token'];
    $pdo = Db::getInstance(); // Get the PDO connection

    // Check if token exists and account is not already verified
    $verify_query = "SELECT verify_token, verified FROM users WHERE verify_token=:token LIMIT 1";
    $stmt = $pdo->prepare($verify_query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if($stmt->rowCount() > 0)
    {
        $row = $stmt->fetch();
        if($row['verified'] == 0)
        {
            // Update account status to verified
            $clicked_token = $row['verify_token'];
            $update_query = "UPDATE users SET verified='1' WHERE verify_token=:clicked_token LIMIT 1";
            $stmt = $pdo->prepare($update_query);
            $stmt->bindParam(':clicked_token', $clicked_token);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                $_SESSION['status'] = "Your Account has been verified Succesfully!";
                header("Location: login.php");
            }
            else
            {
                $_SESSION['status'] = "Verification Failed";
                header("Location: login.php");
            }
        }
        else
        {
            $_SESSION['status'] = "Email Already Verified. Please Login";
            header("Location: login.php");
        }
    }
    else
    {
        $_SESSION['status'] = "This Token does not Exist";
        header("Location: login.php");
    }
}
else
{
    $_SESSION['status'] = "Not Allowed";
    header("Location: login.php");
}
?>
