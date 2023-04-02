<?php
    class Db{
        private static $db;

        private static function getConfig(){
            // get the config file
            return parse_ini_file("config/config.ini");
        }

        public static function getInstance(){
            //er wordt maar eenmaal connectie gemaakt over heel de website
            if(self::$db != null){
                //er zit iets in = bestaande connectie
                return self::$db;
            }
            else{
                //nieuwe connectie
                // get the configuration for our connection from one central settings file
                $config = self::getConfig();
                $host = $config['host'];
                $database = $config['database'];
                $user = $config['user'];
                $password = $config['password'];
                
                //self -> vervanging voor $this, $this kan niet gebruikt worden want er is geen object
                self::$db = new PDO("mysql:host=$host;dbname=".$database, $user, $password);
                return self::$db;
            }
 
        }
    }