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
            <!-- <form action="" method="POST"> -->
                <p class="bio" id="bio"><?php echo $bio?></p>
            <!-- </form> -->
        </div>
        <div class="userPrompts">Hier komen de gemaakte prompts</div>
    </div>
    <form class="" id="profilePictureForm" method="POST" enctype="multipart/form-data">
        <input type="file" name="profilePicture" id="profilePicture" accept=".jpg, .jpeg, .png">
        <button type="submit" id="submitProfilePicture">Upload</button>
        <button id="cancelPicture"type="button" id="cancelProfilePicture">Cancel</button>
    </form> 
</body>
<script src="./scripts/script.js"></script>
</html>