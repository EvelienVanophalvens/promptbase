<?php
    include_once(__DIR__."/bootstrap.php");
    include_once (__DIR__."/navbar.php");

    authenticated();

    if(!empty($_POST)){
        //Alle prompts waarin de ingetypte categorie voorkomt
        $results = Prompts::filteredPromptsByCategory($_POST['search']);
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
            <div class="chartContainer">
                <?php if(!empty($results)){ foreach($results as $prompt):?>
                    <div class="chart">
                        <a href="promptDetail.php?prompt=<?php echo $prompt["id"]?>">
                            <div class="coverImage">
                                <?php if(!empty($prompt["example"])){?>
                                    <img src="<?php echo $prompt["example"]?>" alt="coverImage">
                                <?php ;}else{?>
                                    <img src="https://image-placeholder.com/images/actual-size/200x200.png" alt="coverImage">
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
</body>
</html>