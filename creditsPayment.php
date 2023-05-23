<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

$credits = $_GET['credits'];

//add the credits to the database
if(!empty($_POST)) {
  $credits = $_POST['credits'];
  $update = User::updateCredits($credits);
}
 // Controleer of de credits parameter is doorgegeven in de URL
 if(isset($_GET['credits'])) {
  $credits = $_GET['credits'];
  $melding =  "<p class='statement'>U koopt <strong>" . $credits . " </strong> credits.</p>";
} else {
  $melding =  "<p class='statement error'>Er is een fout opgetreden. Probeer het later opnieuw.</p>";
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
              <input type="text" id="cardname" name="cardname"><br>
              <label for="cardnumber">Credit card number</label>
              <input type="text" id="cardnumber" name="cardnumber"><br>
              <label for="expmonth">Exp Month</label>
              <input type="text" id="expmonth" name="expmonth"><br>
              <label for="expyear">Exp Year</label>
              <input type="text" id="expyear" name="expyear"><br>
              <label for="cvv">CVV</label>
              <input type="text" id="cvv" name="cvv">
              <button class="submit">Pay</button>
        </form>
      </div>
  </div>
</div>
      
</body>
</html>
