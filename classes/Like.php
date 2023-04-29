<?php
    class Like {
        private $promptId;
        private $userId;

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

        public function save(){

            // @todo: hook in a new function that checks if a user has already liked a post

            $conn = Dbm::getInstance();
            $statement = $conn->prepare("insert into prompt_likes (promptId, userId, date) values (:promptid, :userid, NOW())");
            $statement->bindValue(":promptid", $this->getPromptId());
            $statement->bindValue(":userid", $this->getUserId());
            return $statement->execute();
        }
    }