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
 * 0 = Nothing, 1 = Enrolled, 2 = F, 3 = D, 4 = C, 5 = B, 6 = A                                               *
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
            $this->dbconnect();
            session_start();
            if(isset($_SESSION['user'], $_SESSION['pass'])){
                $user = $_SESSION['user'];
                $pass = $_SESSION['pass'];
                $this->dbconnect();
                $user = $this->sqlClean($user);
                $pass = $this->sqlClean($pass);
                $this->userVerify($user, $pass);
            }
            return false;
        } catch(Exception $e){return false;}
    }

    # Constructor that uses user input
    public function withlogin($user, $pass)
    {
        try{
            $user = mysqli_real_escape_string($this->db, $user);
            $pass = mysqli_real_escape_string($this->db, $pass);
            if ($this->userVerify($user, $pass)){
                $this->user = $user;
                $this->pass = $pass;
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                return true;
            }
            return false;
        } catch(Exception $e){return false;}
    }

    /*********Public***********/

    # Checks to see if a user exists
    public function isLogged(){
        try{
            $sql = "SELECT userLogin FROM users WHERE userLogin = '$this->user' AND userPass = '$this->pass'";
            $res = mysqli_query($this->db, $sql);
            $row = mysqli_fetch_assoc($res);
            if ($this->user == $row['userLogin']){ return true; }
            return false;
        } catch(Exception $e){return false;}
    }

    # Checks to see if a user exists with parameters
    public function userVerify($user, $pass)
    {
        try{
            $sql = "SELECT userLogin FROM users WHERE userLogin = '$user' AND userPass = '$pass'";
            $res = mysqli_query($this->db, $sql);
            $row = mysqli_fetch_assoc($res);
            if ($user == $row['userLogin']){
                $this->user = $user;
                $this->pass = $pass;
                return true;
            }
            return false;
        } catch(Exception $e){return false;}
    }

    public function userID()
    {
        try{
            $sql = "SELECT userID FROM users WHERE userLogin = '$this->user'";
            $res = mysqli_query($this->db, $sql);
            $row = mysqli_fetch_assoc($res);
            return $row['userID'];
        } catch(Exception $e){return false;}
    }

    public function savependingclasses()
    {
        try {
            $id = $this->userID();
            $sql = "SELECT classes.classID, classes.classSchool, classes.classSuffix, classes.className FROM classes INNER JOIN enrollment WHERE enrollment.userID = '$id' AND enrollment.progress = 0 AND classes.classID = enrollment.classID";
            $res = mysqli_query($this->db, $sql);
            while($row = mysqli_fetch_assoc($res))
            {
                $class = $row['classID'];
                $temp = "checkbox-".$row['classID'];
                if(isset($_POST[$temp])) # If the box is checked, it will update the information to the student's roster
                {
                    echo "<script>console.log('".$temp." is set!');</script>";
                    $sql = "UPDATE enrollment SET progress = 1 WHERE userID = '$id' AND classID = '$class'";
                    mysqli_query($this->db, $sql);
                }
            }
            return true;
        } catch(Exception $e){return false;}
    }

    public function savetakenclasses()
    {
        try {
            $id = $this->userID();
            $sql = "SELECT classes.classID, classes.classSchool, classes.classSuffix, classes.className FROM classes INNER JOIN enrollment WHERE enrollment.userID = '$id' AND enrollment.progress = 1 AND classes.classID = enrollment.classID";
            $res = mysqli_query($this->db, $sql);
            while($row = mysqli_fetch_assoc($res))
            {
                $class = $row['classID'];
                $temp = "gradeBox-".$row['classID'];
                if(isset($_POST[$temp])) # If the box is checked, it will update the information to the student's roster
                {
                    $val = $_POST[$temp];
                    echo "<script>console.log('".$temp." is set!');</script>";
                    $sql = "UPDATE enrollment SET progress = '$val' WHERE userID = '$id' AND classID = '$class'";
                    mysqli_query($this->db, $sql);
                }
            }
            return true;
        } catch(Exception $e){return false;}
    }

   /********Private*********/

    # Connect to the database
    private function dbconnect(){
        try{
            $db = mysqli_connect("localhost", "script", "pass123");
            mysqli_select_db($db, "mis-web") or die ('Unable to connect to the MySQL');
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
            $this->dbconnect();
            $res = mysqli_query($this->db, $sql);
            return (mysqli_fetch_assoc($res));
        } catch(Exception $e){return false;}
    }
}
