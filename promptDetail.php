<?php 
    include_once(__DIR__."/bootstrap.php");
    include_once (__DIR__."/navbar.php");

    authenticated();
    $prompt =  Prompts::detailPrompt($_GET["prompt"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>promptdetail</title>
</head>
<body>
    <div class="content">
        <a href="home.php" id="backbtn">< BACK TO OVERVIEW</a>
        <h2><?php echo $prompt["prompts"]["prompt"]?></h2>
        <div>
            <p class="title">examples</p>
            <div class="img">
            <?php foreach($prompt["examples"] as $example):?>
                <img scr = "<?php echo $example["example"]?>" >
            <?php endforeach; ?>
            </div>
        </div>
        <div>
            <p class="title">Made by: <?php echo $prompt["prompts"]["username"]?> </p>
            <p class="title">Date: <?php echo $prompt["prompts"]["date"]?></p>
        </div>      
    </div>
</body>
</html>