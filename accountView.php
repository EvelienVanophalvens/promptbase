<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

authenticated();

$user = User::getUser($_GET["user"]);

$prompts = Prompts::getUserPrompts($user["id"]);

$allExamples = [];

foreach($prompts as $prompt) {
    $examples = Prompts::getPromptsExamples($prompt["id"]);
    $allExamples[$prompt["id"]] = $examples;
}
//get the profile picture from the database
if(!empty($user["profilePicture"])) {
    $profilePicturePath = "uploads/".$user["profilePicture"];
} else {
    $profilePicturePath = "uploads/default_profile.png";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hello</title>
    <script>
    function toggleFollow() {
        var button = document.getElementById("followButton");
        
        if(button.classList.contains("follow")) {
            button.classList.remove("follow");
            button.classList.add("unfollow");
            button.innerHTML = "<a href='#'>Unfollow</a>";
            button.style.backgroundColor = "#1F2937 ";
            button.style.color = "white";
        } else {
            button.classList.remove("unfollow");
            button.classList.add("follow");
            button.innerHTML = "<a href='#'>Follow</a>";
            button.style.backgroundColor = "#008CBA";
            button.style.color = "white";
        }

    }


</script>

</head>
<body>
<div class="profileContext">
        <div class="userinfo">
           <div id="userProfilePicture">
                <img src="<?php echo htmlspecialchars($profilePicturePath)?>" alt="profile picture">
            </div>
            <h2 class="username"><?php echo htmlspecialchars($user['username'])?></h2>
                <p id="bio-text"><?php echo htmlspecialchars($user["bio"]); ?></p>
                <button id="followButton" class="submit small follow" onclick="toggleFollow()"><a href="#">Follow</a></button>


        </div>  
        <div class="userPrompts"><!--Hier komen de gemaakte prompts-->
            <h3>Made prompts</h3>
            <hr>
            <div class="chartContainer">
                <?php if(!empty($prompts)) {
                    foreach($prompts as $prompt):?>
                    <div class="chart">
                        <div class="promptInfo">
                            <a href="promptDetail.php?prompt=<?php echo $prompt["id"]?>">
                            <p><?php echo htmlspecialchars($prompt["promptName"])?></p>
                            </a>
                            <div class="categoryLabel">
                                <?php if(isset($prompt["name"])) {
                                    echo htmlspecialchars($prompt["name"]);
                                } else {
                                    echo "no category";
                                }?>
                            </div>
                        </div>
                        <div class="coverImage">
                            <?php if(!empty($allExamples)) {?>
                                <?php foreach($allExamples[$prompt["id"]] as $example):?>
                                        <img class="imageExample" src="<?php echo "uploads/".htmlspecialchars($example["example"])?>" alt="coverImage">
                                <?php endforeach; ?>
                            <?php ;
                            } elseif(!($prompt['prompt'] == NULL)) { ?>
                                <img src="uploads/<?= htmlspecialchars($prompt['prompt']); ?>" alt="prompt">
                            <?php ;
                            } else {?>
                                <img src="uploads/default_image.png" alt="default img">
                            <?php ;
                            }?>
                        </div>
                    </div>
                    <?php endforeach;
                }  ?>
            </div>
</body>
</html>