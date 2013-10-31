<?php

/**************************************************************************************************************
 * Here we have usercard.php, a very loose library that will be housing a number of functions that will be   *
 * used in this program. All the documentation will be placed above the actual function, and if you need any  *
 * more help with figure it out, be sure to email me at a awtantillo@gmail.com                                *
 **************************************************************************************************************
 * Documentation Guide :                                                                                      *
 * Boxes - Function Description                                                                               *
 * //    - Purpose of Code                                                                                    *
 * #     - Miscellaneous Notes                                                                                *
/**************************************************************************************************************/

class UserCard
{
    /*********Variables***********/

    public $user = false;
    public $pass = false;
    public $db = false;
    public $admin = false;

    /*********Constructors***********/

    # Constructor that uses session values
    public function __construct()
    {
        try{
            session_start();
            $this->dbConnect();
            if(isset($_SESSION['user'], $_SESSION['pass'])){
                $user = $_SESSION['user'];
                $pass = $_SESSION['pass'];
                $this->dbConnect();
                $user = $this->sqlClean($user);
                $pass = $this->sqlClean($pass);
                return $this->userVerify($user, $pass);
            }
            return false;
        } catch(Exception $e){return false;}
    }

    # Constructor that uses user input
    public function withlogin($user, $pass)
    {
        try{
            $this->dbConnect();
            $user = mysqli_real_escape_string($this->db, $user);
            $pass = mysqli_real_escape_string($this->db, $pass);
            $pass = md5($pass);
            if ($this->userVerify($user, $pass)){
                $this->user = $user;
                $this->pass = $pass;
                return true;
            }
            return false;
        } catch(Exception $e){return false;}
    }

    /*********Public***********/

    # Checks to see if a user exists
    public function isLogged(){
        try{
            $sql = "SELECT UserName FROM users WHERE userName = '$this->user' AND userPass = '$this->pass'";
            $row = $this->dbQuery($sql);
            if ($this->user == $row['UserName']){
                return true;
            }
            return false;
        } catch(Exception $e){return false;}
    }

    # Checks to see if a user exists with parameters
    public function userVerify($user, $pass){
        try{
            $sql = "SELECT UserName FROM users WHERE userName = '$user' AND userPass = '$pass'";
            $row = $row = $this->dbQuery($sql);
            if ($user == $row['UserName']){
                $this->user = $user;
                $this->pass = $pass;
                return true;
            }
            return false;
        } catch(Exception $e){return false;}
    }

   /********Private*********/

    # Connect to the database
    private function dbConnect(){
        try{
            $db = mysqli_connect("localhost", "script", "pass123");
            mysqli_select_db($db, "users") or die ('Unable to connect to the MySQL');
            $this->db = $db;
            return $db;
        }catch(Exception $e){return false;}
    }

    # Makes sure there isn't any SQL injection
    private function sqlClean($sql){
        try{
            return(mysqli_real_escape_string($this->db, $sql));
        } catch(Exception $e){return false;}
    }

    # Queries the Database and returns an array of the results
    private function dbQuery($sql){
        try{
            $this->dbConnect();
            $res = mysqli_query($this->db, $sql);
            return (mysqli_fetch_assoc($res));
        } catch(Exception $e){return false;}
    }
}
