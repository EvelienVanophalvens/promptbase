<?php
include_once(__DIR__."/../bootstrap.php");
include_once(__DIR__."/navbarM.php");
if(User::isAdmin() === false) {
    header("Location: ../error.php");
    echo "you are not a moderator";
}

$notAccepted =  Prompts::notAccepted();



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
    <section class="askedPrompts">
        <h2>New sended prompts</h2>
        <table>
            <tr>
                <th>user</th>
                <th>prompt</th>
                <th>action</th>
            </tr>
            <?php if(!empty($notAccepted)) {
                foreach($notAccepted as $prompt):?>
            <tr>
                <td><?php echo htmlspecialchars($prompt["username"])?></td>
                <td><?php echo htmlspecialchars($prompt["prompt"])?></td>
                <td><a href="promptsDetailM.php?prompt=<?php echo $prompt["id"]?>">See Details</a></td>
            </tr>
            <?php endforeach;
            }  ?>
        </table>
    </section>
    <section class="reportedPrompts">
        <h2>ReportedPrompts</h2>
    </section>
</body>
</html>