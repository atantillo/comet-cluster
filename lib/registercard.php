<?php

class RegisterCard
{
    /*********Variables***********/

    public $db = false;

    /*********Constructors***********/

    # Constructor that uses session values
    public function __construct($user, $pass, $fname, $lname, $major, $minor)
    {
        try {
            session_start();
            $this->dbConnect();
            if(isset($user, $pass, $fname, $lname, $major, $minor)){
                $user = $this->sqlclean($user);
                $pass = $this->sqlclean($pass);
                $lname = $this->sqlclean($lname);
                $fname = $this->sqlclean($fname);
                $major = $this->sqlclean($major);
                $minor = $this->sqlclean($minor);
            }
            return false;
        } catch(Exception $e) {return false;}
    }

    /*********Public**********/

    #Stores the new user in the database
    public function createuser($user, $pass, $lname, $fname, $major, $minor){
        try{

        } catch(Exception $e) {return false;}
    }


    /********Private*********/

    # Connects the Database
    private function dbconnect(){
        try{
            $db = mysqli_connect("localhost", "script", "pass123");
            mysqli_select_db($db, "users") or die ('Unable to connect to the MySQL');
            $this->db = $db;
            return $db;
        }catch(Exception $e){return false;}
    }

    # Makes sure there is no SQL Injection
    private function sqlclean($sql){
        try{
            return(mysqli_real_escape_string($this->db, $sql));
        } catch(Exception $e){return false;}
    }

    # Queries the database
    private function dbQuery($sql){
        try{
            $this->dbconnect();
            $res = mysqli_query($this->db, $sql);
            return (mysqli_fetch_assoc($res));
        } catch(Exception $e){return false;}
    }
}
