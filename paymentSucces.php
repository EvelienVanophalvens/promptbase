<?php 
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

$user = User::getUser($_SESSION['userid']);

if(isset($_GET['credits'])) {
    $credits = $_GET['credits'];

    User::updateBuyCredit($credits);

    $melding = "<h1>Payment successful</h1><p>Thank you for your payment</p><p class='statement'>You have bought " . $credits . " credits</p>";
} else {
    $melding = "<p class='statement error'>Er is een fout opgetreden. Probeer het later opnieuw.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content">
    <div class="container2">
                <?php echo $melding; ?>
                <a href="index.php">Go back to the home page</a>
    </div>
    </div>
</body>
</html>