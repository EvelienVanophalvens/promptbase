<?php

class User
{
    private string $username;
    private string $email;
    private string $password;
    private string $bio;
    private array $errors;
    public int $userId;
    public string $verified;


    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;

    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        if(empty($username)) {
            throw new Exception("Please, don't forget your username!");
        } else {
            $this->username = $username;
        }

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        if(empty($email)) {
            throw new Exception("Please, don't forget your email!");
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Sorry, this is a invalid email.");
        } else {
            $this->email = $email;
        }
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        if(empty($password)) {
            throw new Exception("Please, don't forget your password!");
        } else {
            $options = [
                'cost' => 14,
            ];
            $this->password = password_hash($password, PASSWORD_DEFAULT, $options);

            return $this;
            ;
        }

    }

    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the value of errors
     *
     * @return  self
     */
    public function setErrors($errors)
    {

        $this->errors = $errors;

        return $this;
    }

    /**
     * Get the value of bio
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set the value of bio
     *
     * @return  self
     */
    public function setBio($bio)
    {
        if(empty($bio)) {
            throw new Exception("Please, don't forget your bio!");
        } else {
            $this->bio = $bio;
        }

        return $this;
    }

      /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }


        /**
     * Get the value of verified
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * Set the value of verified
     *
     * @return  self
     */
    public function setVerified($verified)
    {

        $this->verified = $verified;

        return $this;
    }

    //FUNCTIES
    public function save()
    {
        $conn = Db::getInstance();
        //query voorbereiden voor beveiligd te worden = statement
        $statement = $conn->prepare("INSERT INTO users (username, email, password, active, moderator, credits, verified, verify_token) VALUES (:username, :email, :password, 0, 0, 0, 0, :verify);");
        $statement->bindValue(":username", $this -> username); // beveiliging sql injection
        $statement->bindValue(":email", $this -> email);
        $statement->bindValue(":password", $this -> password);
        $statement->bindValue(":verify", $this -> verified);
        $statement->execute();
    }

    public static function update($bio)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET bio=:bio WHERE id = :id");
        $statement->bindParam(":bio", $bio);
        $statement->bindValue(":id", $_SESSION['userid']);
        $statement->execute();
    }

    public static function login($username, $password)
    {
        //checken of de gebruiker bestaat
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindValue(":username", $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);


        //als de gebruiker bestaat, checken of het wachtwoord klopt
        if($user) {
            $hash = $user['password'];
            if(password_verify($password, $hash)) {

                if($user['verified'] == 1) {
                    $_SESSION['authenticated'] = true;
                    $_SESSION['auth_user'] = [
                        'username' => $user['username'],

                    ];
                    $_SESSION['userid'] = $user['id'] ;
                    $_SESSION['status'] = "Login Successfull";
                    header("Location: index.php");
                } else {
                    $_SESSION['status'] = "Please Verify your Email Address to Login.";
                    header("Location: login.php");
                }
            } else {
                return false;

            }
        } else {
            return false;

        }
    }

    //kijken of gebruiker een moderator is
    public static function isModerator()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE id = :id AND moderator = 1");
        $statement->bindValue(":id", $_SESSION['userid']);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if($user) {
            return true;
        } else {
            return false;
        }

      
    }

    public static function isModeratorM()
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE id = :id AND moderator = 1");
        $statement->bindValue(":id", $_SESSION['userid']);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if($user) {
            return true;
        } else {
            return false;
        }

      
    }


    //kijken of gebruiker een admin is
    public static function isAdmin()
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE id = :id AND moderator = 1");
        $statement->bindValue(":id", $_SESSION['userid']);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if($user) {
            return true;
        } else {
            return false;
        }
    }

    //update profile picture
    public static function updateProfilePicture($profilePicture)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET profilePicture=:profile_picture WHERE id = :id");
        $statement->bindParam(":profile_picture", $profilePicture);
        $statement->bindParam(":id", $_SESSION['userid']);
        $statement->execute();
    }

    //get profile picture
    public static function getProfilePicture()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT profilePicture FROM users WHERE id = :id");
        $statement->bindParam(":id", $_SESSION['userid']);
        $statement->execute();
        $profilePicture = $statement->fetch(PDO::FETCH_ASSOC);
        return $profilePicture['profilePicture'];
    }
    //get profile picture
    public static function getRecentBio()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT bio FROM users WHERE id = :id");
        $statement->bindParam(":id", $_SESSION['userid']);
        $statement->execute();
        $bio = $statement->fetch(PDO::FETCH_ASSOC);
        return implode($bio);
    }

    // public static function changePassword($email, $password){
    //     $conn = Db::getInstance();
    //     $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    //     $statement = $conn-> prepare("UPDATE users SET password=:password WHERE email=:email");
    //     $statement->bindValue(":password", $hashed_password);
    //     $statement->bindValue(":email", $email);
    //     $statement->execute();
    //     return true;
    // }



    public static function deleteUser()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("DELETE FROM users WHERE id = :id LIMIT 1");
        $statement->bindValue(":id", $_SESSION['userid']);
        $statement->execute();
    }

    public static function getUserByEmail($email)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT email FROM users WHERE email= :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if($user) {
            //als er een user te vinden is zal het true weergeven anders false
            return true;
        } else {
            return false;
        }
    }

    public static function getUser($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public static function verifiedEmail($token)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT verify_token, verified FROM users WHERE verify_token = :token LIMIT 1");
        $statement->bindValue(":token", $token);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if($user['verified'] == 0) {
            $statement = $conn->prepare("UPDATE users SET verified = 1 WHERE verify_token = :token");
            $statement->bindValue(":token", $token);
            $statement->execute();
            return true;
        } else {
            return false;
        }


    }
    public static function earnCredits($userId){   
    // Het credits aantal verhogen met 20
    $conn = Dbm::getInstance();
    $statement = $conn->prepare("UPDATE users SET credits = credits + 20 WHERE id = :user");
    $statement->bindValue(":user", $userId);
    $statement->execute();

    // Het actieve status van de gebruiker ophalen
    $conn = Dbm::getInstance();
    $statement = $conn->prepare("SELECT active FROM users WHERE id = :user");
    $statement->bindValue(":user", $userId);
    $statement->execute();
    $active = $statement->fetch(PDO::FETCH_ASSOC)['active'];

    //Telt het aantal rijen van de specifieke gebruiker
    $conn = Dbm::getInstance();
    $statement = $conn->prepare("SELECT COUNT('accepted') AS 'accepted' FROM `prompts` WHERE accepted = 1 and userId = :user");
    $statement->bindValue(":user", $userId);
    $statement->execute();
    $count = $statement->fetch(PDO::FETCH_ASSOC)['accepted'];
    

    // Als earn_count >= 3, active op 1 zetten als het nog niet actief is
    if ($count >= 3 && $active == 0) {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE users SET active = 1 WHERE id = :user");
        $statement->bindValue(":user", $userId);
        $statement->execute();
    } elseif($count >= 3 && $active == 1) {
        // Als earn_count < 3 en active al op 1 staat
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE users SET active = 1 WHERE id = :user");
        $statement->bindValue(":user", $userId);
        $statement->execute();
    }elseif($count < 3 && $active == 1){
        // Als earn_count < 3 of al actief, active op 0 zetten
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE users SET active = 0 WHERE id = :user");
        $statement->bindValue(":user", $userId);
        $statement->execute();
    }else{
        // Als earn_count < 3 of al actief, active op 0 zetten
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE users SET active = 0 WHERE id = :user");
        $statement->bindValue(":user", $userId);
        $statement->execute();
    } 
      
    }

    public static function reportedUsers(){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT * FROM reported_users LEFT JOIN users ON reported_users.userId = users.id");
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public static function approveUser($userId){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("DELETE FROM reported_users WHERE userId = :user");
        $statement->bindValue(":user", $userId);
        $statement->execute();
    }

    public static function blockedUsers(){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE verified = 2");
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public static function blockUser($userId){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE users SET verified = 2 WHERE id = :user");
        $statement->bindValue(":user", $userId);
        $statement->execute();
    }

    public static function unblockUser($userId){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE users SET verified = 1 WHERE id = :user");
        $statement->bindValue(":user", $userId);
        $statement->execute();
    }

    public static function removeReportedUser($userId){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("DELETE FROM reported_users WHERE userId = :user");
        $statement->bindValue(":user", $userId);
        $statement->execute();
    }

    public static function buy($user, $credit, $userCredits){
        $paid = $userCredits - $credit;

        if($paid < 0){
            return false;
        }else{
            $conn = Db::getInstance();
            $statement = $conn->prepare("UPDATE users SET credits = :paid WHERE id = :user");
            $statement->bindValue(":paid", $paid);
            $statement->bindValue(":user", $user);
            $statement->execute();
            return true;
        }

    }


    //credits verhogen met 25, 50 of 100
    public static function addCredits($userId, $credits)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET credits = credits + :credits WHERE id = :user");
        $statement->bindValue(":credits", $credits);
        $statement->bindValue(":user", $userId);
        $statement->execute();
    }
    

    public static function acceptedModerators(){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE moderator = 1");
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public static function addModerator($username, $email){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE users SET moderator = 1 WHERE username = :username AND email = :email");
        $statement->bindValue(":username", $username);
        $statement->bindValue(":email", $email);
        $statement->execute();
    }

    public static function removeModerator($username, $email){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE users SET moderator = 0 WHERE username = :username AND email = :email");
        $statement->bindValue(":username", $username);
        $statement->bindValue(":email", $email);
        $statement->execute();
    }


    public static function getFollow($userId, $loggedInUserId)
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("INSERT INTO user_follow (userId, followId) VALUES (:userId, :followerId)");
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":followerId", $_SESSION['userid']);
        $statement->execute();
    }

 

    public static function isFollowingUser($loggedInUserId, $userId)
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT * FROM user_follow WHERE userId = :userId AND followId = :followerId");
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":followerId", $loggedInUserId);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

  public static function updateCredits($credits){
    $conn = Db::getInstance();
    $statement = $conn->prepare("UPDATE users SET credits = :credits WHERE id = :id");
    $statement->bindValue(":credits", $credits);
    $statement->bindValue(":id", $_SESSION['userid']);
    $statement->execute();
  }

  public static function getCredit(){
    $conn = Db::getInstance();
    $statement = $conn->prepare("SELECT credits FROM users WHERE id = :id");
    $statement->bindValue(":id", $_SESSION['userid']);
    $statement->execute();
    $credits = $statement->fetch(PDO::FETCH_ASSOC);
    return $credits['credits'];
  }

  //update the credits by adding 25, 50 or 100
  public static function updateBuyCredit($credits) {
    $conn = Db::getInstance();
    $statement = $conn->prepare("UPDATE users SET credits = credits + :credits WHERE id = :id");
    $statement->bindValue(":credits", $credits);
    $statement->bindValue(":id", $_SESSION['userid']);
    $statement->execute();
}


  public static function updateCreditsOwner($userId) {
    $conn = Db::getInstance();
    $statement = $conn->prepare("UPDATE users SET credits = credits + 5 WHERE id = :id");
    $statement->bindParam(':id', $userId);
    $statement->execute();
}


}
