<?php
    include_once(__DIR__."/bootstrap.php");
    include_once (__DIR__."/navbar.php");

    authenticated();

    $user = User::getUser($_GET["user"]);

    $prompts = Prompts::getUserPrompts($user["id"]);

    $allExamples = [];
    
    foreach($prompts as $prompt){
        $examples = Prompts::getPromptsExamples($prompt["id"]);
        $allExamples[$prompt["id"]] = $examples;
    }


    $profilePicturePath = "uploads/".$user["profilePicture"];



 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hello</title>
</head>
<body>
<div class="context">
        <div class="userinfo">
           <div id="userProfilePicture">
                <img src="<?php echo htmlspecialchars($profilePicturePath)?>" alt="profile picture">
            </div>
            <h2 class="username"><?php echo htmlspecialchars($_SESSION['auth_user']['username'])?></h2>
                <p id="bio-text"><?php echo htmlspecialchars($user["bio"]); ?></p>
        </div>  
        <div class="userPrompts">Hier komen de gemaakte prompts
        <h3>Newest prompts</h3>
        <hr>
            <div class="chartContainer">
                <?php if(!empty($prompts)){ foreach($prompts as $prompt):?>
                    <div class="chart">
                        <div class="promptInfo">
                            <a href="promptDetail.php?prompt=<?php echo $prompt["id"]?>">
                            <p><?php echo htmlspecialchars($prompt["promptName"])?></p>
                            </a>
                            <div class="categoryLabel"><?php echo htmlspecialchars($prompt["name"])?></div>
                        </div>
                        <div class="coverImage">
                            <?php if(!empty($allExamples)){?>
                                <?php foreach($allExamples[$prompt["id"]] as $example):?>
                                        <img class="imageExample" src="<?php echo "uploads/".htmlspecialchars($example["example"])?>" alt="coverImage">
                                <?php endforeach; ?>
                            <?php ;}else{?>
                                <img src="uploads/<?= htmlspecialchars($prompt['prompt']); ?>" alt="prompt">
                            <?php ;}?>
                    </div>
                </div>
                <?php endforeach; }  ?>

        </div>
</body>
</html>