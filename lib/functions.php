<?php

/**************************************************************************************************************
 * Here we have functions.php, a very loose library that will be housing a number of functions that will be   *
 * used in this program. All the documentation will be placed above the actual function, and if you need any  *
 * more help with figure it out, be sure to email me at a awtantillo@gmail.com                                *
 **************************************************************************************************************
 * Documentation Guide :                                                                                      *
 * Boxes - Function Description                                                                               *
 * //    - Purpose of Code                                                                                    *
 * #     - Miscellaneous Notes                                                                                *
/**************************************************************************************************************/


class userCard
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
    public function withLogin($user, $pass)
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

    private function dbConnect(){
        try{
            $db = mysqli_connect("localhost", "script", "pass123");
            mysqli_select_db($db, "users") or die ('Unable to connect to the MySQL');
            $this->db = $db;
            return $db;
        }catch(Exception $e){return false;}
    }

    public function sqlClean($sql){
        try{
            return(mysqli_real_escape_string($this->db, $sql));
        } catch(Exception $e){return false;}
    }

    private function dbQuery($sql){
        try{
            $this->dbConnect();
            $res = mysqli_query($this->db, $sql);
            return (mysqli_fetch_assoc($res));
        } catch(Exception $e){return false;}
    }

    private function monthConvert($date){
        try{
            $month = $date;
            $year = $date;
            $year = substr($year, 0, 4);
            $month = substr($month, 5, 2);
            $month = $this->numToMonth($month);
            return($month." ".$year);
        } catch(Exception $e) { return false; }
    }

    private function numToMonth($month){
        try{
            switch($month){
                case "01":
                    return "January";
                case "02":
                    return "February";
                case "03":
                    return "March";
                case "04":
                    return "April";
                case "05":
                    return "May";
                case "06":
                    return "June";
                case "07":
                    return "July";
                case "08":
                    return "August";
                case "09":
                    return "September";
                case "10":
                    return "October";
                case "11":
                    return "November";
                case "12":
                    return "December";
                default:
                    return "Nope";
            }
        }catch(Exception $e){return false;}
    }

    private function clearArray(){
        try{
            $this->month_val = [];
            $this->months = [];
            return true;
        }catch(Exception $e){return false;}
    }

    function csvVerify($j){
        $sep = "\t";
        if(isset($j)) {
            $schema_insert = $j.$sep;
        } else {
            $schema_insert = " ";
        }
        return ($schema_insert);
    }
}

