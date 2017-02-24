<?php

class Db {
    public $pdo;


    public static $instance = null;

    private function __construct(){
        $this->connect();	

    }

    public static function Instance(){
        if(is_null(self::$instance)){
            self::$instance = new self();

        }

        return self::$instance;

    }


    private function connect(){
        $username = Ini::getConfig("database.mysql_username");
        $pwd = Ini::getConfig("database.mysql_password");

        try {
            $this->pdo = new PDO("mysql:host=localhost; dbname=google_calendar", $username, $pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "cannot connect: ".$e->getMessage();
        }

    }


}
