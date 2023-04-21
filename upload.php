<?php

include_once(__DIR__."/bootstrap.php");
include_once (__DIR__."/navbar.php");

//get connection to database
$db = Db::getInstance();

//get user id
$user = $_SESSION['userid'];



$statusMsg = '';

// File upload path
$targetDir = "uploads/";

if(isset($_FILES["file"]) && !empty($_FILES["file"]["name"])){
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into prompts (prompt, date, userId) VALUES ('".$fileName."', NOW(), $user)");
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

//getting the category in the database
if(isset($_POST['category'])) {
    $category = $_POST['category'];
    $insert = $db->query("INSERT into categories (name) VALUES ('".$category."')"); 
    if($insert){
        $statusMsg = "The category ".$category. " has been uploaded successfully.";
    }else{
        $statusMsg = "File upload failed, please try again.";
    }
    
}

//getting the categoryId in the database prompt_categories
if(isset($_POST['category'])) {
    $category = $_POST['category'];
    $insert = $db->query("INSERT into prompt_categories (categoryId) VALUES ('".$category."')");
}

//getting the promptId in the database prompt_categories
if(isset($_POST['promptId'])) {
    $promptId = $_POST['promptId'];
    $insert = $db->query("INSERT into prompt_categories (promptId) VALUES ('".$promptId."')");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    
    <div class="upload">
        <?php if(!empty($statusMsg)){ ?>
            <p class="statusMsg"> <?php echo $statusMsg; ?> </p> 
            <?php } ?>
    <form  action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="file">Upload afbeelding:</label>
    <input type="file" name="file" >
    <br>
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" >
    <br>
    <input type="radio" id="private" name="private" value="PRIVATE">
    <label for="private">Private</label>
    <input type="radio" id="public" name="public" value="PUBLIC">
    <label for="public">Public</label>
    <br>
    <label for="price">Credits:</label>
    <input type="number" id="price" name="price">
    <br>
    <label for="beschrijving">Beschrijving:</label>
    <textarea name="message" rows="10" cols="30"></textarea>
    <br>
    <label for="category">Category:</label>
    <input type="text" name="category">
    <input type="submit" name="submit" value="Upload prompt">
</form>
</div>


</body>
</html>