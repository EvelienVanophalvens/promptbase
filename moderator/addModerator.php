<?php 
include_once(__DIR__."/../bootstrap.php");
include_once(__DIR__."/navbarM.php");

User::isAdmin();
$accepted = User::acceptedModerators();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<div class="content">
<a href="moderator.php" id="backbtn">< BACK TO OVERVIEW</a>

    <h1>Moderator</h1>
    <h2>Newest moderators</h2>
    <hr>
    <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>action</th>
            </tr>
            <?php if(!empty($accepted)) {
                foreach($accepted as $moderator):?>
            <tr>
                <td><?php echo htmlspecialchars($moderator["username"])?></td>
                <td><?php echo htmlspecialchars($moderator["email"])?></td>
                <td><a class="blackBtn" href="deleteModerator.php?id=<?php echo htmlspecialchars($moderator["id"])?> ">Remove</a></td>
            </tr>
            <?php endforeach;
            }  ?>
        </table>
    
    <hr>
    <h2>Add a moderator</h2>
    <form action="addModerator.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" type="text" id="username" name="username">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="text" id="email" name="email">
        </div>
        <input class="blackBtn" type="submit" value="Add moderator">

        
</div>
</body>
</html>