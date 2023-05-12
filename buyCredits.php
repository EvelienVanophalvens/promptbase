// Purpose: Buy credits to get more prompts
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <div class="container2">
        <h1>Buy credits</h1>
        <p>You can buy credits to get more prompts</p>
        <form action="">
           <div class="form-group">
                <label for="credits">Choose the amount of credits you want to buy</label>
                <button type="submit" id="submit" name="buyCredits">
                    25 credits
                </button>
                <button type="submit" id="submit" name="buyCredits">
                    50 credits
                </button>
                <button type="submit" id="submit" name="buyCredits">
                    100 credits
                </button>
            </div>
            <div class="form-element">
                <label for="payment">Choose your payment method</label>
                <select name="payment" id="payment" required>
                    <option value="visa">Visa</option>
                    <option value="mastercard">Mastercard</option>
                    <option value="paypal">Paypal</option>
                </select>
            </div>
            <div class="form-element">
                <button type="submit" id="submit" name="buyCredits">
                    Buy credits
                </button>
            </div>
        </form>
    </div>
</body>
</html>