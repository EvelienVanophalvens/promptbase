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
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("insert into favourits (promptId, userId) values (:promptid, :userid)");
        $statement->bindValue(":promptid", $this->getPromptId());
        $statement->bindValue(":userid", $this->getUserId());
        return $statement->execute();
    }

    public function removeFavourite(){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("DELETE FROM favourits WHERE promptId = :promptid AND userId = :userid");
        $statement->bindValue(":promptid", $this->getPromptId());
        $statement->bindValue(":userid", $this->getUserId());
        return $statement->execute();
    }

    public static function getFavourites($promptId, $userId){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT * FROM favourits WHERE promptId = :promptid AND userId = :userid");
        $statement->bindValue(":promptid", $promptId);
        $statement->bindValue(":userid", $userId);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}