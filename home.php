<?php
    include_once(__DIR__."/bootstrap.php");
    include_once (__DIR__."/navbar.php");

    authenticated();
    $accepted =  Prompts::accepted();

    //get the prompts from the database
    $prompts = Prompts::getAll();
    
    $prompts = array(
        new Prompt('Prompt 1', 'Author 1', 'GPT-2', 'paid'),
        new Prompt('Prompt 2', 'Author 2', 'GPT-3', 'free'),
        new Prompt('Prompt 3', 'Author 3', 'GPT-2', 'free'),
        // add more prompts as needed
      );
      
      $prompts_collection = new Prompts($prompts);
      
      $paid_free_filter = isset($_GET['paid_free']) ? $_GET['paid_free'] : '';
      $model_filter = isset($_GET['model_choice']) ? $_GET['model_choice'] : '';
      
      $filtered_prompts = $prompts_collection->filterPrompts($paid_free_filter, $model_filter);
      
      foreach ($filtered_prompts as $prompt) {
        // display the prompt
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
    <form method="GET" action="prompts.php">
  <label for="paid_free">Paid/Free:</label>
  <select id="paid_free" name="paid_free">
    <option value="">All</option>
    <option value="paid">Paid</option>
    <option value="free">Free</option>
  </select>

  <label for="model_choice">Model:</label>
  <select id="model_choice" name="model_choice">
    <option value="">All</option>
    <option value="stable diffusion">stable diffusion</option>
    <option value="dall-e">dall-e</option>
    <option value="midjourney">midjourney</option>
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
                        <a href="promptDetail.php?prompt=<?php echo $prompt["id"]?>">
                            <div class="coverImage">
                                <?php if(!empty($prompt["example"])){?>
                                    <img src="<?php echo $prompt["example"]?>" alt="coverImage">
                                <?php ;}else{?>
                                    <img src="uploads/<?= $prompt['prompt']; ?>" alt="prompt">
                                <?php ;}?>
                            </div>
                            <div class="promptInfo">
                                <?php echo htmlspecialchars($prompt["prompt"])?>
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