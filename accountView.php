<?php
include_once(__DIR__."/bootstrap.php");
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


authenticated();
$userId = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
if($userId === false) {
    header("Location: index.php");
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


// ...

$isFollowing = false; // Initialize the variable




// Check if the authenticated user is following the displayed user
if (authenticated()) {
    $loggedInUserId = $_SESSION['userid'];
    // Assuming you have a function to get the ID of the logged-in user
    $isFollowing = User::isFollowingUser($loggedInUserId, $userId);
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
            <div  class="user">
            <h2 class="username"><?php echo htmlspecialchars($user['username'])?></h2>
            <div id="dottedMenu">
                    <div class="hidden" id="promptMenu">
                        <p id="reporting">report user</p>
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
                </div>
                <p id="bio-text"><?php echo htmlspecialchars($user["bio"]); ?></p>
                <button id="follow-btn"><?php echo $isFollowing ? 'Unfollow' : 'Follow'; ?></button>


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
        </div>
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
  
  let follow = document.querySelector('#follow-btn');
let userId = <?php echo $user["id"]; ?>;

// Check if the follow status is stored in local storage
let followStatus = localStorage.getItem('followStatus-' + userId);
if (followStatus === 'unfollow') {
  follow.innerHTML = 'Unfollow';
  follow.style.backgroundColor = '#1F2937';
}

follow.addEventListener('click', function(e) {
  e.preventDefault();
  let formData = new FormData();
  formData.append('userId', userId);
  fetch('ajax/follow.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(result => {
      console.log(result);
      if (result.status === 'success') {
        if (follow.innerHTML === 'Follow') {
          follow.innerHTML = 'Unfollow';
          follow.style.backgroundColor = '#1F2937';
          // Store the follow status in local storage
          localStorage.setItem('followStatus-' + userId, 'unfollow');
        } else {
          follow.innerHTML = 'Follow';
          follow.style.backgroundColor = '#0099CB';
          // Remove the follow status from local storage
          localStorage.removeItem('followStatus-' + userId);
        }
      }
    });
});


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