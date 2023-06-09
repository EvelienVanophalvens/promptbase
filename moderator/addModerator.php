<?php 
include_once(__DIR__."/../bootstrap.php");
User::isAdmin();
if(!empty($_POST) && isset($_POST["remove"])){
    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $remove = User::removeModerator($username, $email);
    header("Location: addModerator.php");
    exit;
}
include_once(__DIR__."/navbarM.php");


$accepted = User::acceptedModerators();


$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

$add = User::addModerator($username, $email);
$remove = User::removeModerator($username, $email);




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
            <td><?php echo htmlspecialchars($moderator["username"]) ?></td>
            <td><?php echo htmlspecialchars($moderator["email"]) ?></td>
            <td>
                <form action="" method="POST">
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($moderator["username"]) ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($moderator["email"]) ?>">
                    <input type="submit" name="remove" id="remove" value="Remove">
                </form>
            </td>
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

<script>
const addBtn = document.querySelector('#add');
addBtn.addEventListener('click', (event) => {
    event.preventDefault();

    const formData = new FormData();
    const username = document.querySelector('#usernameM').value;
    const email = document.querySelector('#emailM').value;
    formData.append('username', username);
    formData.append('email', email);
    console.log(username);
    console.log(email);
    fetch('../ajax/addModerator.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // Reload the page to display the updated list
            location.reload();
        });
});

const removeBtn = document.querySelector('#remove');
removeBtn.addEventListener('click', (event) => {
    event.preventDefault();

    const formData = new FormData();
    const username = document.querySelector('#usernameM').value;
    const email = document.querySelector('#emailM').value;
    formData.append('username', username);
    formData.append('email', email);
    console.log(username);
    console.log(email);
    fetch('../ajax/removeModerator.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        });
});
</script>

</body>
</html>
