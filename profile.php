<?php
    include_once(__DIR__."/bootstrap.php");    
    include_once (__DIR__."/navbar.php");
    authenticated();

    $error = "";
    if(!empty($_FILES)){
        //data van de file
        $file = $_FILES["profilePicture"];
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];
        $fileType = $file["type"];

        //everything after the dot needs to be lowercase
        $fileExt = explode(".", $fileName);
        $fileActualExt = strtolower(end($fileExt));

        //wich filetypes are allowed
        $allowed = array("jpg", "jpeg", "png", "svg");

        if(in_array($fileActualExt, $allowed)){
            //check errors in file
            if($fileError === 0){
                //check the size of the file (in bytes) 1mb = 1000000 bytes
                if($fileSize < 1000000){
                    //give the file a unique name
                    $fileNameNew = "profile".$_SESSION['userid'].".".$fileActualExt;
                    //where the file needs to go
                    $fileDestination = "uploads/".$fileNameNew;
                    //move the file to the destination
                    move_uploaded_file($fileTmpName, $fileDestination);
                    //update the profile picture in the database
                    User::updateProfilePicture($fileNameNew);
                    
                }else{
                    $error = "Your file is too big";
                }
            }else{
                $error = "There was an error uploading your file";
            }
        }
        else{
            $error = "You cannot upload files of this type";
        }

    }
    //get the profile picture from the database
    $profilePicture = User::getProfilePicture();
    $profilePicturePath = "uploads/".$profilePicture;
    //get the bio from the database
    $bio = User::getRecentBio();
    if(!empty($_POST)){
        $bio = $_POST['new_bio'];
        $update = User::update($bio);
    }else{
        echo "het is niet gelukt";
    }

    authenticated();
    $accepted =  Prompts::accepted();

    //get the prompts from the database
    $prompts = Prompts::getAll();
    

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn profiel</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">

</head>
<body>
    <div class="context">
        <p><?php echo $error?></p>
        <div class="userinfo">
           <div class="hover" id="userProfilePicture">
                <img src="<?php echo $profilePicturePath?>" alt="profile picture">
                <div class="hidden" id="profilePictureMenu">
                <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.44 20.14" height="20px"><defs><style>.cls-1{fill: #ddd;}</style></defs><polygon class="cls-1" points="0 10.07 17.44 0 17.44 20.14 0 10.07"/></svg>
                    <ul>
                        <li id="changePicture"><a href="#">Change</a></li>
                        <li id="choseAvatar"><a href="#">Chose avatar</a></li>
                    </ul>
                </div>
            </div>
            <h2 class="username"><?php echo $_SESSION['auth_user']['username']?></h2>
            <form action="" method="POST">
                <p id="bio-text">
                    <?php echo $bio; ?>
                    <button type="button" id="edit-button"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" clip-rule="evenodd" d="m3.99 16.854-1.314 3.504a.75.75 0 0 0 .966.965l3.503-1.314a3 3 0 0 0 1.068-.687L18.36 9.175s-.354-1.061-1.414-2.122c-1.06-1.06-2.122-1.414-2.122-1.414L4.677 15.786a3 3 0 0 0-.687 1.068zm12.249-12.63 1.383-1.383c.248-.248.579-.406.925-.348.487.08 1.232.322 1.934 1.025.703.703.945 1.447 1.025 1.934.058.346-.1.677-.348.925L19.774 7.76s-.353-1.06-1.414-2.12c-1.06-1.062-2.121-1.415-2.121-1.415z" fill="#000000"></path></g></svg></button>
                </p>
                <textarea name="new_bio" id="bio-input" style="display: none;" value="<?php echo $bio; ?>"></textarea>
            </form>
            <button class="submit small"><a href="profileSettings.php">Profiel bewerken</a></button>
        </div>  
        <div class="userPrompts">Hier komen de gemaakte prompts</div>
        <h3>Newest prompts</h3>
        <hr>
            <div class="chartContainer">
                <?php if(!empty($accepted)){ foreach($accepted as $prompt):?>
                    <div class="chart">
                        <a href="promptDetail.php?prompt=<?php echo $prompt["id"]?>">
                            <div class="coverImage">
                                <?php if(!empty($prompt["example"])){?>
                                    <img src="<?php echo $prompt["example"]?>" alt="coverImage">
                                <?php ;}else{?>
                                    <img src="uploads/<?= $prompt['prompt']; ?>" alt="prompt">
                                <?php ;}?>
                            </div>
                            <div class="promptInfo">
                                <?php echo htmlspecialchars($prompt["prompt"])?>
                                <div class="categoryLabel"><?php echo $prompt["name"]?></div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; }  ?>
            </div>
            


    </div>
    <form class="" id="profilePictureForm" method="POST" enctype="multipart/form-data">
        <input type="file" name="profilePicture" id="profilePicture" accept=".jpg, .jpeg, .png">
        <button type="submit" id="submitProfilePicture">Upload</button>
        <button id="cancelPicture"type="button" id="cancelProfilePicture">Cancel</button>
    </form> 
</body>
<script src="./scripts/scriptProfile.js"></script>
</html>