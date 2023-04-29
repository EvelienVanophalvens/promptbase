    <?php
        include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

authenticated();
$accepted =  Prompts::accepted();

//retrieve the data from mysql using drop down
/*   $paid_free = "";
   $model_choice = "";
 if(!empty($_GET['paid_free']) && !empty($_GET['model_choice'])){
       $model_choice = $_GET['model_choice'];
       $accepted = Prompts::filter($paid_free, $model_choice);
   }else if(!empty($_GET['paid_free'])){
       $paid_free = $_GET['paid_free'];
       $accepted = Prompts::filter($paid_free, null);
   }else if(!empty($_GET['model_choice'])){
       $model_choice = $_GET['model_choice'];
       $accepted = Prompts::filter(null, $model_choice);
   }*/

//getting the result of the filter using drop down
$paid_free = "";
$model_choice = "";
$paid_free_selected = isset($_GET['paid_free']) ? $_GET['paid_free'] : "";
$model_choice_selected = isset($_GET['model_choice']) ? $_GET['model_choice'] : "";

if(!empty($_GET['paid_free']) && !empty($_GET['model_choice'])) {
    $model_choice = $_GET['model_choice'];
    $accepted = Prompts::filter($paid_free, $model_choice);
} elseif(!empty($_GET['paid_free'])) {
    $paid_free = $_GET['paid_free'];
    $accepted = Prompts::filter($paid_free, null);
} elseif(!empty($_GET['model_choice'])) {
    $model_choice = $_GET['model_choice'];
    $accepted = Prompts::filter(null, $model_choice);
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
                    <h2>Hello <?= htmlspecialchars($_SESSION['auth_user']['username']); ?>! <br>You joined the collective now.</h2>
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
        <form method="GET" action="home.php">
    <label for="paid_free">Paid/Free:</label>
    <select id="paid_free" name="paid_free">
        <option value=""<?php if ($paid_free_selected == "") {
            echo "selected";
        } ?>>All</option>
        <option value="paid"<?php if ($paid_free_selected == "paid") {
            echo "selected";
        } ?>>Paid</option>
        <option value="free"<?php if ($paid_free_selected == "free") {
            echo "selected";
        } ?>>Free</option>
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
   <input type="text" class="search" name="search" placeholder="Search.." value="<?php if(isset($_GET['search'])) {
       echo htmlspecialchars($_GET['search']);
   } ?>">
    <button type="submit">Search</button>
</form>
    
    </div>
        <div class="content">
            <div class="newestPrompts">
                <h3>Newest prompts</h3>
                <hr>
                <div class="chartContainer">
                    <?php if(!empty($accepted)) {
                        foreach($accepted as $prompt){
                            $example = Prompts::getPromptExample($prompt["id"]);
                            $picture = "uploads/".$example["example"];?>
                            <div class="chart">
                                <a href="promptDetail.php?prompt=<?php echo $prompt["id"];?>"> 
                                    <div class="coverImage">
                                        <?php if(!empty($picture)) {?>
                                            <img src="<?php echo htmlspecialchars($picture)?>" alt="coverImage">
                                        <?php } elseif (!empty($prompt["image"])) {?>
                                            <img src="<?php echo htmlspecialchars($prompt["image"])?>" alt="example">
                                        <?php } else {?>
                                            <img src="uploads/default_image.png" alt="example">
                                        <?php }?>
                                    </div>
                                    <div class="promptInfo">
                                        <?php if(isset($prompt["prompt"])) {
                                            echo htmlspecialchars($prompt["prompt"]);
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
                        <?php }
                    }  ?>
                </div>
            </div>
        </div>
    </body>
    </html>