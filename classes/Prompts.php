<?php

    class Prompts{
        private string $prompt;
        private string $author;
        private string $date;
        private array $categories;
        /**
         * Get the value of prompt
         */ 
        public function getPrompt()
        {
                return $this->prompt;
        }

        /**
         * Set the value of prompt
         *
         * @return  self
         */ 
        public function setPrompt($prompt)
        {
                $this->prompt = $prompt;

                return $this;
        }

        /**
         * Get the value of author
         */ 
        public function getAuthor()
        {
                return $this->author;
        }

        /**
         * Set the value of author
         *
         * @return  self
         */ 
        public function setAuthor($author)
        {
                $this->author = $author;

                return $this;
        }

        /**
         * Get the value of date
         */ 
        public function getDate()
        {
                return $this->date;
        }

        /**
         * Set the value of date
         *
         * @return  self
         */ 
        public function setDate($date)
        {
                $this->date = $date;

                return $this;
        }

        /**
         * Get the value of categories
         */ 
        public function getCategories()
        {
                return $this->categories;
        }

        /**
         * Set the value of categories
         *
         * @return  self
         */ 
        public function setCategories($categories)
        {
                $this->categories = $categories;

                return $this;
        }
    
        
    public static function notAccepted(){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username FROM prompts LEFT JOIN users ON prompts.userid = users.id  WHERE accepted = 0");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function accepted(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, prompt_examples.example FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE accepted = 1 ORDER BY prompts.date ASC;");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function detailPromptM($id){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username FROM prompts LEFT JOIN users ON prompts.userid = users.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId  WHERE prompts.id = :id AND accepted = 0 ");
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
    public static function detailPrompt($id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username FROM prompts LEFT JOIN users ON prompts.userid = users.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId  WHERE prompts.id = :id AND accepted = 1 ");
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

    public static function acceptPrompt($id){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE prompts SET accepted = 1 WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();

    }
    public static function filteredPromptsByCategory($category){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt AS promptName, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, prompt_examples.example FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE accepted = 1 AND categories.name LIKE '%$category%' ORDER BY prompts.date ASC;");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
   /* public static function filteredPromptsByCategory($category){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt AS promptName, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, prompt_examples.example FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE accepted = 1 AND categories.name LIKE '%$category%' ORDER BY prompts.date ASC;");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }*/

       

        public static function getPrompts(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username FROM prompts LEFT JOIN users ON prompts.userid = users.id  WHERE accepted = 1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        }






  }