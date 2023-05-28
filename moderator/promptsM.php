<?php
include_once(__DIR__."/../bootstrap.php");
User::isAdmin();
include_once(__DIR__."/navbarM.php");


$notAccepted =  Prompts::notAccepted();

$reported = Reports::getReportedPrompts();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>prompts</title>
</head>
<body>
    <div class="content">
        <section class="askedPrompts">
            <h2>New sended prompts</h2>
            <table>
                <tr>
                    <th>user</th>
                    <th>prompt</th>
                </tr>
                <?php if(!empty($notAccepted)) {
                    foreach($notAccepted as $prompt):?>
                <tr>
                    <td><?php echo htmlspecialchars($prompt["username"])?></td>
                    <td><?php echo htmlspecialchars($prompt["title"])?></td>
                    <td><a href="promptsDetailM.php?prompt=<?php echo $prompt["id"]?>">See Details</a></td>
                </tr>
                <?php endforeach;
                }  ?>
            </table>
        </section>
        <section class="reportedPrompts">
            <h2>Reported Prompts</h2>
            <table>
                <tr>
                    <th>user</th>
                    <th>prompt</th>

                </tr>
                <?php if(!empty($reported)) {
                    foreach($reported as $prompt):?>
                <tr>
                    <td><?php echo htmlspecialchars($prompt["username"])?></td>
                    <td><?php echo htmlspecialchars($prompt["title"])?></td>
                    <td><a href="reportedPrompt.php?prompt=<?php echo $prompt["id"]?>">See Details</a></td>
                </tr>
                <?php endforeach;
                }  ?>
            </table>

        </section>
    </div>
</body>
</html>