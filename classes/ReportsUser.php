<?php
    class ReportsUser{
        private int $promptId;
        private int $userId;
        private string $reason;

        /**
         * Get the value of promptId
         */ 
        public function getPromptId()
        {
                return $this->promptId;
        }

        /**
         * Set the value of promptId
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
         * Get the value of reason
         */ 
        public function getReason()
        {
                return $this->reason;
        }

        /**
         * Set the value of reason
         *
         * @return  self
         */ 
        public function setReason($reason)
        {
            if(!empty($reason)){
                $this->reason = $reason;
                return $this;
            } else { 
                throw new Exception("Please fill in a reason");
            }
        }

        public function save(){
            $conn = Db::getInstance();
            $statement = $conn->prepare("insert into reported_users (userId, reason) values (:userid, :reason)");
            $statement->bindValue(":userid", $this->getUserId());
            $statement->bindValue(":reason", $this->getReason());
            return $statement->execute();
        }
    }