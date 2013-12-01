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
        $error = "program starting";
        try
        {   # First we are going to see if a user already exists with the given e-mail address
            if ($this->userexist() != true)
            {
                $error = "New User!";
                # First we are going to put the user account in users
                $sql = "INSERT INTO users (userLogin, userPass) VALUES ('$this->user', '$this->pass')";
                if (mysqli_query($this->db, $sql) != false)
                {
                    $error = "User account made";
                    # Now lets find out the ID that the user was assigned so we can mess around with the userinfo table
                    $sql = "SELECT userID FROM users WHERE userLogin = '$this->user' AND userPass = '$this->pass'";
                    $res = mysqli_query($this->db, $sql);
                    $row = mysqli_fetch_assoc($res);
                    # Making sure we were able to retrieve the userID
                    if($row['userID'])
                    {
                        $error = "User account attainable";
                        $id = $row['userID'];
                        # Now we are going to do the userinfo
                        $sql = "INSERT INTO userinfo (userID, firstName, lastName, major, minor, email) VALUES ('$id', '$this->fname', '$this->lname', '$this->major', '$this->minor', '$this->email')";
                        if (mysqli_query($this->db, $sql) == true) {
                            $error = "User Info Stored";
                            #Everything was a success. Returning true to let the user know.
                            return true;
                        } } } }
            return $error;
        } catch(Exception $e) {
            echo "Warning : The following error has occurred : ".$e.". Your account was not made.";
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
        if(mysqli_num_rows($res) == 0) { return true; }
        return false;
    }

    # Sends a query to the database, returns the result
    private function dbquery($sql){
        try{
            $this->dbconnect();
            return(mysqli_query($this->db, $sql));
        } catch(Exception $e){return false;}
    }

    # Queries the database, returns an array of the contents
    private function dbqueryarray($sql){
        try{
            $this->dbconnect();
            return (mysqli_fetch_assoc(mysqli_query($this->db, $sql)));
        } catch(Exception $e){return false;}
    }
}
