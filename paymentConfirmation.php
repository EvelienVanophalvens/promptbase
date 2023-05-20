<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container2">
        <h1>Payment Details</h1>
        <form method="POST" action="process_payment.php">
            <label for="name">Name on card:</label>
            <input type="text" id="name" name="name" required>
            <label for="cardnumber">Card number:</label>
            <input type="text" id="cardnumber" name="cardnumber" required>
            <label for="expiration">Expiration date:</label>
            <input type="text" id="expiration" name="expiration" placeholder="MM / YY" required>
            <label for="cvv">CVV code:</label>
            <input type="text" id="cvv" name="cvv" required>
            <label for="amount">Amount to pay:</label>
            <input type="number" id="amount" name="amount" value="25" readonly>
            <button type="submit">Pay Now</button>
        </form>
    </div>
</body>
</html>
