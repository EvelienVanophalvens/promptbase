<?php

class User{
    private string $email;
    private string $password;
    private array $errors;


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
        $this->password = $password;

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
        $statement = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password);");
        $statement->bindValue(":email", $this -> email); // beveiliging sql injection
        $statement->bindValue(":password", $this -> password);
        $statement->execute();
    }
}