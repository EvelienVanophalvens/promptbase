<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");
authenticated();

use Cloudinary\Cloudinary;

require 'vendor/autoload.php';


$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => 'dbbz2g87h',
        'api_key'    => '263637247196311',
        'api_secret' => 'cOrwpgG-ICTXLSYVCQJisbZb0x8',
    ],
]);





$prompts = Prompts::detailPrompt($_GET["prompt"]);
$user = User::getUser($_SESSION['userid']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Prompt</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <div class="container">
    <div class="promptBlock">
    <section class="images" >
        <?php if(!empty($prompts["examples"])) {?>
            <?php foreach($prompts["examples"] as $example):
                 $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $example["example"];?>
                <div class="imageExample">
                     <img src="<?php echo htmlspecialchars($image)?>" alt="example">  
                </div>
            <?php endforeach; ?>
        <?php } else {?>  
            <div class="imageExample">
                <img src="/uploads/default_image.png" alt="example">  
            </div>  
        <?php ;
        }?>
        </section>
        <section class="prompt">
            <div class="row">
                <h2><?php echo htmlspecialchars($prompts['prompts']->promptName)?></h2>  
                <p><?php echo htmlspecialchars($prompts["prompts"]->getPrice())?> credits</p>
            </div>
            <p><?php echo htmlspecialchars($prompts["prompts"]->getDescription())?></p>
    </div>
    <div class="overview">
        <div class="row">
            <h3>Payment overview</h3>
            <p>Price</p>
        </div>
        <div class="row">
            <p>Prompt (1)</p>
            <p><?php echo htmlspecialchars($prompts["prompts"]->getPrice())?> credits</p>
        </div>
        <div class="blue">
            <div class="row">
                <p>total</p>
                <p><?php echo htmlspecialchars($prompts["prompts"]->getPrice())?> credits</p>
            </div>
        </div>
        <form action="buySucces.php" method="POST">    <input type="hidden" name="prompt" value="<?php echo $_GET["prompt"]; ?>" /><input type="submit" value="Buy" class="right blue small"></form>
    </div>
    </div>
</body>
</html>