<?php

class RegisterCard
{
    /*********Variables***********/

    private $db = false;
    #private $id = false;
    private $user = false;
    private $pass = false;
    private $lname = false;
    private $fname = false;
    private $major = false;
    private $minor = false;
    private $email = false;

    /*********Constructors***********/

    # Constructor that uses session values
    public function __construct()
    {
        try {
            $this->dbconnect();
            # If and only if they submit the form and everything is entered...
            return true;
        } catch(Exception $e) {return false;}
    }

    /*********Public**********/
    public function getinfo($u, $p, $e, $f, $l, $m ,$n)
    {
        try {
            if ($this->db == false){ echo "Db is false"; }
            $this->user = $this->sqlclean($u);
            $this->pass = $this->sqlclean($p);
            $this->lname = $this->sqlclean($l);
            $this->fname = $this->sqlclean($f);
            $this->major = $this->sqlclean($m);
            $this->minor = $this->sqlclean($n);
            $this->email = $this->sqlclean($e);
            return true;
        } catch(Exception $e) {return false;}
    }

    public function ismade()
    {
        try{
            if (isset($this->user, $this->db, $this->pass, $this->email))
            {
                return true;
            }
            return false;
        } catch(Exception $e) {return false;}
    }

    #Stores the new user in the database
    public function createuser()
    {
        try
        {   # First we are going to see if a user already exists with the given e-mail address
            if ($this->userexist() != true)
            {
                # First we are going to put the user account in users
                $sql = "INSERT INTO users (userLogin, userPass) VALUES ('$this->user', '$this->pass')";
                if (mysqli_query($this->db, $sql) != false)
                {
                    # Now lets find out the ID that the user was assigned so we can mess around with the userinfo table
                    $sql = "SELECT userID FROM users WHERE userLogin = '$this->user' AND userPass = '$this->pass'";
                    $res = mysqli_query($this->db, $sql);
                    $row = mysqli_fetch_assoc($res);
                    # Making sure we were able to retrieve the userID
                    if($row['userID'])
                    {
                        $id = $row['userID'];
                        # Now we are going to do the userinfo
                        $sql = "INSERT INTO userinfo (userID, firstName, lastName, major, minor, email) VALUES ('$id', '$this->fname', '$this->lname', '$this->major', '$this->minor', '$this->email')";
                        if (mysqli_query($this->db, $sql) == true)
                        {
                            #Time to enroll the MIS student into classes
                            $sql = "INSERT INTO enrollment (classID, userID, progress) SELECT classID, '$id', '0' FROM classes";
                            #Everything was a success. Returning true to let the user know.
                            if (mysqli_query($this->db, $sql) == true)
                            {
                                $sql = "INSERT INTO notes (userID) VALUES ('$id')";
                                if (mysqli_query($this->db, $sql) == true)
                                {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
            return false;
        } catch(Exception $e) { return false; }
    }

    public function printout()
    {
        try{
            # For Debugging
            echo "Printing out Register Object<br>";
            echo "============================<br>";
            echo "User : ". $this->user . "<br>";
            echo "Pass : ". $this->pass . "<br>";
            echo "Lname: ". $this->lname. "<br>";
            echo "Fname: ". $this->fname. "<br>";
            echo "Major: ". $this->major. "<br>";
            echo "Minor: ". $this->minor. "<br>";
            echo "Email: ". $this->email. "<br>";
            echo "=========================<br>";
            return true;
        } catch(Exception $e) {
            return false;
        }
    }


    /********Private*********/

    # Connects the Database
    private function dbconnect(){
        try{
            $db = mysqli_connect("localhost", "script", "pass123");
            mysqli_select_db($db, "mis-web") or die ('Unable to connect to the MySQL');
            $this->db = $db;
            return true;
        }catch(Exception $e){return false;}
    }

    # Makes sure there is no SQL Injection
    private function sqlclean($sql){
        try{
            return(mysqli_real_escape_string($this->db, $sql));
        } catch(Exception $e){return false;}
    }

    # Checks to see if a user is already registered to an e-mail
    private function userexist(){
        # If the array is not empty than that means we have a user that already has this e-mail. Returns false, letting them know that the e-mail is already in use
        # If the array is empty or false, we will make two new entries in database, in the userinfo and users table
        $sql = "SELECT userID FROM userinfo WHERE email = '$this->email'";
        $res = mysqli_query($this->db, $sql);
        if(mysqli_num_rows($res) == 0) { return false; }
        return true;
    }
}
