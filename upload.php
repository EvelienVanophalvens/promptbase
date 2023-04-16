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

// Display status message
echo $statusMsg;

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
    <br>
    <input type="file" name="file" >
    <br>
    <br>
    <label for="title">Title:</label>
    <br>
    <input type="text" id="title" name="title" >
    <br>
    <br>
    <input type="radio" id="private" name="private" value="PRIVATE">
    <label for="private">Private</label>
    <input type="radio" id="public" name="public" value="PUBLIC">
    <label for="public">Public</label>
    <br>
    <br>
    <label for="price">Price:</label>
    <br>    
    free
  <input type="range" id="price" name="price" value="50">
  10 credits
    <br>
    <br>
    <label for="beschrijving">Beschrijving:</label>
    <br>
    <input type="text" id="beschrijving" name="beschrijving" v>
    <br>
    <br>
    <label for="category">Choose a Category:</label>
  <select id="category" name="category">
    <option value="cars">Cars</option>
    <option value="music">Music</option>
    <option value="art">Art</option>
    <option value="travel">Travel</option>
  </select>
    <br>
    <br>
    
    <input type="submit" name="submit" value="Upload prompt">
</form>
</div>


</body>
</html>