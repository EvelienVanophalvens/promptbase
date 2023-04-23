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
        <div class="dropdown">
 <button class="dropbtn_2">                    
                        <svg viewBox="0 0 50 50" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><circle cx="25" cy="25" fill="none" r="24" stroke="#ffffff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" class="stroke-000000"></circle><path fill="none" d="M0 0h50v50H0z"></path><path d="M29.933 35.528c-.146-1.612-.09-2.737-.09-4.21.73-.383 2.038-2.825 2.259-4.888.574-.047 1.479-.607 1.744-2.818.143-1.187-.425-1.855-.771-2.065.934-2.809 2.874-11.499-3.588-12.397-.665-1.168-2.368-1.759-4.581-1.759-8.854.163-9.922 6.686-7.981 14.156-.345.21-.913.878-.771 2.065.266 2.211 1.17 2.771 1.744 2.818.22 2.062 1.58 4.505 2.312 4.888 0 1.473.055 2.598-.091 4.21-1.261 3.39-7.737 3.655-11.473 6.924 3.906 3.933 10.236 6.746 16.916 6.746s14.532-5.274 15.839-6.713c-3.713-3.299-10.204-3.555-11.468-6.957z" fill="#ffffff" class="fill-000000"></path></svg>
                        <i class="fa fa-caret-down"></i>
                    </button>
        <div class="dropdown-content">
        <div class="userinfo">
           <div id="userProfilePicture">
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

        </div>
</div>

        <div class="userPrompts">Hier komen de gemaakte prompts</div>
        <h3 class="NewestPrompts">Newest prompts</h3>
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