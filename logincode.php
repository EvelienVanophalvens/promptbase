<?php 
include_once(__DIR__."/bootstrap.php");

if(isset($_POST['login_now_btn'])) {
    if(!empty(trim($_POST['username'])) && !empty(trim($_POST['password']))) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $pdo = Db::getInstance();

        // prepare the SQL query using placeholders to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row && password_verify($password, $row['password'])) {
            if($row['verified'] == 1) {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'username' => $row['username'],
                    
                ];
                $_SESSION['userid'] = $row['id'] ;
                $_SESSION['status'] = "Login Successfull";
                header("Location: home.php");
            } else {
                $_SESSION['status'] = "Please Verify your Email Address to Login.";
                header("Location: login.php");
            }
        } else {
            $_SESSION['status'] = "Invalid Username or Password";
            header("Location: login.php");
        }
    } else {
        $_SESSION['status'] = "All fields are Mandetory";
        header("Location: login.php");
    }
}
?>
