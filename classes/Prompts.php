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
    private string $title;

    
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
    if (empty($prompt)) {
        throw new Exception("Please fill in a title");
    } elseif (is_array($prompt)) {
        $this->prompt = implode(' ', $prompt);
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
        $status = (int)$status; 
        if(is_null($status)) {
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
        if(is_null($paid)) {
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
        if(is_null($model)) {
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
        if(is_null($price)) {
            throw new Exception("Please fill in a price");
        } else {
            $this->price = $price;
        }
        
    }

        /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

     //FUNCTIES UPLOADEN NIEUWE PROMPTS
     public function save()
{
    $conn = Db::getInstance();
    $statement = $conn->prepare("INSERT INTO prompts (title, userId, date, accepted, description, status, paid, price, modelId, prompt) VALUES (:title, :userId, :date, :accepted, :description, :status, :paid, :price, :model, :prompt)");
    $statement->bindValue(":title", $this->getTitle());
    $statement->bindValue(":userId", $this->getAuthor());
    $statement->bindValue(":date", $this->getDate());
    $statement->bindValue(":accepted", 0);
    $statement->bindValue(":description", $this->getDescription());
    $statement->bindValue(":status", $this->getStatus());
    $statement->bindValue(":paid", $this->getPaid());
    $statement->bindValue(":price", $this->getPrice());
    $statement->bindValue(":model", $this->getModel());
    $statement->bindValue(":prompt", $this->getPrompt());
    $statement->execute();

    $lastId = $conn->lastInsertId();

    foreach ($this->getCategories() as $category) {
        $statement3 = $conn->prepare("INSERT INTO prompt_categories (promptId, categoryId) VALUES (:promptId, :categoryId)");
        $statement3->bindValue(":promptId", $lastId);
        $statement3->bindValue(":categoryId", $category);
        $statement3->execute();
    }

    return $lastId;
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
        return [
            // Sample categories array
            [
                "id" => 1,
                "name" => "line-art",
            ],
            [
                "id" => 2,
                "name" => "3D",
            ],
            [
                "id" => 3,
                "name" => "animation",
            ],
           
            [
                "id" => 4,
                "name" => "animals",
            ] 
        ];
    
    }
    //LIJSTEN PROMPTS:
    //Geeft alle prompts van een user accepted of niet (enkel zichtbaar voor de user zelf)
    public static function getPersonalPrompts($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.title, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, prompt_examples.example FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE userId = :id AND accepted = 1 ORDER BY prompts.date DESC;");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //Geeft enkel de GEACCEPTEERDE prompts van een andere gebruiker
    public static function getUserPrompts($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.title AS promptName, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE accepted = 1 AND users.id = :id;");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $results = $statement->fetchALL(PDO::FETCH_ASSOC);
        return $results;
    }
    //Overzicht van alle prompts die nog NIET GEACCEPTEERD zijn
    public static function notAccepted()
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT prompts.title, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username FROM prompts LEFT JOIN users ON prompts.userid = users.id  WHERE accepted = 0");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //Overzicht van alle prompts die GEACCEPTEERD zijn
    public static function accepted()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.title, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE accepted = 1 ORDER BY prompts.date DESC;");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //DETAILOVERZICHTEN PROMPTS:
    //Geeft een detailoverzicht van een specifieke prompt die NIET GEACCEPTEERD ZIJN
    public static function detailPromptM($id)
    {
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT prompts.title, prompts.date, prompts.description, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username , prompt_categories.promptId, prompt_categories.categoryId,categories.name AS category FROM prompts LEFT JOIN users ON prompts.userid = users.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE prompts.id = :id AND accepted = 0 ");
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
        $statement = $conn->prepare("SELECT prompts.title AS promptName, prompts.date, prompts.userId, prompts.accepted, prompts.id, prompts.description, prompts.price, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, model.name AS modelName FROM prompts LEFT JOIN users ON prompts.userid = users.id LEFT JOIN model on prompts.modelId = model.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE accepted = 1 AND prompts.id = :id LIMIT 1;");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $results =$statement->fetchAll(PDO::FETCH_CLASS,  __CLASS__);
        //statement voor meerdere voorbeelden te kunnen laden
        $statement2 = $conn->prepare("SELECT  prompt_examples.example FROM prompts LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE prompts.id= :id; AND prompts.accepted = 1");
        $statement2->bindValue(":id", $id);
        $statement2->execute();
        $results2 = $statement2->fetchALL(PDO::FETCH_ASSOC);
        //beide resultaten worden doorgestuurd

        if ($results) {
            return array("prompts" => $results[0],
                      "examples" => $results2);
        } else {
        }


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
        $statement = $conn->prepare("UPDATE prompts SET accepted = 2 WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
    }

     //COMMENTFUNCTIES://
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
        $statement = $conn->prepare("SELECT prompts.id AS promptId, title, date, userId, accepted, description, status, paid, price, modelId, categoryId, categories.name AS category FROM prompts LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE title LIKE :search OR description LIKE :search AND accepted = 1 ORDER BY date DESC");
        $statement->bindValue(":search", '%'.$search.'%');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
     //Prompts zoeken op basis van CATEGORIE
     public static function filteredPromptsByCategory($category)
     {
         $conn = Db::getInstance();
         $statement = $conn->prepare("SELECT prompts.prompt AS promptName, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, prompt_examples.example FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE accepted = 1 AND categories.name LIKE ':category' ORDER BY prompts.date ASC;");
         $statement->bindValue(":category", '%'.$category.'%');
         $statement->execute();
         $result = $statement->fetchAll(PDO::FETCH_ASSOC);
         return $result;
     }

    //FILTERFUNCTIES:
    public static function filter($paid_free, $model_choice)
    {

if($paid_free == "free"){
    $conn = Db::getInstance();
    $statement = $conn->prepare("SELECT prompts.id, title, date, userId, accepted, description, status, paid, price, modelId, name FROM prompts JOIN model ON prompts.modelId = model.id WHERE paid = :paid_free AND name = :model_choice AND accepted = 1");
    $statement->bindValue(":paid_free", 1);
    $statement->bindValue(":model_choice", $model_choice);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}else{
    $conn = Db::getInstance();
    $statement = $conn->prepare("SELECT prompts.id, title, date, userId, accepted, description, status, paid, price, modelId, name FROM prompts JOIN model ON prompts.modelId = model.id WHERE paid = :paid_free AND name = :model_choice AND accepted = 1");
    $statement->bindValue(":paid_free", 0);
    $statement->bindValue(":model_choice", $model_choice);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}   
    }

    public static function filterModel($model_choice)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.id, title, date, userId, accepted, description, status, paid, price, modelId, name FROM prompts JOIN model ON prompts.modelId = model.id WHERE name = :model_choice AND accepted = 1");
        $statement->bindValue(":model_choice", $model_choice);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function filterPaid($paid_free)
    {
    if($paid_free == "free") {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.id, title, date, userId, accepted, description, status, paid, price, modelId, name FROM prompts JOIN model ON prompts.modelId = model.id WHERE paid = :paid_free AND accepted = 1");
        $statement->bindValue(":paid_free", 1);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;

    } else {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.id, title, date, userId, accepted, description, status, paid, price, modelId, name FROM prompts JOIN model ON prompts.modelId = model.id WHERE paid = :paid_free AND accepted = 1");
        $statement->bindValue(":paid_free", 0);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
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
    public static function getLikes($id){
        $conn = Dbm::getInstance();
        $statement = $conn->prepare("SELECT count(*) AS likes FROM prompt_likes WHERE promptId = :promptId");
        $statement->bindValue(":promptId", $id );
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["likes"];
    }

    public static function getPromptLike($promtpId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT count(*) AS likes FROM prompt_likes WHERE promptId = :promptId");
        $statement->bindValue(":promptId", $promtpId);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["likes"];
    }

    public static function getFavouritePrompts($userId) {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.title, prompts.date, prompts.userId, prompts.accepted, prompts.id, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, prompt_examples.example FROM prompts LEFT JOIN users ON prompts.userid = users.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId LEFT JOIN favourits ON prompts.id = favourits.promptId WHERE favourits.userId = :id AND accepted = 1 ORDER BY prompts.date DESC;");
        $statement->bindValue(":id", $userId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } 

    public static function isPromptFavorite($promptId, $userId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM favourits WHERE userId = :userId AND promptId = :promptId");
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":promptId", $promptId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

      public static function delete ($id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("DELETE prompt_categories, prompts, prompt_likes, prompt_examples, prompt_comments from prompts LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN prompt_comments ON prompts.id = prompt_comments.promptId LEFT JOIN prompt_likes ON prompts.id = prompt_likes.promptId LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE prompts.id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
      }

      public static function getRejectedPrompt($id, $userId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.prompt, prompts.id, title, date, userId, accepted, description, status, paid, price, modelId, model.name AS name, categories.name AS categorie FROM prompts JOIN model ON prompts.modelId = model.id LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id  WHERE prompts.id = :promptId AND prompts.userId = :userId AND accepted = 2");
        $statement->bindValue(":promptId", $id);
        $statement->bindValue(":userId", $userId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        

        $statement2 = $conn->prepare("SELECT example FROM prompt_examples LEFT JOIN prompts ON prompt_examples.promptId = prompts.id WHERE prompts.id = :promptId");
        $statement2->bindValue(":promptId", $id);
        $statement2->execute();
        $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);


        if(empty($result)){
          header("Location: notifications.php");
        }else{ 
          return array(
            "prompt" => $result, 
            "examples" => $result2);
        }

        return array(
            "prompt" => $result, 
            "examples" => $result2);

      }

      public function updatePrompt($promptId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE prompts SET title = :title, description = :description, price = :price, modelId = :modelId, accepted = 0, prompt= :prompt WHERE id = :id");
        $statement->bindValue(":title", $this->getTitle());
        $statement->bindValue(":description", $this->getDescription());
        $statement->bindValue(":price", $this->getPrice());
        $statement->bindValue(":modelId", $this->getModel());
        $statement->bindValue(":prompt", $this->getPrompt());

        $statement->bindValue(":id", $promptId);
        $statement->execute();

        $statement2 = $conn->prepare("DELETE FROM prompt_categories WHERE promptId = :promptId");
        $statement2->bindValue(":promptId", $promptId);
        $statement2->execute();

        foreach($this->getCategories() as $category) {
            $statement3 = $conn->prepare("INSERT INTO prompt_categories (promptId, categoryId) VALUES (:promptId, :categoryId) ");
            $statement3->bindValue(":promptId", $promptId);
            $statement3->bindValue(":categoryId", $category);
            $statement3->execute();
        }

      }

      public static function updateExamples( $promptId, $file){
        $conn = Db::getInstance();
        $statement = $conn->prepare("DELETE FROM prompt_examples WHERE promptId = :promptId");
        $statement->bindValue(":promptId", $promptId);
        $statement->execute();

        $statement2 = $conn->prepare("INSERT INTO prompt_examples (promptId, example) VALUES (:promptId, :example)");
        $statement2->bindValue(":promptId", $promptId);
        $statement2->bindValue(":example", $file);
        $statement2->execute();
        
      }



      public static function addPromptToUser($userId, $promptId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO bought_prompts (userId, promptId) VALUES (:userId, :promptId)");
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(":promptId", $promptId);
        $statement->execute();
      }

      public static function getBoughtPrompts($userId){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.id, title, date, description, status, model.name AS name, categories.name AS categorie, prompt_examples.example  FROM prompts JOIN model ON prompts.modelId = model.id LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId  LEFT JOIN bought_prompts ON prompts.id = bought_prompts.promptId WHERE bought_prompts.userId = :userId LIMIT 1");
        $statement->bindValue(":userId", $userId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;

      }

      public static function boughtPromptDetail($id){

         $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT prompts.title AS promptName, prompt, prompts.date, prompts.userId, prompts.accepted, prompts.id, prompts.description, prompts.price, users.id AS user, users.username, prompt_categories.promptId, prompt_categories.categoryId,categories.name, model.name AS modelName FROM prompts LEFT JOIN users ON prompts.userid = users.id LEFT JOIN model on prompts.modelId = model.id  LEFT JOIN prompt_categories ON prompts.id = prompt_categories.promptId LEFT JOIN categories ON prompt_categories.categoryId = categories.id WHERE accepted = 1 AND prompts.id = :id LIMIT 1;");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $results =$statement->fetchAll(PDO::FETCH_CLASS,  __CLASS__);
        //statement voor meerdere voorbeelden te kunnen laden
        $statement2 = $conn->prepare("SELECT  prompt_examples.example FROM prompts LEFT JOIN prompt_examples ON prompts.id = prompt_examples.promptId WHERE prompts.id= :id; AND prompts.accepted = 1");
        $statement2->bindValue(":id", $id);
        $statement2->execute();
        $results2 = $statement2->fetchALL(PDO::FETCH_ASSOC);
        //beide resultaten worden doorgestuurd

        if ($results) {
            return array("prompts" => $results[0],
                      "examples" => $results2);
        } else {
        }


        return array("prompts" => $results,
                      "examples" => $results2);
    }

    //select the userid from the prompt
    public static function getUserId(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT userId FROM prompts WHERE id = :id");
        $statement->bindValue(":id", $_GET["id"]);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["userId"];
    }
}
