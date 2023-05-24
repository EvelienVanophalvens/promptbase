<?php 
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
  <div class="content">
<a href="profileSettings.php" id="backbtn">< BACK TO OVERVIEW</a>
</div>
    <div class="container2">
        <h1>Buy credits</h1>
        <form action="creditsPayment.php">
           <div class="form-group">
                <label id="buy" for="credits">Choose the amount of credits you want to buy</label>
                <div class="Credits">
                <div class="creditschoice">
  <img class="creditsImg" src="uploads/credits.png" alt="credits">
  <div class="credit">
    <h2>25 credits</h2>
    <div class="price">
      <h4>Prijs: €10</h4>
    </div>
                  
    <a id="credit" href="creditsPayment.php?credits=25">Buy credits</a>
  </div>
</div>
<div class="creditschoice">
  <img class="creditsImg" src="uploads/credits.png" alt="credits">
  <div class="credit">
    <h2>50 credits</h2>
    <h4>Prijs: €35</h4>
    <a id="credit" href="creditsPayment.php?credits=50">Buy credits</a>
  </div>
</div>
<div class="creditschoice">
  <img class="creditsImg" src="uploads/credits.png" alt="credits">
  <div class="credit">
    <h2>100 credits</h2> 
    <h4>Prijs: €85</h4>
    <a id="credit" href="creditsPayment.php?credits=100">Buy credits</a>
  </div>
</div>

            </div>
            </div>
            <div class="form-element">
                
            </div>
        </form>
    </div>
</body>
</html>