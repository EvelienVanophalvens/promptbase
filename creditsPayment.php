<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");


 $credits = $_GET['credits'];

//get the price
if($credits == 25) {
    $price = 10;
} else if($credits == 50) {
    $price = 35;
} else if($credits == 100) {
    $price = 85;
}

// Controleer of de credits parameter is doorgegeven in de URL
if(isset($_GET['credits'])) {
    $credits = $_GET['credits'];
     $melding = "<p class = 'statement' >U koopt " . $credits . " credits. Hiervoor moet u " . $price . " euro betalen.</p>";
} else {
    $melding = "<p class = 'statement error '>Er is een fout opgetreden. Probeer het later opnieuw.</p>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Payment page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="content">
    <a href="buyCredits.php" id="backbtn">< BACK TO OVERVIEW</a>
    <div class="container2">
        <h1>Payment page</h1>
        <?php echo $melding;?>
        <div class="payment">
            <form action="creditsPayment.php" method="POST" id="creditsPayment">
                <h3>Billing Address</h3>
                <label for="cardname">Name on Card</label>
                <input type="text" id="cardname" name="cardname" required><br>
                
                <label for="cardnumber">Credit card number</label>
                <input type="text" id="cardnumber" name="cardnumber" required><br>
                
                <label for="expmonth">Exp Month</label>
                <input type="text" id="expmonth" name="expmonth" required><br>

                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" required><br>
                    
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>
        
                <button class="submit"><a href="paymentSucces.php?credits" . $credits>Pay</a></button>

            </form>
        </div>
    </div>

      
</body>
</html>
