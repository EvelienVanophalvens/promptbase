<?php
include_once(__DIR__."/bootstrap.php");
include_once(__DIR__."/navbar.php");


$notifications = Notifications::getNotifications($_SESSION['userid']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
</head>
<body>
    <h2>Your notifications</h2>
    <?php if(!empty($notifications)):
        foreach($notifications as $notification):?>
    <div class="notification">
        <p><?php echo htmlspecialchars($notification["title"])?></p>
        <p><?php echo htmlspecialchars($notification["date"])?></p>
        <p><?php echo ($notification["message"])?></p>
    </div>
    <?php endforeach;?>
    <?php else:?>
    <p>You have no notifications</p>
    <?php endif;?>
</body>
</html>