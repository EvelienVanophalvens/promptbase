<?php
include_once(__DIR__."/../bootstrap.php");
if(!empty($_POST) && isset($_POST["accept"])) {
    Prompts::acceptPrompt($_POST["id"]);
    User::earnCredits($userId);
    header("Location: promptsM.php");
} elseif(!empty($_POST) && isset($_POST["reject"])) {
    Prompts::rejectPrompt($_POST["id"]);
    $Notifications = new Notifications();
    $Notifications->setReceiverId($prompt["prompts"]["user"]);
    $Notifications->setTitle("Prompt rejected");
    $Notifications->setMessage("Your prompt has been rejected, you can edit it and resubmit it if you want to. You can do this by <a href='http://localhost/promptbase/editPrompt.php?prompt=".$prompt["prompts"]["id"]."'>clicking here</a>.");

    $Notifications->saveRejectNotifiction();    
    header("Location: promptsM.php");
}
include_once(__DIR__."/navbarM.php");

require_once(__DIR__ . '/../vendor/autoload.php');

use Cloudinary\Cloudinary;


$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => 'dbbz2g87h',
        'api_key'    => '263637247196311',
        'api_secret' => 'cOrwpgG-ICTXLSYVCQJisbZb0x8',
    ],
]);


$prompt = Prompts::detailPromptM($_GET["prompt"]);
if ($prompt) {
    $userId = $prompt["prompts"]["userId"];
    // Doe iets met $userId

} else {
    // Doe iets anders als $prompt false is
    echo "mislukt";
}


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
        <a href="promptsM.php" id="backbtn">< BACK TO OVERVIEW</a>
        <?php if(!empty($message)):?><p><?php echo $message ?></p><?php endif?>
        <?php if(!empty($error)):?><p><?php echo $error ?></p><?php endif;?>
        <div class="container">
        <div class="title">
            <h2><?php echo htmlspecialchars($prompt["prompts"]["title"])?></h2>  
            <p class="categoryLabel dark left">
            <?php if(isset($prompt["prompts"]["category"])) {
                echo htmlspecialchars($prompt["prompts"]["category"]);
            } else {
                echo "no category";
            }?>
            </p>
            <br>
        </div>
        <form method="POST">
        </div>
        <section id="exampleBox">
        <?php if(!empty($prompt["examples"])) {?>
            <?php foreach($prompt["examples"] as $example):?>
                <div class="imageExample">
                    <div class="img">
                    <?php foreach($prompt["examples"] as $example):
                        $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $example["example"];?>
                        <img src = "<?php echo $image?>" >
                    <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php } else {?>  
            <div class="imageExample">
                <img src="/uploads/default_image.png" alt="example">  
            </div>  
        <?php ;
        }?>
        </section>
        <div class="container">
        <section class="leftContainer" >
            <div class="promptUserInfo">
                <div class="half">
                    <p><strong>Made by </strong><a href="../accountView.php?user=<?php echo htmlspecialchars($prompt['prompts']["userId"])?>" ><?php echo htmlspecialchars($prompt['prompts']['username'])?></a></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($prompt["prompts"]["date"])?></p>
                </div>
            </div>
            <div class="promptPromptInfo">
                <p class="title">
                    <h3>Description</h3>
                </p>
                <p class="half"><?php echo htmlspecialchars($prompt["prompts"]["description"]);?></p>
             </div>  
        </section>
        <section class="rightContainer">
            <div>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($prompt["prompts"]["id"])?>">
                <input type="submit" name="accept" value="accept">
                <input type="submit" name="reject" value="don't accept">
            </div>
        </section>    
        </div>        

    </div>
    </div>
    </form>
</body>
</html>