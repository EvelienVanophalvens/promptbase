<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

authenticated();

if(!empty($_GET)) {
    //Alle prompts waarin de ingetypte categorie voorkomt
    $results = Prompts::filteredPromptsByCategory($_GET['search']);
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
    <div class="content">
        <div class="newestPrompts">
            <h3>By category </h3>
            <hr>
            <div class="chart2">
                    <div class="chart__title">
                        <h1><?php if(isset($_GET['search'])) {
                            echo htmlspecialchars($_GET['search']);
                        } ?></h1>
                    </div>
                    <div class="chart__content">
                        <div class="chart__content__item">  
                            <div class="chart__content__item__value">
                                <h2>Found prompts</h2>
                            </div>
                        </div>
                        <div class="chart__content__item">
                            <div class="chart__content__item__value">
                                <h2><?php if(isset($results)) {
                                    echo count($results);
                                } ?></h2>
                            </div>
                    </div>
                    <div class="chartContainer">
                <?php if(!empty($results)) {
                    foreach($results as $prompt):
                        $example = Prompts::getPromptExample($prompt["id"]);
                        $picture = $example["example"];?>                    
                    <div class="chart">
                        <a href="promptDetail.php?prompt=<?php echo $prompt["id"]?>">
                        <div class="coverImage">
                                <?php if(!empty($prompt["example"])) {?>
                                <img src="<?php echo "uploads/".htmlspecialchars($prompt["example"])?>" alt="coverImage">
                                <?php ;
                                } elseif (!empty($picture)) {?>
                                <img src="<?php echo htmlspecialchars($picture)?>" alt="example">
                            <?php ;
                                }?>

                                </div>
                            <div class="promptInfo">
                                <?php echo htmlspecialchars($prompt["promptName"])?>
                                <div class="categoryLabel"><?php echo $prompt["name"]?></div>
                            </div>
                        </a>
                    </div>
                <?php endforeach;
                }  ?>
            </div>



                </div>
            </div>
            <h3>By title</h3>
            <hr>
            <div class="chart__content__item">
                            <div class="chart__content__item__value">
                                <h2><?php if(isset($accepted)) {
                                    echo count($accepted);
                                } ?></h2>
                            </div>
                    </div>
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