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

//authenticated();
$accepted =  Prompts::accepted();


//getting the result of the filter using drop down
$paid_free = "";
$model_choice = "";
$paid_free_selected = isset($_GET['paid_free']) ? $_GET['paid_free'] : "";
$model_choice_selected = isset($_GET['model_choice']) ? $_GET['model_choice'] : "";


if(!empty($_GET['paid_free']) && !empty($_GET['model_choice'])) {
    $paid_free = $_GET['paid_free'];
    $model_choice = $_GET['model_choice'];
    $accepted = Prompts::filter($paid_free, $model_choice);
}else if(!empty($_GET['paid_free'])){
    $paid_free = $_GET['paid_free'];
    $accepted = Prompts::filter($paid_free, null);
}else if(!empty($_GET['model_choice'])){
    $model_choice = $_GET['model_choice'];
    $accepted = Prompts::filter(null, $model_choice);
}


// getting the result all from modelId of the filter
if(!empty($_GET['model_choice']) && empty($_GET['paid_free'])) {
    $model_choice = $_GET['model_choice'];
    $accepted = Prompts::filterModel($model_choice);
}

// getting the result paid from all of the filter
if(!empty($_GET['paid_free']) && empty($_GET['model_choice'])) {
    $paid_free = $_GET['paid_free'];
    $accepted = Prompts::filterPaid($paid_free);
}






//getting the result of the search
if(!empty($_GET['search'])) {
    $search = $_GET['search'];
    $accepted = Prompts::search($search);
}


?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>
        <div class="canvas">
            <div class="box2">
                <?php if(isset($_SESSION['status'])) { ?>
                    <div class="alert">
                        <h5><?= $_SESSION['status']; ?></h5>
                    </div>
                    <?php unset($_SESSION['status']); ?>
                <?php } ?>
                <div class="context">                    
                    <h2><?php
if (isset($_SESSION['auth_user'])) {
    echo "<h2>Hello " . htmlspecialchars($_SESSION['auth_user']['username']) . "! <br>You joined the collective now.</h2>";
}else{
    echo "<h2>Hello! <br>Welcome to collectivePrompts.</h2>";
}
?></h2>
                    <button class="btn submit">
                        <a href="upload.php">Upload prompt</a>
                    </button>
                </div>
                <div class="illustration">
                    <img src="uploads/illustration_team.png" alt="team">
                </div>
            </div>
        </div>
        <div id="filter">
        <form method="GET" action="index.php">
    <label for="paid_free">Paid/Free:</label>
    <select id="paid_free" name="paid_free">
        <option value=""<?php if ($paid_free_selected == "") {
            echo "selected";
        } ?>>All</option>
        <option value="paid"<?php if ($paid_free_selected == "paid") {
            echo "selected";
        } ?>>Paid</option>
        <option value="free">Free</option>
    </select>

    <label for="model_choice">Model:</label>
    <select name="model_choice">
        <option value=""<?php if ($model_choice_selected == "") {
            echo "selected";
        } ?>>All</option>
        <option value="stable diffusion"<?php if ($model_choice_selected == "stable diffusion") {
            echo "selected";
        } ?>>Stable Diffusion</option>
        <option value="dall-e"<?php if ($model_choice_selected == "dall-e") {
            echo "selected";
        } ?>>Dall-e</option>
        <option value="midjourney"<?php if ($model_choice_selected == "midjourney") {
            echo "selected";
        } ?>>Midjourney</option>
    </select>
    <button type="submit">Filter</button>
</form>
    
    </div>
        <div class="content">
            <div class="newestPrompts">
                <h3>Newest prompts</h3>
                <hr>
                <div class="chartContainer">
                    <?php if(!empty($accepted)):
                        foreach($accepted as $prompt):
                            $example = Prompts::getPromptExample($prompt["id"]);
                            $picture = $example["example"];
                            $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $picture;?>


                            
                            <div class="chart">
                                <a href="promptDetail.php?prompt=<?php echo $prompt["id"];?>"> 
                                    <div class="coverImage">
                                        <?php if(!empty($picture)) {?>
                                            <img src="<?php echo htmlspecialchars('https://res.cloudinary.com/dbbz2g87h/image/upload/'. $picture)?>" alt="coverImage">
                                        <?php } else {?>
                                            <img src="uploads/default_image.png" alt="example">
                                        <?php }?>
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
                    endif; ?>
                </div>
            </div>
        </div>
    </body>
    </html>