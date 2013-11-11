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
            session_start();
            $this->dbConnect();
            # If and only if they submit the form and everything is entered...
            if (isset($_POST['user'],$_POST['pass'],$_POST['email'],$_POST['fname'],$_POST['lname'],$_POST['major'],$_POST['minor']))
            {
                $this->user = $this->sqlclean($_POST['user']);
                $this->$pass = $this->sqlclean($_POST['pass']);
                $this->lname = $this->sqlclean($_POST['fname']);
                $this->fname = $this->sqlclean($_POST['lname']);
                $this->major = $this->sqlclean($_POST['major']);
                $this->minor = $this->sqlclean($_POST['minor']);
                $this->email = $this->sqlclean($_POST['email']);
            }
            return false;
        } catch(Exception $e) {return false;}
    }

    /*********Public**********/

    public function ismade(){
        try{
            if ($this->user != false){
                return true;
            }
            return false;
        } catch(Exception $e) {return false;}
    }

    #Stores the new user in the database
    public function createuser(){
        try{
            # First we are going to see if a user already exists with the given e-mail address
            if ($this->userexist() == true){
                # First we are going to put the user account in users
                $sql = "INSERT INTO users (userLogin, userPass) VALUES ('$this->user', '$this->pass')";
                if ($this->dbquery($sql) != false) {
                    # Now lets find out the ID that the user was assigned so we can mess around with the userinfo table
                    $sql = "SELECT userID FROM users WHERE userLogin = '$this->user' AND userPass = '$this->pass'";
                    $results = $this->dbqueryarray($sql);
                    # Making sure we were able to retrieve the userID
                    if($results['userID']){
                        $id = $results['userID'];
                        # Now we are going to do the userinfo
                        $sql = "INSERT INTO userinfo (userID, firstName, lastName, major, minor, email) VALUES ('$id', '$this->fname', '$this->lname', '$this->major', '$this->minor', '$this->email')";
                        if ($this->dbquery($sql) != false) {
                            #Everything was a success. Returning true to let the user know.
                            return true;
                        } else {
                            echo "<script>alert('Warning: There was an error creating your account. Please try again later.');</script>";
                            return false;
                        }
                    }
                } else {
                    echo "<script>alert('Warning : Error when creating new user');</script>";
                    return false;
                }
            }
            else { return false; }
        } catch(Exception $e) {
            echo "<script>alert('Warning : The following error has occurred : ".$e.". Your account was not made.');</script>";
            return false;
        }
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

    # Checks to see if a user is already registered to an e-mail
    private function userexist(){
        # If the array is not empty than that means we have a user that already has this e-mail. Returns false, letting them know that the e-mail is already in use
        # If the array is empty or false, we will make two new entries in database, in the userinfo and users table
        $sql = "SELECT userID FROM userinfo WHERE email = '$this->email'";
        $results = $this->dbqueryarray($sql);
        if(count($results) == 0) {
            # No user registered that e-mail. Now lets check to see if the username is already in use
            $sql = "SELECT userID FROM userinfo WHERE email = '$this->email'";
            $results = $this->dbqueryarray($sql);
            if(count($results) == 0) {
                return true;
            } else {
                echo"<script>alert('Warning : This username already exists. Your account was not made.');</script>";
                return false;
            }
        }
        else {
            echo"<script>alert('Warning : This email address has already been registered. Your account was not made.');</script>";
            return false;
        }
    }
}
