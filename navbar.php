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
        <div></div>
        <ul>
            <li>
                <a href="home.php">Home</a>
            </li>
            <li>
                <form action="filteredByCategory.php" method="POST">
                    <input type="text" name="search" id="search" value="search">
                </form>
            </li>
            <li>
                <a href="upload.php">Upload</a>
            </li>
            <li>
                <div class="dropdown">
                    <button class="dropbtn">                    
                        <svg viewBox="0 0 50 50" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><circle cx="25" cy="25" fill="none" r="24" stroke="#ffffff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" class="stroke-000000"></circle><path fill="none" d="M0 0h50v50H0z"></path><path d="M29.933 35.528c-.146-1.612-.09-2.737-.09-4.21.73-.383 2.038-2.825 2.259-4.888.574-.047 1.479-.607 1.744-2.818.143-1.187-.425-1.855-.771-2.065.934-2.809 2.874-11.499-3.588-12.397-.665-1.168-2.368-1.759-4.581-1.759-8.854.163-9.922 6.686-7.981 14.156-.345.21-.913.878-.771 2.065.266 2.211 1.17 2.771 1.744 2.818.22 2.062 1.58 4.505 2.312 4.888 0 1.473.055 2.598-.091 4.21-1.261 3.39-7.737 3.655-11.473 6.924 3.906 3.933 10.236 6.746 16.916 6.746s14.532-5.274 15.839-6.713c-3.713-3.299-10.204-3.555-11.468-6.957z" fill="#ffffff" class="fill-000000"></path></svg>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    
                    <div class="dropdown-content">
                        <a href="profile.php">Mijn account</a>
                        <?php if(User::isModerator()){
                            echo "<a href='./moderator/moderator.php'>Moderator</a>";
                        }else{
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
</body>
</html>

