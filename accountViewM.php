<?php
include_once(__DIR__."/bootstrap.php");
authenticated();
$userId = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
if($userId === false) {
    header("Location: index.php");
    exit;
}
include_once(__DIR__."/navbar.php");

use Cloudinary\Cloudinary;

require 'vendor/autoload.php';


$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => 'dbbz2g87h',
        'api_key'    => '263637247196311',
        'api_secret' => 'cOrwpgG-ICTXLSYVCQJisbZb0x8',
    ],
]);



$user = User::getUser($userId);
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
if(!empty($_POST["reason"]) && isset($_POST["report"])) {
    try{
    $report = new ReportsUser();
    $report->setUserId($_GET["user"]);
    $report->setReason($_POST["reason"]);
    $report->save();
    $message = "Your report has been sent";        
    } catch(Throwable $e) {
        $error = $e->getMessage();
        var_dump($error);
    }
}

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
<div class="profileContext">
        <div class="userinfo">
           <div id="userProfilePicture">
                <img src="<?php echo htmlspecialchars($profilePicturePath)?>" alt="profile picture">
            </div>
            <div class="user">
                <h2 class="username"><?php echo htmlspecialchars($user['username'])?></h2>
            </div>
                <p id="bio-text"><?php echo htmlspecialchars($user["bio"]); ?></p>
                <button id="followButton" class="submit small follow" onclick="toggleFollow()"><a href="#">Follow</a></button>
        </div>  
        <div class="userPrompts"><!--Hier komen de gemaakte prompts-->
            <h3>Made prompts</h3>
            <hr>
            <div class="chartContainer">
                <?php if(!empty($prompts)) {
                   foreach($prompts as $prompt):
                    $example = Prompts::getPromptExample($prompt["id"]);
                    $picture = $example["example"];?>
                    <div class="chart">
                        <a href="promptDetail.php?prompt=<?php echo $prompt["id"];?>"> 
                            <div class="coverImage">
                                <?php if(!empty($picture)) {
                                    $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $picture;?>
                                    <img src="<?php echo $image?>" alt="coverImage">
                                <?php } else {?>
                                    <img src="uploads/default_image.png" alt="example">
                                <?php }?>
                            </div>
                            <div class="promptInfo">
                                <?php if(isset($prompt["promptName"])) {
                                    echo htmlspecialchars($prompt["promptName"]);
                                }?>  
                                <div class="categoryLabel">
                                    <?php if(isset($prompt["name"])) {
                                        echo htmlspecialchars($prompt["name"]);
                                    } else {
                                        echo "no category";
                                    }?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach;
                }  ?>
            </div>
            <form action="" method="POST" class= "middleForm">
                <h2>You want to rapport this user</h2>
                <label for="reason">reason</label>
                <textarea name="reason" id="reason" placeholder="Type here your reason"></textarea>
                <input type="hidden" name="report"  value="<?php echo $user["id"]?>">
                <div class="form-element">
                    <button type="submit" name="report" class="submit small">Send</button>
                    <button type="submit" class="submit small" id="cancel">cancel</button>
                </div>
            </form>
</body>

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
    document.querySelector('#dots').addEventListener('click', function(e){
        e.preventDefault();
        document.querySelector('#promptMenu').classList.toggle('hidden');
        console.log("e");
    });
    let report = false;
    document.querySelector('#promptMenu #reporting').addEventListener('click', function(e){
        e.preventDefault();
        console.log("x");
        document.querySelector('.profileContext').classList.add('faded');
        document.querySelector(".middleForm").style.transform = "translate(-50%, -50%)";
        report = true;
    });
</script>

</html>