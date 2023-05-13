<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");


?><!DOCTYPE html>
<html>
<head>
	<title>Betaalpagina</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<a href="buyCredits.php" id="backbtn">< BACK TO OVERVIEW</a>

	<h1>Betaalpagina</h1>
    <?php
			// Controleer of de credits parameter is doorgegeven in de URL
			if(isset($_GET['credits'])) {
				$credits = $_GET['credits'];
				echo "<p>U koopt " . $credits . " credits.</p>";
			} else {
				echo "<p>Er is een fout opgetreden. Probeer het later opnieuw.</p>";
			}
		?>

<p>Klik op de onderstaande knop om uw betaling te voltooien.</p>
<form action="paymentConfirmation.php" method="post">
    <button>Pay with Card</button>
</form>

        
</body>
</html>
