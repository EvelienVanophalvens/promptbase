<?php

    class Prompts{
        private string $prompt;
        private string $author;
        private string $date;
        private array $categories;
        private string $description;
        private int $status;
        private int $paid;
        private int $model; 
        private int $price;
   
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

          /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @return  self
         */ 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }


        
      

        /**
         * Get the value of status
         */ 
        public function getStatus()
        {
                return $this->status;
        }

        /**
         * Set the value of status
         *
         * @return  self
         */ 
        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }

        /**
         * Get the value of paid
         */ 
        public function getPaid()
        {
                return $this->paid;
        }

        /**
         * Set the value of paid
         *
         * @return  self
         */ 
        public function setPaid($paid)
        {
                $this->paid = $paid;

                return $this;
        }

        /**
         * Get the value of model
         */ 
        public function getModel()
        {
                return $this->model;
        }

        /**
         * Set the value of model
         *
         * @return  self
         */ 
        public function setModel($model)
        {
                $this->model = $model;

                return $this;
        }

   

        /**
         * Get the value of price
         */ 
        public function getPrice()
        {
                return $this->price;
        }

        /**
         * Set the value of price
         *
         * @return  self
         */ 
        public function setPrice($price)
        {
                $this->price = $price;

                return $this;
        }
    

    public function save(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO prompts (prompt, userId, date, accepted, description, status, paid, price, modelId) VALUES (:prompt, :userId, :date, :accepted, :discription, :status, :paid, :price, :model )");
        $statement->bindValue(":prompt", $this->getPrompt());
        $statement->bindValue(":userId", $this->getAuthor());
        $statement->bindValue(":date", $this->getDate());
        $statement->bindValue(":accepted", 0);
        $statement->bindValue(":discription", $this->getDescription());
        $statement->bindValue(":status", $this->getStatus());
        $statement->bindValue(":paid", $this->getPaid());
        $statement->bindValue(":price", $this->getPrice());
        $statement->bindValue(":model", $this->getModel());
        $statement->execute();

        $lastId = $conn->lastInsertId();
        return $lastId;

        foreach($this->getCategories() as $category){
            $statement3 = $conn->prepare("INSERT INTO prompt_categories (promptId, categoryId) VALUES (:promptId, :categoryId)");
            $statement3->bindValue(":promptId", $lastId);
            $statement3->bindValue(":categoryId", $category);
            $statement3->execute();
        }
        }

        public static function addExample($id, $example){
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO prompt_examples (promptId, example) VALUES (:promptId, :example)");
            $statement->bindValue(":promptId", $id);
            $statement->bindValue(":example", $example);
            return $statement->execute();
        }

    
    public static function getModules(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM model");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function categories(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM categories");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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
        $statement = $conn->prepare("SELECT prompts.prompt AS promptName, prompts.date, prompts.userId, prompts.accepted, prompts.id, prompts.description, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, prompt_examples.example FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE accepted = 1 AND prompts.id = :id LIMIT 1;");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $results =$statement->fetch(PDO::FETCH_ASSOC);
        //statement voor meerdere voorbeelden te kunnen laden
        $statement2 = $conn->prepare("SELECT  prompt_examples.example FROM prompts LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE prompts.id= :id;");
        $statement2->bindValue(":id", $id);
        $statement2->execute();
        $results2 = $statement2->fetchALL(PDO::FETCH_ASSOC);
        //beide resultaten worden doorgestuurd
        return array("prompts" => $results,
                      "examples" => $results2);

                  
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

    public static function getAll(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username FROM prompts LEFT JOIN users ON prompts.userid = users.id");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getAllComments($promptId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompt_comments.id AS commitId, prompt_comments.promptId, prompt_comments.userId, prompt_comments.comment, users.id, users.username, users.profilePicture FROM `prompt_comments`LEFT JOIN users ON prompt_comments.userId= users.id WHERE prompt_comments.promptId = :prompt;");
        $statement->bindValue(":prompt", $promptId);
        $statement->execute();
        $allComments = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $allComments;
    }
    public static function addComment($userId, $promptId, $comment){
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO prompt_comments (promptId, userId, comment)VALUES (:prompt, :user, :comment);");
        $statement->bindValue(":prompt", $promptId);
        $statement->bindValue(":user", $userId);
        $statement->bindValue(":comment", $comment);
        $statement->execute();
    }

    public static function getFilter($paid, $model){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username FROM prompts LEFT JOIN users ON prompts.userid = users.id WHERE prompts.accepted = :paid AND prompts.userId = :model");
        $statement->bindValue(":paid", $paid);
        $statement->bindValue(":model", $model);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public static function getUserPrompts($userId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, name FROM prompts LEFT JOIN users ON prompts.userid = users.id LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE prompts.userId = :userId && prompts.accepted = 1");
        $statement->bindValue(":userId", $userId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getPromptsExamples($id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompt_examples.example FROM prompts LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE prompts.id= :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

  }