<?php

require "config.php";
class Database
{
    var $host   = ""; //database server
    var $user     = ""; //database login name
    var $pass     = ""; //database login password
    var $database = ""; //database name

    private $link;

    public function __construct(){
        $this->host=DB_SERVER;
        $this->user=DB_USER;
        $this->pass=DB_PASS;
        $this->database=DB_DATABASE;

    }

    public function connect(){
        try {
            $this->link = new mysqli($this->host,$this->user,$this->pass,$this->database);
        } catch (Exception $e){
            echo $e->getMessage();
            $this->link = null;
        } finally {
            return $this->link;
        }
    }
}
