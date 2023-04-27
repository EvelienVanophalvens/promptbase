<?php
    include_once(__DIR__."/bootstrap.php");
    include_once (__DIR__."/navbar.php");

    authenticated();
    $accepted =  Prompts::accepted();
    $prompts = Prompts::getAll();
    

    if(!empty($_GET)){
        //Alle prompts waarin de ingetypte categorie voorkomt
        $results = Prompts::filteredPromptsByCategory($_GET['search']);
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
    <div class="content">
        <div class="newestPrompts">
            <h3>By category </h3>
            <hr>
            <div class="chart2">
                    <div class="chart__title">
                        <h1><?php if(isset($_GET['search'])){echo htmlspecialchars($_GET['search']); } ?></h1>
                    </div>
                    <div class="chart__content">
                        <div class="chart__content__item">  
                            <div class="chart__content__item__value">
                                <h2>Found prompts</h2>
                            </div>
                        </div>
                        <div class="chart__content__item">
                            <div class="chart__content__item__value">
                                <h2><?php if(isset($results)){echo count($results);} ?></h2>
                            </div>
                    </div>
                    <div class="chartContainer">
                <?php if(!empty($results)){ foreach($results as $prompt):?>
                    <div class="chart">
                        <a href="promptDetail.php?prompt=<?php echo $prompt["id"]?>">
                        <div class="coverImage">
                                <?php if(!empty($prompt["example"])){?>
                                <img src="<?php echo "uploads/".htmlspecialchars($prompt["example"])?>" alt="coverImage">
                                <?php ;}else if (!empty($prompt["image"])){?>
                                <img src="<?php echo htmlspecialchars($prompt["image"])?>" alt="example">
                            <?php ;}?>

                                </div>
                            <div class="promptInfo">
                                <?php echo htmlspecialchars($prompt["promptName"])?>
                                <div class="categoryLabel"><?php echo $prompt["name"]?></div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; }  ?>
            </div>



                </div>
            </div>
        </div>
    </div>
</body>
</html>