<?php 
        class Notifications{
            private $receiverId;
            private $title;
            private $message;


            
            

            /**
             * Get the value of receiverId
             */ 
            public function getReceiverId()
            {
                        return $this->receiverId;
            }

            /**
             * Set the value of receiverId
             *
             * @return  self
             */ 
            public function setReceiverId($receiverId)
            {
                        $this->receiverId = $receiverId;

                        return $this;
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

            /**
             * Get the value of message
             */ 
            public function getMessage()
            {
                        return $this->message;
            }

            /**
             * Set the value of message
             *
             * @return  self
             */ 
            public function setMessage($message)
            {
                        $this->message = $message;

                        return $this;
            }

         

            public function saveRejectNotifiction(){
                $conn = Dbm::getInstance();
                $statement = $conn->prepare("INSERT INTO notifications (receiverId, title, message, date) VALUES (:receiverId, :title, :message, NOW())");
                $statement->bindValue(":receiverId", $this->getReceiverId());
                $statement->bindValue(":title", $this->getTitle());
                $statement->bindValue(":message", $this->getMessage());
                $statement->execute();
            }

            public static function getNotifications($recieverId){
                $conn = Db::getInstance();
                $statement = $conn->prepare("SELECT * FROM notifications WHERE receiverId = :receiverId");
                $statement->bindValue(":receiverId", $recieverId );
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }

        }

