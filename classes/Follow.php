<?php

class Follow{
    private int $userId;
    private int $followerId;

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
     * Get the value of followerId
     */
    public function getFollowerId()
    {
        return $this->followerId;
    }
    public function setFollowerId($followerId){
        $this->followerId = $followerId;
        return $this;
    }

    public function save()
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("INSERT INTO user_follow (userId, followId) VALUES (:userid, :followerid)");
        $statement->bindValue(":userid", $this->getUserId());
        $statement->bindValue(":followerid", $this->getFollowerId());
        return $statement->execute();
    }

    public static function  removeFollow($userId, $loggedInUserId)
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("DELETE FROM user_follow WHERE userId = :userId AND followId = :followerId");
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":followerId", $_SESSION['userid']);
        $statement->execute();
    }
}