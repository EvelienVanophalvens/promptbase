<?php

include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

//get user id
if (isset($_SESSION['userid'])) {
    // get user id
    $user = $_SESSION['userid'];
} else {
    // handle the case where userid is not set in the session
    $user = null;
}


//get model for prompts
$models = Prompts::getModules();

$categories = Prompts::categories();

$promptId = "";

$message = "";
if(!empty($_POST) && empty(((int) $_POST['status']))) {
    if($_POST['paid'] == 0) {

    
    try {
        $prompt = new Prompts();
        $prompt->setPrompt($_POST['title']);
        $prompt->setAuthor($user);
        $prompt->setDate(date("Y-m-d"));
        $prompt->setDescription($_POST['description']);
        $prompt->setStatus(((int) $_POST['status']));
        $prompt->setPaid(((int) $_POST['paid']));
        $prompt->setPrice(((int) $_POST['price']));
        $prompt->setCategories($_POST['categories']);
        $prompt->setModel($_POST['model_choice']);
        $promptId = $prompt->save();
    } catch(Throwable $e) {
        $message = $e->getMessage();
    }
} elseif(!empty($_POST) && $_POST['paid'] == 1) {
    $message = "Your price will be set to 0 because you have chosen to make this prompt free";
    $prompt = new Prompts();
    $prompt->setPrompt($_POST['title']);
    $prompt->setAuthor($user);
    $prompt->setDate(date("Y-m-d"));
    $prompt->setDescription($_POST['description']);
    $prompt->setStatus(((int) $_POST['status']));
    $prompt->setPaid(((int) $_POST['paid']));
    $prompt->setPrice(((int) 0));
    $prompt->setCategories($_POST['categories']);
    $prompt->setModel($_POST['model_choice']);
    $promptId = $prompt->save();
} else {
    $message = "Please fill in all the fields";
}
}else{
    $message = "Please fill in all the fields";

}




$statusMsg = '';
;


$targetDir = "uploads/";

if(!empty($_FILES) && empty($message)) {

    foreach($_FILES['files']['name'] as $key=>$val) {

        // File upload path
        $fileName = basename($_FILES['files']['name'][$key]);

        $targetFilePath = $targetDir . $fileName;

        // Check whether file type is valid
        $fileExt = explode(".", $fileName);
        $fileActualExt = strtolower(end($fileExt));
        var_dump($fileActualExt);
        $allowTypes = array('jpg','png','jpeg','gif','pdf');
        if(in_array($fileActualExt, $allowTypes)) {
            // Upload file to server
            if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                // Insert image file name into database
                $insert = Prompts::addExample($promptId, $fileName);
                if($insert) {
                    $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                } else {
                    $statusMsg = "File upload failed, please try again.";
                }
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    }
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
        <?php if(!empty($statusMsg)) { ?>
            <p class="statusMsg"> <?php echo $statusMsg; ?> </p> 
            <?php } ?>
        <?php if(!empty($message)) { ?>
            <p class="statusMsg"> <?php echo $message; ?> </p> 
            <?php } ?>
    <h1>Upload your prompt</h1>
    <form  action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="file">Upload example:</label>
    <p>ctrl+shift to select multiple picture</p>
    <input type="file" name="files[]" multiple="multiple">
    <br>
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" >
    <br>
    <br>
    <input type="radio" id="private" name="status" value="1">
    <label for="private">Private</label>
    <input type="radio" id="public" name="status" value="0">
    <label for="public">Public</label>
    <br>
    <br>
    <input type="radio" id="paid" name="paid" value="0">
    <label for="paid">Paid</label>
    <input type="radio" id="free" name="paid" value="1">
    <label for="free">Free</label>
    <br>
    <br>
    <label for="model_choice">Model Choice:</label>
    <select id="model_choice" name="model_choice">
    <?php foreach($models as $model): ?>
    <option value="<?php echo $model['id']; ?>"><?php echo $model['name']; ?></option>
    <?php endforeach; ?>
    </select>
    <br>
    <label for="price">Credits:</label>
    <input type="number" id="price" name="price">
    <br>
    <label for="description">Description:</label>
    <textarea name="description" rows="10" cols="30"></textarea>
    <br>
    <div id="list1" class="dropdown-check-list" tabindex="100">
    <span class="anchor">Select categories</span>
    <ul class="items">
        <?php foreach($categories as $categorie):?>
        <li><input name="categories[]" type="checkbox" value="<?php echo $categorie["id"]?>" /> <?php echo $categorie["name"]?> </li>
        <?php endforeach;?>
    </ul>
    <input type="submit" name="submit" value="Upload prompt">


</div>
</form>
</div>

</body>
<script src="./scripts/scriptDropdown.js"></script>
</html>