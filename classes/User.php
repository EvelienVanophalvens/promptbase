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
        var_dump("hello");

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
                    header("Location: home.php");
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



}
