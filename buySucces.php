<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");
authenticated();

$prompts = Prompts::detailPrompt($_POST["prompt"]);
$user = User::getUser($_SESSION['userid']);

//get user id from the owner of the prompt
$userId = $prompts['prompts']->user;
//update the credits of the owner of the prompt

User::updateCreditsOwner($userId);




if(!empty($_POST)){
    $buy = User::buy($_SESSION['userid'], $prompts["prompts"]->getPrice(), $user["credits"]);
}

if($buy == true){
    Prompts::addPromptToUser($_SESSION['userid'], $_POST["prompt"]);
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy</title>
</head>
<body>
    <?php if($buy == true):?>
        <h1>Thank you for buying <?php echo htmlspecialchars($prompts['prompts']->promptName)?></h1>
        <p>You can find your prompt in your profile</p>

        <?php ?>

    <?php else:?>
        <h1>Something went wrong</h1>
        <p>Please try again</p>
    <?php endif;?>

</body>
</html>