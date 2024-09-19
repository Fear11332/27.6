<?php   
    class Dbclass{
        private string $host;
        private string $user;
        private string $password;
        private string $dbname;
        private PDO $connect;

        public function __construct(string $host,string $user
        , string $dbname){
            $this->host = $host;
            $this->user = $user;
            $this->password = 'saw';
            $this->dbname = $dbname;
            $this->connect = new PDO("pgsql:host=$host;dbname=$dbname",$user,$this->password);
        }

        public function getConnect():PDO{
            return $this->connect;
        }
    }