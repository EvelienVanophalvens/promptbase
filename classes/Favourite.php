<?php

class Favourite{
    private int $userId;
    private int $promptId;

    
    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }
    public function setUserId($userId){
        $this->userId = $userId;
        return $this;
    }
    /**
     * Get the value of promptId
     */
    public function getPromptId()
    {
        return $this->promptId;
    }
    public function setPromptId($promptId){
        $this->promptId = $promptId;
        return $this;
    }

    public function save(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into favourits (userId, promptId) values (:userid, :promptid)");
        $statement->bindValue(":userid", $this->getUserId());
        $statement->bindValue(":promptid", $this->getPromptId());
        return $statement->execute();
    }

    public function removeFavourite(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("DELETE FROM favourits WHERE userId = :userid AND promptId = :promptid");
        $statement->bindValue(":userid", $this->getUserId());
        $statement->bindValue(":promptid", $this->getPromptId());
        return $statement->execute();
    }

    public static function getFavouritePrompt($userId, $promptId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM favourits WHERE userId = :userid AND promptId = :promptid");
        $statement->bindValue(":userid", $userId);
        $statement->bindValue(":promptid", $promptId);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result){
            return true;
        }else{
            return false;
        }
    }
}