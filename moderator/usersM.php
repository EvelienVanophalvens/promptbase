<?php 
include_once(__DIR__."/../bootstrap.php");
include_once(__DIR__."/navbarM.php");
authenticated();
User::isAdmin();

$reportedUsers = User::reportedUsers();
$blockedUsers = User::blockedUsers();

if(!empty($_POST) && isset($_POST["approve"])) {
    $user = User::approveUser($_POST["id"]);
    
    header("Location: usersM.php");
    exit;
}

if(!empty($_POST) && isset($_POST["unblock"])) {
    var_dump($_POST["id"]);
    $user = User::unblockUser($_POST["id"]);
    header("Location: usersM.php");
    exit;
}





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
<a href="../home.php" id="backbtn">< BACK TO OVERVIEW</a>
    <section class="reportedUsers">
        <h2>Reported Users</h2>
        <table>
            <tr>
                <th>username</th>
                <th>reason</th>
                <th>profile</th>
                <th>action</th>
            </tr>
            <?php if(!empty($reportedUsers)) {
                foreach($reportedUsers as $reportedUser):?>
            <tr>
                <td><?php echo htmlSpecialChars($reportedUser["username"]) ?></td>
                <td><?php echo htmlSpecialChars($reportedUser["reason"]) ?></td>
                <td><a href="../accountViewM.php?user=<?php echo $reportedUser["id"];?>">See the profile</a></td>
                <td><form method="POST"><input type=hidden name="id" value="<?php echo $reportedUser["id"]?>"><input type="submit" name="approve" value="approve"> </form><button id="" class="blackBtn block" data-id=<?php echo $reportedUser["id"]?>>Block</button></td>
            </tr>
            <?php endforeach;
            }  ?>
        </table>
    </section>
    <section class="blockedUsers">
        <h2>blocked Users</h2>
        <table id="blockedUser">
            <tr>
                <th>username</th>
                <th>email</th>
                <th>action</th>
            </tr>
            <?php if(!empty($blockedUsers)) {
                foreach($blockedUsers as $blockedUser):?>
            <tr >
                <td id="blockedUsername"><?php echo htmlspecialchars($blockedUser["username"])?></td>
                <td id="blockedEmail"><?php echo htmlspecialchars($blockedUser["email"])?></td>
                <td id="unblockBtn"><form method="POST"><input type=hidden name="id" value=<?php echo $blockedUser["id"]?>><input type=submit name="unblock" value ="unblock"></form></td>
            </tr>
            <?php endforeach;
            }  ?>
        </table>
    </section>
</div>
</body>

<script>
    let block = document.querySelectorAll(".block");

    for(var i = 0; i < block.length; i++){
    block[i].addEventListener("click", function(e) {
        e.preventDefault();
        let id = this.getAttribute("data-id");
        console.log(id);
        let formData = new FormData();
        formData.append("userId", id);
        fetch("../ajax/blockUser.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            this.closest("tr").remove();


            console.log(result);
            const blockedUser = document.querySelector("#blockedUser");
            const blockedUsername = document.querySelector("#blockedUsername");
            const blockedEmail = document.querySelector("#blockedEmail");
            const unblockBtn = document.querySelector("#unblockBtn");

            const blockedUserRow = document.createElement("tr");

            const blockedUsernameData = document.createElement("td");
            blockedUsernameData.innerHTML = result.blockedUsers[result.blockedUsers.length - 1].username;
            blockedUsernameData.setAttribute("id", "blockedUsername");
            blockedUserRow.appendChild(blockedUsernameData);

            const blockedEmailData = document.createElement("td");
            blockedEmailData.innerHTML = result.blockedUsers[result.blockedUsers.length - 1].email;
            blockedEmailData.setAttribute("id", "blockedEmail");
            blockedUserRow.appendChild(blockedEmailData);

            const unblockBtnData = document.createElement("td");
            const btn = document.createElement("button");
            btn.setAttribute("id", "unblock");
            btn.setAttribute("class", "blackBtn");
            btn.setAttribute("data-id", result.blockedUsers[result.blockedUsers.length - 1].id);
            btn.innerHTML = "Unblock user";
            unblockBtnData.appendChild(btn);
            blockedUserRow.appendChild(unblockBtnData);

            blockedUser.appendChild(blockedUserRow);
        })
        .catch(error => {
            console.error("Error:", error);
        });

        

    });
    }

</script>

</html>

