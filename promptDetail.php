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
        <div class="title">
            <h2><?php echo $prompt["prompts"]["promptName"]?></h2>
            <p class="categoryLabel dark left"><?php echo $prompt["prompts"]["name"]?></p>
            <br>
        </div>
        <section id="exampleBox">
            <?php foreach($prompt["examples"] as $example):?>
                <div class="imageExample">
                    <img scr="<?php echo $example;?>" alt="example">
                </div>
            <?php endforeach; ?>
        </section>
        <div class="promptUserInfo">
            <div class="subInfo">
                <p><strong>Made by </strong><?php echo $prompt["prompts"]["username"]?> </p>
                <p><strong>Date:</strong> <?php echo $prompt["prompts"]["date"]?></p>
            </div>
            <p class="likes">
                Likes 
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402m5.726-20.583c-2.203 0-4.446 1.042-5.726 3.238-1.285-2.206-3.522-3.248-5.719-3.248-3.183 0-6.281 2.187-6.281 6.191 0 4.661 5.571 9.429 12 15.809 6.43-6.38 12-11.148 12-15.809 0-4.011-3.095-6.181-6.274-6.181"/></svg>
            </p>
        </div>      
    </div>
</body>
</html>