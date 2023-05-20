<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

authenticated();

$prompts = Prompts::boughtPromptDetail($_GET["prompt"]);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your prompt</title>
</head>
<body>

    <div class="content">
    <a href="profile.php" id="backbtn">< BACK TO PROFILE</a>
        <div class="container">
            <div class="title">
                <h2><?php echo htmlspecialchars($prompts['prompts']->promptName)?></h2>  
                <div class="spacing">
                <p class="categoryLabel dark left">
                <?php if(isset($prompts['prompts']->name)) {
                    echo htmlspecialchars($prompts['prompts']->name);
                } else {
                    echo "no category";
                }?>
                </p>
                <p class="categoryLabel dark left">
                <?php if(isset($prompts['prompts']->modelName)) {
                    echo htmlspecialchars($prompts['prompts']->modelName);
                } else {
                    echo "no model";
                }?>
                </p>
                </div>
            </div>
        </div>
        <div class="promptPromptInfo">
                    <p class="title">
                        <h3>Description</h3>
                    </p>
                    <p class="half"><?php echo htmlspecialchars($prompts["prompts"]->getDescription());?></p>
                    <p class="title">
                        <h3>Prompt</h3>
                    </p>
                    <p class="half"><?php echo htmlspecialchars($prompts["prompts"]->getPrompt());?></p>
                </div> 
        <section id="exampleBox">
            <?php if(!empty($prompts["examples"])) {?>
                <?php foreach($prompts["examples"] as $example):?>
                    <div class="imageExample">
                            <img src="<?php echo "uploads/".htmlspecialchars($example["example"])?>" alt="example">  
                    </div>
                <?php endforeach; ?>
            <?php } else {?>  
                <div class="imageExample">
                    <img src="/uploads/default_image.png" alt="example">  
                </div>  
            <?php ;
            }?>
            </section>
            <section class="leftContainer" >
                <div class="promptUserInfo">
                    <div class="half">
                        <a href="accountView.php?user=<?php echo htmlspecialchars($prompts['prompts']->user)?>" ><p><strong>Made by </strong><?php echo htmlspecialchars($prompts['prompts']->username)?> </p></a>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($prompts["prompts"]->getdate())?></p>
                    </div>
                </div>
            
            </section>
    </div>
</body>
</html>