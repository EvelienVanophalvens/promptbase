<?php
include_once(__DIR__."/../bootstrap.php");
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
    //var_dump($userId);

} else {
    // Doe iets anders als $prompt false is
    echo "mislukt";
}

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
        <h2>Prompt details</h2>
        <form class="promptDetails" method="POST">
            <div>
                <p class="title">prompt</p>
                <p><?php echo htmlspecialchars($prompt["prompts"]["title"])?></p>
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
                <?php foreach($prompt["examples"] as $example):
                    $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $example["example"];?>
                <img src = "<?php echo $image?>" >

                <?php endforeach; ?>
            </div>
            </div>
            
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($prompt["prompts"]["id"])?>">
            <div>
            <input type="submit" name="accept" value="accept">
            <input type="submit" name="reject"value="don't accept">
            </div>
        </form>
    </div>
</body>
</html>