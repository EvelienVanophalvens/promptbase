<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");

authenticated();

//getting the result of the search
if(!empty($_GET['search'])) {
    $search = $_GET['search'];
    $results = Prompts::search($search);
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
            <h3>You searched by '<?php echo htmlspecialchars($_GET['search'])?>'</h3>
            <hr>
            <h4>
                <?php if(isset($results)) { echo count($results);} ?> results found.
            </h4>
            <div class="chartContainer">
                    <?php if(!empty($results)) {
                        foreach($results as $prompt){
                            //get the right first example for each prompt
                            $example = Prompts::getPromptExample($prompt["id"]);
                            $picture = $example["example"];?>
                            <div class="chart">
                                <a href="promptDetail.php?prompt=<?php echo $prompt["id"];?>"> 
                                    <div class="coverImage">
                                        <?php if(!empty($picture)) {?>
                                            <img src="uploads/<?php echo htmlspecialchars($picture)?>" alt="coverImage">
                                        <?php } else {?>
                                            <img src="uploads/default_image.png" alt="example">
                                        <?php }?>
                                    </div>
                                    <div class="promptInfo">
                                        <!--The prompt title-->
                                        <?php if(isset($prompt["prompt"])) {
                                            echo htmlspecialchars($prompt["prompt"]);
                                        }?>
                                        <!--The right category label-->  
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