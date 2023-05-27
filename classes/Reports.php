<?php
    class Reports{
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
            $statement = $conn->prepare("insert into reported_prompts (promptId, userId, reason) values (:promptid, :userid, :reason)");
            $statement->bindValue(":promptid", $this->getPromptId());
            $statement->bindValue(":userid", $this->getUserId());
            $statement->bindValue(":reason", $this->getReason());
            return $statement->execute();
        }

        public static function getReportedPrompts(){
            $conn = Dbm::getInstance();
            $statement = $conn->prepare("SELECT * from reported_prompts LEFT JOIN users ON reported_prompts.userId = users.id LEFT JOIN prompts ON reported_prompts.promptId = prompts.id");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function getReportedPromptsDetail($id){
            $conn = Dbm::getInstance();
            $statement = $conn->prepare("SELECT users.id as user, username, prompts.id as id, description, date, title, name as category   from reported_prompts LEFT JOIN users ON reported_prompts.userId = users.id LEFT JOIN prompts ON reported_prompts.promptId = prompts.id LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE prompts.id = :id");
            $statement->bindValue(":id", $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            $statement2 = $conn->prepare("SELECT  prompt_examples.example FROM prompts LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE prompts.id= :id");
            $statement2->bindValue(":id", $id);
            $statement2->execute();
            $result2 = $statement2->fetchALL(PDO::FETCH_ASSOC);
    
            return array("prompts" => $result,
                          "examples" => $result2);
        }
        
        public static function deleteReport ($id){
            $conn = Dbm::getInstance();
            $statement = $conn->prepare("DELETE FROM reported_prompts WHERE promptId = :id");
            $statement->bindValue(":id", $id);
            $statement->execute();
        }
    }