<?php 
    include_once(__DIR__."/../bootstrap.php");
    include_once(__DIR__."/navbarM.php");
    if( User::isAdmin() === false){
        header("Location: ../error.php");
        echo "you are not a moderator";
    }

    $prompt = Prompts::detailPromptM($_GET["prompt"]);
    if(!empty($_POST) && isset($_POST["accept"])){
        Prompts::acceptPrompt($_POST["id"]);
        header("Location: promptsM.php");
    }elseif(!empty($_POST) && isset($_POST["reject"])){
        Prompts::rejectPrompt($_POST["id"]);
        header("Location: promptsM.php");
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
    <h2>prompt details</h2>
    <form class="promptDetails" method="POST">
        <div>
            <p class="title">prompt</p>
            <p><?php echo htmlspecialchars($prompt["prompts"]["prompt"])?></p>
        </div>
        <div>
            <p class="title">user</p>
            <p><?php echo htmlspecialchars($prompt["prompts"]["username"])?></p>
        </div>
        <div>
            <p class="title">date</p>
            <p><?php echo htmlspecialchars($prompt["prompts"]["date"])?></p>
        </div>
        <div>
            <p class="title">examples</p>
            <div class="img">
            <?php foreach($prompt["examples"] as $example):?>
            <img src = "<?php echo "../uploads/".htmlspecialchars($example["example"])?>" >

            <?php endforeach; ?>
        </div>
        </div>
        
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($prompt["prompts"]["id"])?>">
        <div>
        <input type="submit" name="accept" value="accept">
        <input type="submit" name="reject"value="don't accept">
        </div>
    </form>
</body>
</html>