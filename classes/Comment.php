<?php
    class Comment {
        private $promptId;
        private $userId;
        private $comment;

        /**
         * Get the value of postId
         */ 
        public function getPromptId()
        {
                return $this->promptId;
        }

        /**
         * Set the value of postId
         *
         * @return  self
         */ 
        public function setPromptId($promptId)
        {
                $this->promptId = $promptId;

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
         * Get the value of comment
         */ 
        public function getComment()
        {
                return $this->comment;
        }

        /**
         * Set the value of comment
         *
         * @return  self
         */ 
        public function setComment($comment)
        {
                $this->comment = $comment;

                return $this;
        }

        public function save(){
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO prompt_comments (promptId, userId, comment)VALUES (:prompt, :user, :comment);");
            $statement->bindValue(":prompt", $this ->promptId);
            $statement->bindValue(":user", $this -> userId);
            $statement->bindValue(":comment", $this -> comment);
            $statement->execute();
        }


        public static function getAllComments($promptId){
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT prompt_comments.id AS commitId, prompt_comments.promptId, prompt_comments.userId, prompt_comments.comment, users.id, users.username, users.profilePicture FROM `prompt_comments`LEFT JOIN users ON prompt_comments.userId= users.id WHERE prompt_comments.promptId = :prompt;");
            $statement->bindValue(":prompt", $promptId);
            $statement->execute();
            $allComments = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $allComments;
        } 
        public static function getLastComment($promptId){
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT prompt_comments.id AS commitId, prompt_comments.promptId, prompt_comments.userId, prompt_comments.comment, users.id, users.username, users.profilePicture FROM `prompt_comments`LEFT JOIN users ON prompt_comments.userId= users.id WHERE prompt_comments.promptId = :prompt ORDER BY commitId DESC LIMIT 1;");
            $statement->bindValue(":prompt", $promptId);
            $statement->execute();
            $lastComment = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $lastComment;
        }   
    }