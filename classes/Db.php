<?php
    class Db{
        private static $db;

        public static function getInstance(){
            //er wordt maar eenmaal connectie gemaakt over heel de website
            if(self::$db !== null){
                //er zit iets in = bestaande connectie
                return self::$db;
            }
            else{
                //nieuwe connectie
                //self -> vervanging voor $this, $this kan niet gebruikt worden want er is geen object
                self::$db = new PDO('mysql:host=localhost;dbname=promptbase', "root", "root");
                return self::$db;
            }
 
        }
    }