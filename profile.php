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
$error = "";
if(!empty($_FILES)) {

        $fileName = basename($_FILES['profilePicture']['name']);
        $publicId = time() . '_' . $fileName; // Generate unique public_id

        $file = "profilePicture/" . $publicId . ".jpg";

        if(
        $cloudinary->uploadApi()->upload(
            $_FILES['profilePicture']['tmp_name'],
            ['public_id' => $publicId, 'folder' => 'profilePicture']
        )){
            User::updateProfilePicture($file, $_SESSION['userid']);
        }
    

}
//get the profile picture from the database
$profilePicture = User::getProfilePicture();
if(!empty($profilePicture)) {
    $profilePicturePath = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $profilePicture;
} else {
    $profilePicturePath = "uploads/default_profile.png";
}
//get the bio from the database
if(!empty($_POST)) {
    $bio = $_POST['new_bio'];
    $update = User::update($bio);
} else {
    $bio = User::getRecentBio();
}
authenticated();
//get the prompts from the database
$personalPrompts =  Prompts::getPersonalPrompts($_SESSION['userid']);

//get the favourite prompt from the database
$userId = $_SESSION['userid'];

$favouritePrompt = Prompts::getFavouritePrompts($userId);

$boughtPrompts = Prompts::getBoughtPrompts($_SESSION['userid']);



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
    <div class="profileContext">
        <div class="userinfo">
            <p><?php echo $error?></p>
           <div class="hover" id="userProfilePicture">
                <img src="<?php echo htmlspecialchars($profilePicturePath)?>" alt="profile picture">
                <div class="hidden" id="profilePictureMenu">
                <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.44 20.14" height="20px"><defs><style>.cls-1{fill: #ddd;}</style></defs><polygon class="cls-1" points="0 10.07 17.44 0 17.44 20.14 0 10.07"/></svg>
                    <ul>
                        <li id="changePicture"><a href="#">Change</a></li>
                        <li id="choseAvatar"><a href="#">Chose avatar</a></li>
                    </ul>
                </div>
            </div>
            <h2 class="username"><?php echo htmlspecialchars($_SESSION['auth_user']['username'])?></h2>
            <div >
            <form action="" method="POST" id="bio-form">
                <p id="bio-text">
                    <?php echo $bio; ?>
                    <button type="button" id="edit-button"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" clip-rule="evenodd" d="m3.99 16.854-1.314 3.504a.75.75 0 0 0 .966.965l3.503-1.314a3 3 0 0 0 1.068-.687L18.36 9.175s-.354-1.061-1.414-2.122c-1.06-1.06-2.122-1.414-2.122-1.414L4.677 15.786a3 3 0 0 0-.687 1.068zm12.249-12.63 1.383-1.383c.248-.248.579-.406.925-.348.487.08 1.232.322 1.934 1.025.703.703.945 1.447 1.025 1.934.058.346-.1.677-.348.925L19.774 7.76s-.353-1.06-1.414-2.12c-1.06-1.062-2.121-1.415-2.121-1.415z" fill="#000000"></path></g></svg></button>
                </p>
                <input name="new_bio" id="bio-input" style="display: none;" value="<?php echo htmlspecialchars($bio); ?>">
            </form>
            </div>
            <button class="submit small"><a href="profileSettings.php">Profiel bewerken</a></button>
        </div>  
        <div class="userPrompts">
            <h3>My prompts</h3>
            <hr>
            <div class="chartContainer">
                <?php if(!empty($personalPrompts)) {
                    foreach($personalPrompts as $prompt):?>
                        <div class="chart">
                            <a href="viewOwnPrompt.php?prompt=<?php echo $prompt["id"];?>">
                                <div class="coverImage">
                                    <?php if(!empty($prompt["example"])) {
                                        $picture = $prompt["example"];
                                        $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $picture;?>
                                        <img src="<?php echo $image;?>" alt="coverImage">
                                    <?php ;
                                    } elseif (!empty($prompt["image"])) {?>
                                        <img src="<?php echo $prompt["image"]?>" alt="example">
                                    <?php ;
                                    } else {?>
                                        <img src="uploads/default_image.png" alt="coverImage">
                                    <?php ;}?>
                                </div>
                                <div class="promptInfo">
                                    <?php if(isset($prompt["title"])) {
                                        echo htmlspecialchars($prompt["title"]);
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
                }?>
            </div>  
            <h3>My favorite prompts</h3>
            <hr>  
            <div class="chartContainer">
                <?php if(!empty($favouritePrompt)) {
                    foreach($favouritePrompt as $prompt): ?>
                        <div class="chart">
                            <a href="promptDetail.php?prompt=<?php echo $prompt["id"];?>">
                            
                                <div class="coverImage">
                                    <?php if(!empty($prompt["example"])) {
                                        
                                        $picture = $prompt["example"];
                                        $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $picture;?>
                                        <img src="<?php echo $image?>" alt="coverImage">
                                    <?php ;
                                    } elseif (!empty($prompt["image"])) {?>
                                        <img src="<?php echo $prompt["image"]?>" alt="example">
                                    <?php ;
                                    }else{?>
                                        <img src="uploads/default_image.png" alt="coverImage">
                                    <?php ;}?>
                                </div>
                                <div class="promptInfo">
                                    <?php if(isset($prompt["title"])) {
                                        echo htmlspecialchars($prompt["title"]);
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
                }?>
            </div>  


            <h3>My bought prompts</h3>
            <hr>  
            <div class="chartContainer">
                <?php if(!empty($boughtPrompts)) {
                    foreach($boughtPrompts as $prompt):?>
                        <div class="chart">
                            <a href="promptBought.php?prompt=<?php echo $prompt["id"];?>">
                            
                                <div class="coverImage">
                                    <?php if(!empty($prompt["example"])) {
                                        $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $prompt["example"];?>
                                        <img src="<?php echo $image?>" alt="coverImage">
                                    <?php ;
                                    } elseif (!empty($prompt["image"])) {
                                        $picture = $prompt["image"];
                                        $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $picture;?>
                                        <img src="<?php echo $image;?>" alt="coverImage">
                                    <?php ;
                                    }else{?>
                                        <img src="uploads/default_image.png" alt="coverImage">
                                    <?php ;}?>
                                </div>
                                <div class="promptInfo">
                                    <?php if(isset($prompt["title"])) {
                                        echo htmlspecialchars($prompt["title"]);
                                    }?>  
                                    <div class="categoryLabel">
                                        <?php if(isset($prompt["categorie"])) {
                                            echo htmlspecialchars($prompt["categorie"]);
                                        } else {
                                            echo "no category";
                                        }?>
                                    </div>
                                </div>    
                            </a>
                            </div>
                    <?php endforeach;
                }?>
            </div>  


        </div>
      </div>
    </div>
    <form class= "middleForm" id="profilePictureForm" method="POST" enctype="multipart/form-data">
        <input type="file" name="profilePicture" id="profilePicture" accept=".jpg, .jpeg, .png">
        <button type="submit" id="submitProfilePicture">Upload</button>
        <button id="cancelPicture"type="button" id="cancelProfilePicture">Cancel</button>
    </form>
   
    <script src="./scripts/scriptProfile.js"></script> 
</body>
</html>