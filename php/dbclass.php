<?php   
    class Dbclass{
        private string $host;
        private string $user;
        private string $password;
        private string $dbname;
        private PDO $connect;

        public function __construct(string $host,string $user
        ,string $password, string $dbname){
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->dbname = $dbname;
            $this->connect = new PDO("pgsql:host=$host;dbname=$dbname",$user,$password);
        }

        public function getConnect():PDO{
            return $this->connect;
        }
    }