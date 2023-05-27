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
                            $example = Prompts::getPromptExample($prompt["promptId"]);
                            $picture = $example["example"];?>
                            <div class="chart">
                                <a href="promptDetail.php?prompt=<?php echo $prompt["promptId"];?>"> 
                                    <div class="coverImage">
                                        <?php if(!empty($picture)) {
                                              $image = 'https://res.cloudinary.com/dbbz2g87h/image/upload/'. $picture;?>
                  ?>
                                            <img src="<?php echo $image?>" alt="coverImage">
                                        <?php } else {?>
                                            <img src="uploads/default_image.png" alt="example">
                                        <?php }?>
                                    </div>
                                    <div class="promptInfo">
                                        <!--The prompt title-->
                                        <?php if(isset($prompt["title"])) {
                                            echo htmlspecialchars($prompt["title"]);
                                        }?>
                                        <!--The right category label-->  
                                        <div class="categoryLabel">
                                            <?php if(isset($prompt["category"])) {
                                                echo htmlspecialchars($prompt["category"]);
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