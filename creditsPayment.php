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
    <?php
			// Controleer of de credits parameter is doorgegeven in de URL
			if(isset($_GET['credits'])) {
				$credits = $_GET['credits'];
				echo "<p>U koopt " . $credits . " credits.</p>";
      //toon de prijs
      echo "<p>De prijs is " . $price . " euro.</p>";
			} else {
				echo "<p>Er is een fout opgetreden. Probeer het later opnieuw.</p>";
			}
		?>

<div class="payment">

        <form action="creditsPayment.php" method="POST">
              <h3>Billing Address</h3>
              <label for="cardname">Name on Card</label>
              <input type="text" id="cardname" name="cardname">
              <label for="cardnumber">Credit card number</label>
              <input type="text" id="cardnumber" name="cardnumber">
              <label for="expmonth">Exp Month</label>
              <input type="text" id="expmonth" name="expmonth">
                  <label for="expyear">Exp Year</label>
                  <input type="text" id="expyear" name="expyear">


                  <label for="cvv">CVV</label>
                  <input type="text" id="cvv" name="cvv">
    
                
</div>
<button><a href="paymentSucces.php?credits" . $credits>Pay</a> </button>
        </div>

      
</body>
</html>
