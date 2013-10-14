<?php


function db_connect()
{
    try{
        //Hostname, Database Username, Database Password
        $db = mysqli_connect("localhost", "root", "") or die('Could not connect: ' . mysqli_connect_error());
        //Database name
        mysqli_select_db($db, "mis-web") or die ('Unable to connect to the MySQL');
        //Returns the database for local use
        return $db;
    } catch(Exception $e){ return false; }
}

class User
{
    private $userName = false;

    public function storeLogin($userName){
       $this->$user = $userName;
       return true;
    }

    public function checkLogIn(){
        if ($this->$user){

        }
    }
}