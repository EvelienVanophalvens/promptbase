<?php

class Follow{
    private int $followerId;
    private int $followingId;
    private int $userId;

    /**
     * Get the value of followerId
     */ 
    public function getFollowerId()
    {
        return $this->followerId;
    }

    /**
     * Set the value of followerId
     *
     * @return  self
     */ 
    public function setFollowerId($followerId)
    {
        $this->followerId = $followerId;

        return $this;
    }

    /**
     * Get the value of followingId
     */ 
    public function getFollowingId()
    {
        return $this->followingId;
    }

    /**
     * Set the value of followingId
     *
     * @return  self
     */ 
    public function setFollowingId($followingId)
    {
        $this->followingId = $followingId;

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

    public function save(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into follow (follower_Id, following_Id) values (:follower_Id, :following_Id)");
        $statement->bindValue(":follower_Id", $this->getFollowerId());
        $statement->bindValue(":following_Id", $this->getFollowingId());
        return $statement->execute();
    }

    public static function checkFollow($follower_id, $followed_id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM follows WHERE follower_Id = :follower_Id AND following_Id = :following_Id");
        $statement->bindValue(":follower_Id", $follower_id);
        $statement->bindValue(":following_Id", $followed_id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result){
            return true;
        } else {
            return false;
        }
    }

    public static function insertFollow($follower_id, $followed_id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO follows (follower_Id, following_Id) VALUES (:follower_Id, :following_Id)");
        $statement->bindValue(":follower_Id", $follower_id);
        $statement->bindValue(":following_Id", $followed_id);
        $statement->execute();
    }

    public static function deleteFollow($follower_id, $followed_id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("DELETE FROM follows WHERE follower_Id = :follower_Id AND following_Id = :following_Id");
        $statement->bindValue(":follower_Id", $follower_id);
        $statement->bindValue(":following_Id", $followed_id);
        $statement->execute();
    }

    public static function getFollowerCount($userId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT COUNT(follower_Id) FROM follows WHERE following_Id = :following_Id");
        $statement->bindValue(":following_Id", $userId);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

  
}