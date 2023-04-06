<?php

class User{
    private string $username;
    private string $email;
    private string $password;
    private array $errors;

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
        $this->username = $username;

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
        $options = [
            'cost' => 14,
        ];
        $this->password = password_hash($password, PASSWORD_DEFAULT, $options);

        return $this;
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

    //FUNCTIES
    public function save(){
        $conn = Db::getInstance();
        //query voorbereiden voor beveiligd te worden = statement
        $statement = $conn->prepare("INSERT INTO users (username, email, password, active, moderator, credits, verified) VALUES (:username, :email, :password, 0, 0, 0, 0);");
        $statement->bindValue(":username", $this -> username); // beveiliging sql injection
        $statement->bindValue(":email", $this -> email);
        $statement->bindValue(":password", $this -> password);
        $statement->execute();
    }

    public static function login($username, $email, $password){
        //checken of de gebruiker bestaat
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        

        //als de gebruiker bestaat, checken of het wachtwoord klopt
        if($user){
			$hash = $user['password'];
			if(password_verify($password, $hash)){
				return true;
			}else{
                return var_dump("wrong password");
			}
		}else{
			return false;
            
		}
    }

    public static function update($email, $password){
        $conn = Db::getInstance();
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $statement = $conn-> prepare("UPDATE users SET password=:password WHERE email=:email");
        $statement->bindValue(":password", $hashed_password);
        $statement->bindValue(":email", $email);
        $statement->execute();
    }

    
    }

