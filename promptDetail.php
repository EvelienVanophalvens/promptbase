<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

authenticated();
$prompt =  Prompts::detailPrompt($_GET["prompt"]);
$comment = Comment::getAllComments($_GET["prompt"]);


if(!empty($_POST["reason"]) && isset($_POST["report"])) {
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



$isFavorite = Prompts::isPromptFavorited($userId, $promptId);

if ($isFavorite) {
  $favourites = Prompts::removeFavoritePrompt($userId, $promptId);
} else {
  $favourites = Prompts::addFavoritePrompt($userId, $promptId);
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
        <a href="home.php" id="backbtn">< BACK TO OVERVIEW</a>
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
                <p id="reporting">report prompt</p>
                <p id="favourites"><a href="#" class="save-favourite-link" onclick="event.preventDefault(); document.getElementById('add-favorite-form').submit();">
  <?php echo $isFavorite ? 'Remove from favourites' : 'Save as favourite'; ?>
</a>
</p>

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
        <section id="exampleBox">
        <?php if(!empty($prompt["examples"])) {?>
            <?php foreach($prompt["examples"] as $example):?>
                <div class="imageExample">
                        <img src="<?php echo "uploads/".htmlspecialchars($example["example"])?>" alt="example">  
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
                        <input id="comment" name="comment" type="text" autocomplete="comment" placeholder="Comment here" data-id="<?php echo $promptId?>"></input>
                    </div>
                    <div class="form-element">
                        <button type="submit" class="submit small" name="post_comment" id="postComment">
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
            <button class="submit small"><a href="buyPrompt.php?prompt=<?php echo $prompt["prompts"]->getId()?>">Get prompt</a></button>
        </section>    
        </div>        

    </div>     
    
    <form action=""  method="POST" class= "middleForm">
            <h2>You want to rapport prompt <?php  echo htmlspecialchars($prompt['prompts']->promptName)?> </h2>
            <label for="reason">reason</label>
            <textarea name="reason" id="reason" placeholder="Type here your reason"></textarea>
            <input type="hidden" name="report"  value="<?php echo $prompt["prompts"]->getId()?>">
            <div class="form-element">
                <button type="submit" name="report" class="submit small">Send</button>
                <button type="submit" class="submit small" id="cancel">cancel</button>
            </div>
        </form> 
    <script>
        const commentForm = document.getElementById('comment-form');
        const sendBtn = document.getElementById('postComment');
        const commentInput = document.getElementById('comment');

        commentForm.onsubmit = (e) => {
            // Voorkomt standaard verzending van het formulier
            e.preventDefault(); 
            console.log("You submitted");
            // Maak een nieuwe FormData object
            let formData = new FormData();
            //get the id of the post
            let id = commentInput.getAttribute('data-id');
            let comment = commentInput.value;
            console.log("id:", id);
            console.log("comment:", comment);
            formData.append('promptId', id);
            formData.append('comment', comment);
            // Maak een Fetch-verzoek naar comment.php
            fetch('./comment.php', {
                method: 'POST',
                body: formData
            })
            .then(function(response){
                return response.json();
            })
            .then(function(data){
                //Het maken van een nieuwe comment begint hier
                const commentSection = document.querySelector('.commentsection');
                const newComment = document.createElement('div');
                newComment.className = 'comment half';
                //De user toekennen
                const userParagraph = document.createElement('p');
                const lastCommentIndex = data.comments.length - 1;
                const comment = data.comments[lastCommentIndex];
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
            })
            .catch(function(error) {
                console.log('Er is een fout opgetreden: ' + error.message);
            });
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
                .then(liked = true)
        
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