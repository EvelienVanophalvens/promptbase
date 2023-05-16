<?php 
include_once(__DIR__."/../bootstrap.php");
include_once(__DIR__."/navbarM.php");

User::isAdmin();
$accepted = User::acceptedModerators();

//add moderator
if (isset($_POST['add'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $add = User::addModerator($username, $email);
}


//remove moderator
if (isset($_POST['remove'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $remove = User::removeModerator($username, $email);
}


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
                <th>Action</th>
            </tr>
            <?php if (!empty($accepted)) {
    foreach ($accepted as $moderator) : ?>
        <tr>
            <form action="" method="POST">
                <td><?php echo htmlspecialchars($moderator["username"]) ?></td>
                <td><?php echo htmlspecialchars($moderator["email"]) ?></td>
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($moderator["username"]) ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($moderator["email"]) ?>">
                <td><input type="submit" name="remove" id="remove" value="Remove"></td>
            </form>
        </tr>
    <?php endforeach;
} ?>

        </table>
    
    <hr>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="usernameM" placeholder="username">
        <label for="email">Email:</label>
        <input type="email" name="email" id="emailM" placeholder="email">
        <input type="submit" name="add" id="add" value="Add">
    </form>

        
</div>
</body>
</html>