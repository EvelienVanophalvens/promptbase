<?php 
    include_once(__DIR__."/bootstrap.php");
    include_once (__DIR__."/navbar.php");

    authenticated();
    
    $prompt =  Prompts::detailPrompt($_GET["prompt"]);
    $comment = Prompts::getAllComments($_GET["prompt"]);
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
        <div class="title">
            <h2><?php echo $prompt["prompts"]["promptName"]?></h2>
            <p class="categoryLabel dark left"><?php echo $prompt["prompts"]["name"]?></p>
            <br>
        </div>
        <section id="exampleBox">
            <?php foreach($prompt["examples"] as $example):?>
                <div class="imageExample">
                    <img scr="<?php echo $example;?>" alt="example">
                </div>
            <?php endforeach; ?>
        </section>
        <div class="promptUserInfo">
            <div class="half">
                <p><strong>Made by </strong><?php echo $prompt["prompts"]["username"]?> </p>
                <p><strong>Date:</strong> <?php echo $prompt["prompts"]["date"]?></p>
            </div>
            <p class="likes">
                Likes 
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402m5.726-20.583c-2.203 0-4.446 1.042-5.726 3.238-1.285-2.206-3.522-3.248-5.719-3.248-3.183 0-6.281 2.187-6.281 6.191 0 4.661 5.571 9.429 12 15.809 6.43-6.38 12-11.148 12-15.809 0-4.011-3.095-6.181-6.274-6.181"/></svg>
            </p>
        </div>
        <div class="promptPromptInfo">
            <p class="title">
                <h3>Description</h3>
            </p>
            <p class="half"><?php echo $prompt["prompts"]["description"];?></p>
            <button class="submit small">Get prompt</button>
        </div> 
        <div class="commentsection">
            <p class="title">
                <h3>What others think</h3>
            </p>
            <?php foreach($comment as $comment):?>
                <div class="comment half">
                    <p><strong><?php echo $comment["username"];?></strong></p>
                    <p><?php echo $comment["comment"];?></p>
                </div>
                <br>
            <?php endforeach; ?>
        </div>
            <form id="comment-form" method="POST">
                <div class="title">
                    <h4>Hi <?= $_SESSION['auth_user']['username']; ?>, what do you think?</h4>
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
        </div>     
    </div>
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
</script>
</body>
</html>