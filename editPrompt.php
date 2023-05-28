<?php
    include_once(__DIR__."/bootstrap.php");
    authenticated();
    include_once(__DIR__."/navbar.php");


    
    require_once(__DIR__ . '/vendor/autoload.php');

    use Cloudinary\Cloudinary;

    $cloudinary = new Cloudinary([
        'cloud' => [
            'cloud_name' => 'dbbz2g87h',
            'api_key'    => '263637247196311',
            'api_secret' => 'cOrwpgG-ICTXLSYVCQJisbZb0x8',
        ],
    ]);




    $prompt = Prompts::getRejectedPrompt($_GET['prompt'], $_SESSION['userid']);



    $models = Prompts::getModules();

    $categories = Prompts::categories();

    
    $fileSize = true;


    if(!empty($_FILES)) {
        foreach($_FILES['files']['name'] as $key => $val){
            if($_FILES['files']['size'][$key] > 1000000){
                $fileSize = false;

            }
        }
    }

    
    
    if(!empty($_POST) && empty(((int) $_POST['status'])) && isset($_POST["submit"])) {
        $user = $_SESSION['userid'];

        if($_POST['paid'] == 0) {
    
        
        try {
            $prompt = new Prompts();
            $prompt->setTitle($_POST['title']);
            $prompt->setAuthor($user);
            $prompt->setDate(date("Y-m-d"));
            $prompt->setDescription($_POST['description']);
            $prompt->setStatus(((int) $_POST['status']));
            $prompt->setPaid(((int) $_POST['paid']));
            $prompt->setPrice(((int) $_POST['credits']));
            $prompt->setCategories($_POST['categories']);
            $prompt->setModel($_POST['modelType']);
            $prompt->setPrompt($_POST["prompt"]);
            $prompt->updatePrompt($_GET['prompt']);
            header("Location: profile.php");
        } catch(Throwable $e) {
            $message = $e->getMessage();
        }
        
 

    } elseif(!empty($_POST) && $_POST['paid'] == 1  && isset($_POST["submit"])) {
        try {
            $prompt = new Prompts();
            $prompt->setTitle($_POST['title']);
            $prompt->setAuthor($user);
            $prompt->setDate(date("Y-m-d"));
            $prompt->setDescription($_POST['description']);
            $prompt->setStatus(((int) $_POST['status']));
            $prompt->setPaid(((int) $_POST['paid']));
            $prompt->setPrice(((int) 0));
            $prompt->setCategories($_POST['categories']);
            $prompt->setModel($_POST['modelType']);
            $prompt->setPrompt($_POST["prompt"]);

            $prompt->updatePrompt($_GET['prompt']);
            header("Location: profile.php");

        } catch(Throwable $e) {
            $message = $e->getMessage();
        }
    } else {
        $message = "Please fill in all the fields";
    }
   
    }else{
        $message = "Please fill in all the fields";
    
    }


    if (!empty($_FILES) && empty($message) && $fileSize == true) {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dbbz2g87h',
                'api_key'    => '263637247196311',
                'api_secret' => 'cOrwpgG-ICTXLSYVCQJisbZb0x8',
            ],
        ]);
    
        foreach ($_FILES['files']['name'] as $key => $val) {
            $fileName = "promptExample" . $key . $_GET['prompt'];
            $publicId = time() . '_' . $fileName; // Generate unique public_id
    
            $file = "prompts/" . $publicId . ".jpg";
    
            if(
            $cloudinary->uploadApi()->upload(
                $_FILES['files']['tmp_name'][$key],
                ['public_id' => $publicId, 'folder' => 'prompts']
            )){
                Prompts::updateExamples($_GET['prompt'], $file);
            }
        }
    }else if(empty($_FILES) && !empty($message)){
        foreach($prompt["examples"] as $example){
            Prompts::updateExamples($_GET['prompt'], $example["example"]);
        }
    }else if($fileSize == false ){
        $error = "File is too large";
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
        <a href="profile.php" id="backbtn">< BACK TO ACCOUNT</a>
        <?php if(!empty($message)):?><p><?php echo $message ?></p><?php endif?>
        <?php if(!empty($error)):?><p><?php echo $error ?></p><?php endif;?>
    <form method="POST" enctype="multipart/form-data">
        <div class="formContainer">
            <div class="formContainerLeft">
                <div class="input">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($prompt['prompt'][0]["title"])?>">
                </div>
                <div class="input">
                    <label for="title">Prompt</label>
                    <input type="text" name="prompt" id="prompt" value="<?php echo htmlspecialchars($prompt['prompt'][0]["prompt"])?>">
                </div>
                <div class="input">
                    <label for="modelType">ModelType</label>
                    <select name="modelType">
                        <?php foreach($models as $model):?>
                            <option value="<?php echo $model["id"]?>" <?php if($model["name"] == $prompt["prompt"][0]["name"]) echo "selected"?>><?php echo $model["name"]?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="input">      
                <label for="categorie">Categorie</label>
                    <div id="list1" class="dropdown-check-list" tabindex="100">
                        <span class="anchor">Select categories</span>
                        <ul class="items">
                            <?php foreach($categories as $categorie):?>
                            <li><input name="categories[]" type="checkbox" value="<?php echo $categorie["id"]?>" <?php if($prompt["prompt"][0]["categorie"] == $categorie["name"]) echo "checked"?>/> <?php echo $categorie["name"]?> </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>      
                <div class="uploadImg">
                    <p>Upload example<p>
                    <p>ctrl+shift to select multiple picture</p>
                    <div class="coverImages">
                        <?php if(!empty($prompt["examples"])): foreach($prompt["examples"] as $example):
                             $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $example["example"];?>
                            <div class="coverImage">
                            <img src="<?php echo $image?>" alt="<?php echo $example["example"]?>">
                            </div>
                        <?php endforeach; endif;?>
                    </div>
                    <input type="file" id="files" name="files[]" multiple="multiple"/> 


                </div>
            </div>
            <div class="formContainerRight">

                <p>Others</p>
                <div class="radio1">
                    <input type="radio" id="private" name="status" value="1" <?php if($prompt['prompt'][0]['status'] == 1) echo 'checked'?>>
                    <label for="private">Private</label>
                    <input type="radio" id="public" name="status" value="0" <?php if($prompt['prompt'][0]['status'] == 0) echo 'checked'?>>
                    <label for="public">Public</label>
                </div>
                <div class="radio2">
                    <input type="radio" id="paid" name="paid" value="0" <?php if($prompt['prompt'][0]['paid'] == 0) echo 'checked'?>>
                    <label for="paid">Paid</label>
                    <input type="radio" id="free" name="paid" value="1" <?php if($prompt['prompt'][0]['paid'] == 1) echo 'checked'?>>
                    <label for="free">Free</label>
                </div>
                <label for="credits">Credits</label>
                <input type="number" name="credits" id="credits" value="<?php echo htmlspecialchars($prompt['prompt'][0]["price"])?>">
                
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="10"><?php echo htmlspecialchars($prompt['prompt'][0]["description"])?></textarea>
            </div>
        </div>

        <input type="submit" value="submit" name="submit" class="succes long" >
        <input type="submit" value="cancel" name="cancel" class="danger long">
        

    </form>  
        
       


</body>
<script src="scripts/scriptDropdown.js"></script>
</html>