    <?php
        include_once(__DIR__."/bootstrap.php");
        include_once (__DIR__."/navbar.php");

        authenticated();
        $accepted =  Prompts::accepted();
        $prompts = Prompts::getAll();

        //retrieve the data from mysql using drop down
        if(isset($_POST['paid_free']) && isset($_POST['model_choice'])){
            $paid_free = $_POST['paid_free'];
            $model_choice = $_POST['model_choice'];
            $accepted = Prompts::filter($paid_free, $model_choice);
        }

            // getting the image from the prompt
            $picture = "";
            foreach($accepted as $example){
                $picture = "uploads/".$example["example"];
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
                    <h2>Hello! Welcome to the home page <?= $_SESSION['auth_user']['username']; ?>.</h2>
                </div>
            </div>
        </div>
        <div id="filter">
        <form method="POST" action="home.php">
    <label for="paid_free">Paid/Free:</label>
    <select id="paid_free" name="paid_free">
        <option value="">All</option>
        <option value="paid">Paid</option>
        <option value="free">Free</option>
    </select>

    <label for="model_choice">Model:</label>
    <select name="model_choice">
        <option value="">All</option>
        <option value="stable diffusion">Stable Diffusion</option>
        <option value="dall-e">Dall-e</option>
        <option value="midjourney">Midjourney</option>
    </select>

    <button type="submit">Filter</button>
    </form>
    </div>
        <div class="content">
            <div class="newestPrompts">
                <h3>Newest prompts</h3>
                <hr>
                <div class="chartContainer">
                    <?php if(!empty($accepted)){ foreach($accepted as $prompt):?>
                        <div class="chart">
                 <!---      <a href="promptDetail.php?prompt=<?php echo $prompt["id"]?>">   -->
                                <div class="coverImage">
                                    <?php if(!empty($prompt["example"])){?>
                                        <img src="<?php echo $picture?>" alt="coverImage">
                                    <?php ;}else{?>
                      <!---                  <img src="<?php echo $prompt["example"]?>" alt="example"> -->
                                    <?php ;}?>
                                </div>
                                <div class="promptInfo">
                             <!---   <?php echo htmlspecialchars($picture)?>  --> 
                                    <div class="categoryLabel"><?php echo $picture?></div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; }  ?>
                </div>
            </div>
        </div>
    </body>
    </html>