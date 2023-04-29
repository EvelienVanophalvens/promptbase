<?php

class Prompts
{
    private int $id;
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
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
        if(empty($prompt)) {
            throw new Exception("Please fill in a title");
        } else {
            $this->prompt = $prompt;
        }

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
        if(empty($author)) {
            throw new Exception("Please fill in a author");
        } else {
            $this->author = $author;
        }

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
        if(empty($date)) {
            throw new Exception("Please fill in a date");
        } else {
            $this->date = $date;
        }
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
        if(empty($categories)) {
            throw new Exception("Please fill in a category");
        } else {
            $this->categories = $categories;
        }

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
        if(empty($description)) {
            throw new Exception("Please fill in a description");
        } else {
            $this->description = $description;
        }

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
        if(empty($status)) {
            throw new Exception("Please fill in a status");
        } else {
            $this->status = $status;
        }


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
        if(empty($paid)) {
            throw new Exception("Please fill in a paid form");
        } else {
            $this->paid = $paid;
        }


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
        if(empty($model)) {
            throw new Exception("Please fill in a model");
        } else {
            $this->model = $model;
        }

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
        if(empty($price)) {
            throw new Exception("Please fill in a price");
        } else {
            $this->price = $price;
        }
    }

     //FUNCTIES UPLOADEN NIEUWE PROMPTS
     public function save()
     {
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

         foreach($this->getCategories() as $category) {
             $statement3 = $conn->prepare("INSERT INTO prompt_categories (promptId, categoryId) VALUES (:promptId, :categoryId)");
             $statement3->bindValue(":promptId", $lastId);
             $statement3->bindValue(":categoryId", $category);
             $statement3->execute();
         }
     }
    public static function addExample($id, $example)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO prompt_examples (promptId, example) VALUES (:promptId, :example)");
        $statement->bindValue(":promptId", $id);
        $statement->bindValue(":example", $example);
        return $statement->execute();
    }
    public static function getModules()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM model");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function categories()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM categories");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //LIJSTEN PROMPTS:
    //Geeft alle prompts van een user accepted of niet (enkel zichtbaar voor de user zelf)
    public static function getPersonalPrompts($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, prompt_examples.example FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE userId = :id ORDER BY prompts.date DESC;");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //Geeft enkel de GEACCEPTEERDE prompts van een andere gebruiker
    public static function getUserPrompts($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt AS promptName, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE accepted = 1 AND users.id = :id;");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $results = $statement->fetchALL(PDO::FETCH_ASSOC);
        return $results;
    }
    //Overzicht van alle prompts die nog NIET GEACCEPTEERD zijn
    public static function notAccepted()
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username FROM prompts LEFT JOIN users ON prompts.userid = users.id  WHERE accepted = 0");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //Overzicht van alle prompts die GEACCEPTEERD zijn
    public static function accepted()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE accepted = 1 ORDER BY prompts.date DESC;");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //DETAILOVERZICHTEN PROMPTS:
    //Geeft een detailoverzicht van een specifieke prompt die NIET GEACCEPTEERD ZIJN
    public static function detailPromptM($id)
    {
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
    //Geeft een detailoverzicht van een specifieke prompt die al WEL GEACCEPTEERD ZIJN
    public static function detailPrompt($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt AS promptName, prompts.date, prompts.userId, prompts.accepted, prompts.id, prompts.description, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE accepted = 1 AND prompts.id = :id LIMIT 1;");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $results =$statement->fetchAll(PDO::FETCH_CLASS,  __CLASS__);
        //statement voor meerdere voorbeelden te kunnen laden
        $statement2 = $conn->prepare("SELECT  prompt_examples.example FROM prompts LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE prompts.id= :id;");
        $statement2->bindValue(":id", $id);
        $statement2->execute();
        $results2 = $statement2->fetchALL(PDO::FETCH_ASSOC);
        //beide resultaten worden doorgestuurd
        return array("prompts" => $results,
                      "examples" => $results2);
    }

    //MODERATORACTIES:
    //Prompt accepteren
    public static function acceptPrompt($id)
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("UPDATE prompts SET accepted = 1 WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
    }
    //Prompt afwijzen
    public static function rejectPrompt($id)
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("DELETE FROM prompts WHERE id = :id;");
        $statement->bindValue(":id", $id);
        $statement->execute();
    }

    //COMMENTFUNCTIES:
    //Geef lijst van alle comments voor een specifieke prompt
    public static function getAllComments($promptId)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompt_comments.id AS commitId, prompt_comments.promptId, prompt_comments.userId, prompt_comments.comment, users.id, users.username, users.profilePicture FROM `prompt_comments`LEFT JOIN users ON prompt_comments.userId= users.id WHERE prompt_comments.promptId = :prompt;");
        $statement->bindValue(":prompt", $promptId);
        $statement->execute();
        $allComments = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $allComments;
    }
    //Voegt een comment toe door de actieve gebruiker aan een specifieke prompt
    public static function addComment($userId, $promptId, $comment)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO prompt_comments (promptId, userId, comment)VALUES (:prompt, :user, :comment);");
        $statement->bindValue(":prompt", $promptId);
        $statement->bindValue(":user", $userId);
        $statement->bindValue(":comment", $comment);
        $statement->execute();
    }

    //SEARCHFUNCTIES:
    // Prompts zoeken op basis van NAAM
    public static function search($search)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM prompts WHERE prompt LIKE '%$search%'");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
     //Prompts zoeken op basis van CATEGORIE
     public static function filteredPromptsByCategory($category)
     {
         $conn = Db::getInstance();
         $statement = $conn->prepare("SELECT prompts.prompt AS promptName, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, prompt_examples.example FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE accepted = 1 AND categories.name LIKE '%$category%' ORDER BY prompts.date ASC;");
         $statement->execute();
         $result = $statement->fetchAll(PDO::FETCH_ASSOC);
         return $result;
     }

    //FILTERFUNCTIES:
    public static function filter($paid_free, $model_choice)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM prompts JOIN model ON prompts.modelId = model.id WHERE paid = :paid_free AND name = :model_choice");
        $statement->bindValue(":paid_free", $paid_free);
        $statement->bindValue(":model_choice", $model_choice);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    //ANDERE:
    //Geeft alle voorbeeldafbeeldingen van een specifieke prompt
    public static function getPromptsExamples($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT  prompt_examples.example FROM prompts LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE prompts.id= :id;");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $results = $statement->fetchALL(PDO::FETCH_ASSOC);
        //beide resultaten worden doorgestuurd
        return $results;
    }

    public static function getPromptExample($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT  prompt_examples.example, prompts.Id FROM prompts LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE prompts.id= :id; LIMIT 1");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        //beide resultaten worden doorgestuurd
        return $results;
    }

    //geef alle likes
    public function getLikes($promptId){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT count(*) AS likes FROM prompt_likes WHERE promptId = :promptId");
        $statement->bindValue(":promptId", $promptId);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["likes"];
    }

}
