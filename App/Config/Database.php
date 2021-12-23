<?php

namespace App\Config;

class Database
{

    // specify your own database credentials
    private string $_host = "localhost";
    private string $_db_name = "projet_web";
    private string $_username = "root";
    private string $_password = "";
    private \PDO $_conn;


    // get the database connection
    public function getConnection() : \PDO {

        try{
            $this->_conn = new \PDO("mysql:host=" . $this->_host . ";dbname=" . $this->_db_name, $this->_username, $this->_password);
            $this->_conn->exec("set names utf8");
        }catch(\PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->_conn;
    }

}