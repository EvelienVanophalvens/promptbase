<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">

</head>
<body>
    <nav>
        <div>
            <ul class="logo">
                <li>
                    <a href="home.php">
                        <img src="uploads/logo.png" alt="collectivePrompts">
                    </a>
                </li>
            </ul>
        </div>
        <ul class="navigation">
        <?php ob_start(); ?>
           <li>
                <form action="filteredByCategory.php" method="get" autocomplete="off" id="search-form">
                    <input type="text" name="search" id="search" placeholder="Search" value="<?php if(isset($_GET['search'])) {
                        echo htmlspecialchars($_GET['search']);
                    }?>">
                </form>
            </li>   
            <li>
                <a href="upload.php">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.49984 31.3334C3.44567 31.3334 2.54324 30.958 1.79255 30.2073C1.04185 29.4566 0.666504 28.5542 0.666504 27.5V21.75H4.49984V27.5H27.4998V21.75H31.3332V27.5C31.3332 28.5542 30.9578 29.4566 30.2071 30.2073C29.4564 30.958 28.554 31.3334 27.4998 31.3334H4.49984ZM14.0832 23.6667V8.04585L9.09984 13.0292L6.4165 10.25L15.9998 0.666687L25.5832 10.25L22.8998 13.0292L17.9165 8.04585V23.6667H14.0832Z" fill="#E8E7E7"/>
                    </svg>
                </a>
            </li>
            <li>
                <div class="dropdown">
                    <button class="dropbtn">    
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.21266 29.775C9.84183 28.5291 11.6627 27.5469 13.6752 26.8281C15.6877 26.1094 17.796 25.75 20.0002 25.75C22.2043 25.75 24.3127 26.1094 26.3252 26.8281C28.3377 27.5469 30.1585 28.5291 31.7877 29.775C32.9057 28.4653 33.7762 26.9798 34.3991 25.3187C35.022 23.6576 35.3335 21.8847 35.3335 20C35.3335 15.7514 33.8401 12.1337 30.8533 9.14685C27.8665 6.16005 24.2488 4.66665 20.0002 4.66665C15.7516 4.66665 12.1338 6.16005 9.14704 9.14685C6.16023 12.1337 4.66683 15.7514 4.66683 20C4.66683 21.8847 4.97829 23.6576 5.6012 25.3187C6.22412 26.9798 7.09461 28.4653 8.21266 29.775ZM20.0002 21.9166C18.1154 21.9166 16.5262 21.2698 15.2325 19.976C13.9387 18.6823 13.2918 17.093 13.2918 15.2083C13.2918 13.3236 13.9387 11.7344 15.2325 10.4406C16.5262 9.14686 18.1154 8.49998 20.0002 8.49998C21.8849 8.49998 23.4741 9.14686 24.7679 10.4406C26.0616 11.7344 26.7085 13.3236 26.7085 15.2083C26.7085 17.093 26.0616 18.6823 24.7679 19.976C23.4741 21.2698 21.8849 21.9166 20.0002 21.9166ZM20.0002 39.1666C17.3488 39.1666 14.8571 38.6635 12.5252 37.6573C10.1932 36.651 8.16475 35.2854 6.43975 33.5604C4.71475 31.8354 3.34912 29.8069 2.34287 27.475C1.33662 25.143 0.833496 22.6514 0.833496 20C0.833496 17.3486 1.33662 14.8569 2.34287 12.525C3.34912 10.193 4.71475 8.16456 6.43975 6.43956C8.16475 4.71456 10.1932 3.34894 12.5252 2.34269C14.8571 1.33644 17.3488 0.833313 20.0002 0.833313C22.6516 0.833313 25.1432 1.33644 27.4752 2.34269C29.8071 3.34894 31.8356 4.71456 33.5606 6.43956C35.2856 8.16456 36.6512 10.193 37.6575 12.525C38.6637 14.8569 39.1668 17.3486 39.1668 20C39.1668 22.6514 38.6637 25.143 37.6575 27.475C36.6512 29.8069 35.2856 31.8354 33.5606 33.5604C31.8356 35.2854 29.8071 36.651 27.4752 37.6573C25.1432 38.6635 22.6516 39.1666 20.0002 39.1666ZM20.0002 35.3333C21.6932 35.3333 23.2904 35.0857 24.7918 34.5906C26.2932 34.0955 27.6668 33.3847 28.9127 32.4583C27.6668 31.5319 26.2932 30.8212 24.7918 30.326C23.2904 29.8309 21.6932 29.5833 20.0002 29.5833C18.3071 29.5833 16.7099 29.8309 15.2085 30.326C13.7071 30.8212 12.3335 31.5319 11.0877 32.4583C12.3335 33.3847 13.7071 34.0955 15.2085 34.5906C16.7099 35.0857 18.3071 35.3333 20.0002 35.3333ZM20.0002 18.0833C20.8307 18.0833 21.5175 17.8118 22.0606 17.2687C22.6036 16.7257 22.8752 16.0389 22.8752 15.2083C22.8752 14.3778 22.6036 13.691 22.0606 13.1479C21.5175 12.6048 20.8307 12.3333 20.0002 12.3333C19.1696 12.3333 18.4828 12.6048 17.9397 13.1479C17.3967 13.691 17.1252 14.3778 17.1252 15.2083C17.1252 16.0389 17.3967 16.7257 17.9397 17.2687C18.4828 17.8118 19.1696 18.0833 20.0002 18.0833Z" fill="#E8E7E7"/>
                        </svg>
                    </button> 
                    <div class="dropdown-content">
                        <a href="profile.php">Mijn account</a>
                        <?php if(User::isModerator()) {
                            echo "<a href='./moderator/moderator.php'>Moderator</a>";
                        } else {
                            echo "";
                        }?>
                        <a href="logout.php">Log out</a>
                    </div>
                </div> 
            </li>
            <li>
                <a href="profile.php">
                </a>
            </li>
        </ul>
        
    </nav>
    <script>
        const inputFields = document.querySelectorAll("input, textearea");
        console.log(inputFields);
        inputFields.forEach((inputFields) =>{
            inputFields.addEventListener("keydown", (event)=>{
                if(event.target.id === "search"){
                    return;
                }else{
                    event.preventDefault();
                }
            })
        })

    
    </script>

</body>
</html>

