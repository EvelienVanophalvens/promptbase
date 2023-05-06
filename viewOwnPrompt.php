<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

authenticated();
$prompt =  Prompts::detailPrompt($_GET["prompt"]);


$comment = Prompts::getAllComments($_GET["prompt"]);


if(!empty($_POST["reason"])) {
    try{
    $report = new Reports();
    $report->setPromptId($_GET["prompt"]);
    $report->setUserId($_SESSION["userid"]);
    $report->setReason($_POST["reason"]);
    $report->save();
    $message = "Your report has been sent";        
    } catch(Throwable $e) {
        $error = $e->getMessage();
        var_dump($error);
    }
}

$userId = $_SESSION['userid'];
$promptId = $_GET["prompt"];


if(!empty($_POST) && isset($_POST["delete"])){
        Prompts::delete($_GET["prompt"]);
        header("Location: profile.php");
}




$favourites = Prompts::addFavoritePrompt($userId, $promptId);
//$favourites = Prompts::removeFavoritePrompt($userId, $promptId);



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
        <a href="profile.php" id="backbtn">< BACK TO ACCOUNT</a>
        <?php if(!empty($message)):?><p><?php echo $message ?></p><?php endif?>
        <?php if(!empty($error)):?><p><?php echo $error ?></p><?php endif;?>
        <div class="container">
        <div class="title">
            <h2><?php echo htmlspecialchars($prompt['prompts']->promptName)?></h2>  
            <p class="categoryLabel dark left">
            <?php if(isset($prompt["name"])) {
                echo htmlspecialchars($prompt["prompts"]["name"]);
            } else {
                echo "no category";
            }?>
            </p>
            <br>
        </div>
        <div id="dottedMenu">
            <div class="hidden" id="promptMenu">
                <p id="reporting">Delete this prompt</p>

            </div>
            <div id="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
        </div>
        <section id="exampleBox">
        <?php if(!empty($prompt["examples"] && $prompt["examples"] === true)) { ?>
            <?php foreach($prompt["examples"] as $example):?>
                <div class="imageExample">
                        <img src="<?php echo "uploads/".htmlspecialchars($example["example"])?>" alt="example">  
                </div>
            <?php endforeach; ?>
        <?php } else {?>  
            <div class="imageExample">
                <img src="uploads/default_image.png" alt="example">  
            </div>  
        <?php ;
        }?>
        </section>
        <div class="container">
        <section class="leftContainer" >
            <div class="promptUserInfo">
                <div class="half">
                    <a href="accountView.php?user=<?php echo htmlspecialchars($prompt['prompts']->user)?>" ><p><strong>Made by </strong><?php echo htmlspecialchars($prompt['prompts']->username)?> </p></a>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($prompt["prompts"]->getdate())?></p>
                </div>
            </div>
            <div class="promptPromptInfo">
                <p class="title">
                    <h3>Description</h3>
                </p>
                <p class="half"><?php echo htmlspecialchars($prompt["prompts"]->getDescription());?></p>
             </div> 
            <div class="commentsection">
                <p class="title">
                    <h3>What others think</h3>
                </p>
                <?php foreach($comment as $comment):?>
                    <div class="comment half">
                        <p><strong><?php echo htmlspecialchars($comment["username"]);?></strong></p>
                        <p><?php echo htmlspecialchars($comment["comment"]);?></p>
                    </div>
                    <br>
                <?php endforeach; ?>
            </div>
            <form id="comment-form" method="POST">
                    <div class="title">
                        <h4>Hi <?= htmlspecialchars($_SESSION['auth_user']['username']); ?>, what do you think?</h4>
                    </div>
                    <div class="form-element">
                        <input id="comment" name="comment" type="text" autocomplete="comment" placeholder="Comment here"></input>
                    </div>
                    <div class="form-element">
                        <button type="submit" class="submit small" name="post_comment">
                            Send
                        </button>
                    </div>
                </form>
        </section>
        <section class="rightContainer">
            <div class='likes dark'>
                <svg class="whiteSvg" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402m5.726-20.583c-2.203 0-4.446 1.042-5.726 3.238-1.285-2.206-3.522-3.248-5.719-3.248-3.183 0-6.281 2.187-6.281 6.191 0 4.661 5.571 9.429 12 15.809 6.43-6.38 12-11.148 12-15.809 0-4.011-3.095-6.181-6.274-6.181"/></svg>
                <p data-id="<?php echo $prompt["prompts"]->getId(); ?>" class = "like">
                    <span class='like' id = "counter" ><?php echo Prompts::getPromptLike($prompt["prompts"]->getId()); ?></span>
                    Likes 
                </p>
            </div>
            <button class="submit small">Edit Prompt</button>
        </section>    
        </div>        

    </div>     
    
    <form action=""  method="POST" class= "middleForm">
            <h2>You want to delete prompt <?php  echo htmlspecialchars($prompt['prompts']->promptName)?> </h2>
            <p>Are you sure?</p>
            <div class="form-element">
                <button type="submit" name="delete" class="submit small">Yes</button>
                <button type="submit" name="cancel" class="submit small" id="cancel">No</button>
            </div>
        </form>
                
    <script>
       const commentForm = document.getElementById('comment-form');
        const commentInput = document.getElementById('comment');

        commentForm.onsubmit = (e) => {
            // Voorkomt standaard verzending van het formulier
            e.preventDefault(); 
            // Maak een nieuw AJAX-verzoek
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Succesvol AJAX-verzoek
                    const response = JSON.parse(xhr.responseText);
                    //Het maken van een nieuwe comment begint hier
                    const commentSection = document.querySelector('.commentsection');
                    const newComment = document.createElement('div');
                    newComment.className = 'comment half';
                    //De user toekennen
                    const userParagraph = document.createElement('p');
                    const lastCommentIndex = response.length - 1;
                    const comment = response[lastCommentIndex];
                    userParagraph.innerHTML = `<strong>${comment.username}</strong>`;
                    newComment.appendChild(userParagraph);
                    //De comment zelf toekennen
                    const commentParagraph = document.createElement('p');
                    commentParagraph.innerHTML = comment.comment;
                    newComment.appendChild(commentParagraph);
                    commentSection.appendChild(newComment);
                    // voeg hier een nieuw <br> element toe
                    commentSection.appendChild(document.createElement('br'));
                    // Leeg het invoerveld
                    commentInput.value = '';
                }
            }
            // AJAX-verzoek naar deze URL
            xhr.open('POST', 'post-comment.php');
            // Stel het inhoudstype in op JSON
            xhr.setRequestHeader('Content-Type', 'application/json');
            // Gegevens die naar de server worden verzonden
            const data = {comment: commentInput.value, prompt: <?php echo $_GET["prompt"]; ?>};
            // Verzend het AJAX-verzoek met de gegevens
            xhr.send(JSON.stringify(data));
        };


        //add click event to a.like
	let likes = document.querySelectorAll('.like');
	for(let i = 0; i < likes.length; i++){
		likes[i].addEventListener('click', function(e){
			e.preventDefault();
			//get the id of the post
			let id = this.getAttribute('data-id');
            console.log(id);
			//get the counter
			let counter = document.querySelector('#counter');
			//fetch request (post) to '/ajax/like.php', use formdata
			let formData = new FormData();
			formData.append('promptId', id);
			fetch('./ajax/likes.php', {
				method: 'POST',
				body: formData
			})
			.then(function(response){
				return response.json();
			})
			.then(function(data){
				//update the counter
				counter.innerHTML = data.likes;
			})
		});
	}

    document.querySelector('#dots').addEventListener('click', function(e){
        e.preventDefault();
        document.querySelector('#promptMenu').classList.toggle('hidden');
        console.log("e")
    });

    let report = false

    document.querySelector('#promptMenu #reporting').addEventListener('click', function(e){
        e.preventDefault();
        document.querySelector('.content').classList.add('faded');
        document.querySelector(".middleForm").style.transform = "translate(-50%, -50%)";
        report = true;
    });

    function saveToFavourites(userId, promptId) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "saveToFavourites.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var response = xhr.responseText;
      // Display a success message or handle errors here
      if (response == "success") {
        // Do something, like showing a confirmation message
        alert("prompt saved");
      } else {
        // Do something else, like showing an error
        alert("prompt not saved");
      }
      
    }
  };
  xhr.send("userId=" + userId + "&promptId=" + promptId);
}

document.querySelector("#cancel").addEventListener('click', function(e){
    e.preventDefault();
    document.querySelector('.content').classList.remove('faded');
    document.querySelector(".middleForm").style.transform = "translate(50%, 150%)";
    report = false;
});




</script>
</body>
</html>