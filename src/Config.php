<?php

namespace SurvTech\Bnjunge\Mariot;


// connect to database class
class Config{
    private $dbName;
    private $dbHost;
    private $dbPass;
    private $dbUser;
    public $con;

    public function __construct(){
        $this->dbHost = 'localhost';
        $this->dbName = 'wisp';
        $this->dbPass = '';
        $this->dbUser = 'root';
        try{
            $conn = new \PDO('mysql:host='.$this->dbHost.';dbname='.$this->dbName, $this->dbUser, $this->dbPass);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
            $this->con = $conn;
            return $this->con;
            //echo 'connected';
        }catch(\PDOException $e){
            return null;
            // echo $e->getMessage();
        }
    }
}