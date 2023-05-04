<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

authenticated();
$userId = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
var_dump($userId);
if($userId === false) {
    header("Location: home.php");
    exit;
}
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
            <h2 class="username"><?php echo htmlspecialchars($user['username'])?></h2>
            <div id="dottedMenu">
            <div class="hidden" id="promptMenu">
                <p id="reporting">report prompt</p>
            </div>
            <div id="dots">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0_45_131" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="64" height="64">
                        <rect width="64" height="64" fill="#D9D9D9"/>
                    </mask>
                    <g mask="url(#mask0_45_131)">
                        <path d="M32.0003 53.3333C30.5337 53.3333 29.2781 52.8111 28.2337 51.7666C27.1892 50.7222 26.667 49.4666 26.667 48C26.667 46.5333 27.1892 45.2777 28.2337 44.2333C29.2781 43.1889 30.5337 42.6666 32.0003 42.6666C33.467 42.6666 34.7225 43.1889 35.767 44.2333C36.8114 45.2777 37.3337 46.5333 37.3337 48C37.3337 49.4666 36.8114 50.7222 35.767 51.7666C34.7225 52.8111 33.467 53.3333 32.0003 53.3333ZM32.0003 37.3333C30.5337 37.3333 29.2781 36.8111 28.2337 35.7666C27.1892 34.7222 26.667 33.4666 26.667 32C26.667 30.5333 27.1892 29.2777 28.2337 28.2333C29.2781 27.1888 30.5337 26.6666 32.0003 26.6666C33.467 26.6666 34.7225 27.1888 35.767 28.2333C36.8114 29.2777 37.3337 30.5333 37.3337 32C37.3337 33.4666 36.8114 34.7222 35.767 35.7666C34.7225 36.8111 33.467 37.3333 32.0003 37.3333ZM32.0003 21.3333C30.5337 21.3333 29.2781 20.8111 28.2337 19.7666C27.1892 18.7222 26.667 17.4666 26.667 16C26.667 14.5333 27.1892 13.2777 28.2337 12.2333C29.2781 11.1888 30.5337 10.6666 32.0003 10.6666C33.467 10.6666 34.7225 11.1888 35.767 12.2333C36.8114 13.2777 37.3337 14.5333 37.3337 16C37.3337 17.4666 36.8114 18.7222 35.767 19.7666C34.7225 20.8111 33.467 21.3333 32.0003 21.3333Z" fill="#1C1B1F"/>
                    </g>
                </svg>
            </div>
        </div>
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