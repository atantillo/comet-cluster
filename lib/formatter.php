<?php

class formatter
{
    private $db = false;
    private $index = false;
    private $id = false;

    public function __construct($i)
    {
        session_start();
        $this->dbconnect();
        $this->index = $i;
    }

    public function setID($i){
        try{
            $this->id = $i;
            return true;
        }catch(Exception $e){return false;}
}

    public function header()
    {
        if($this->index == false)
        {
            echo '<!DOCTYPE html>
                    <html>
                    <head>
                        <title>Comet Cluster</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <link rel="stylesheet" href="../themes/Test.css" />
                        <link rel="stylesheet" href="../themes/jquery.mobile-1.2.0.css" />
                        <script src="../js/jquery-1.9.1.min.js"></script>
                        <script src="../js/jquery.mobile-1.3.2.min.js"></script>
                        <script src="../js/functions.js"></script>
                    </head>
                    <body>
                    <div data-role="page">
                        <div data-role="header">
                            <h1>Welcome to the Comet Cluster</h1>
                        </div>
                        <div data-role="content" class="bodyC">
                            <h2>Comet Cluster</h2>';
        } else {
            echo '<!DOCTYPE html>
                    <html>
                    <head>
                        <title>Comet Cluster</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <link rel="stylesheet" href="../themes/Test.css" />
                        <link rel="stylesheet" href="../themes/jquery.mobile-1.2.0.css" />
                        <script src="js/jquery-1.9.1.min.js"></script>
                        <script src="js/jquery.mobile-1.3.2.min.js"></script>
                        <script src="js/functions.js"></script>
                    </head>
                    <body>
                    <div data-role="page">
                        <div data-role="header">
                            <h1>Welcome to the Comet Cluster</h1>
                        </div>
                        <div data-role="content" class="bodyC">
                            <h2>Comet Cluster</h2>';
        }
    }

    public function footer()
    {
        if ($this->index == false)
        {
            echo'</div>
                    <div data-role="footer">
                        <div data-role="navbar">
                            <ul>
                                <li><a href="home.php">Home</a>
                                <li><a href="../help/about.php">About</a>
                                <li><a href="../help/contact.php">Contact Us</a>
                            </ul>
                        </div>
                    </div>
                </div>
                </body>
                </html>';
        } else {
            echo'</div>
                    <div data-role="footer">
                        <div data-role="navbar">
                            <ul>
                                <li><a href="index.php">Home</a>
                                <li><a href="help/about.php">About</a>
                                <li><a href="help/contact.php">Contact Us</a>
                            </ul>
                        </div>
                    </div>
                </div>
                </body>
                </html>';
        }
    }

    public function majors()
    {
        try{
            #$sql = "SELECT id, school FROM schools";
            #$res = mysqli_query($this->db, $sql);
            echo '<select name="majors" id="majors">';
            #while($row = mysqli_fetch_assoc($res)){ echo'<option value="'.$row['id'].'">'.$row['school'].'</option>'; }
            echo '<option value="1">Major : MIS</option>';
            echo '</select>';
            return true;
        }catch(Exception $e){return false;}
    }

    public function minors()
    {
        try{
            $sql = "SELECT id, school FROM schools";
            $res = mysqli_query($this->db, $sql);
            echo '<select name="minors" id="minors">';
            while($row = mysqli_fetch_assoc($res)){ echo'<option value="'.$row['id'].'">Minor : '.$row['school'].'</option>'; }
            echo '</select>';
            return true;
        }catch(Exception $e){return false;}
    }

    public function pendingclasses()
    {
        try{
            $sql = "SELECT classes.classID, classes.classSchool, classes.classSuffix, classes.className FROM classes INNER JOIN enrollment WHERE enrollment.userID = '$this->id' AND enrollment.progress = 0 AND classes.classID = enrollment.classID";
            $res = mysqli_query($this->db, $sql);
            echo '<form action="courses_pending_check.php" method="post" data-ajax="false">';
            echo '<b>Classes You Are Currently Enrolled In or Have Completed</b><br>';
            echo '<div data-role="fieldcontain">
                        <fieldset data-role="controlgroup">';
            while($row = mysqli_fetch_assoc($res))
            {
                echo '<input type="checkbox" name="checkbox-'.$row['classID'].'" id="checkbox-'.$row['classID'].'" class="custom"/>
                      <label for="checkbox-'.$row['classID'].'">'.$row['classSchool'].''.$row['classSuffix'].' - '.$row['className'].'</label>';
            }
            echo '            <br><input type="submit" value="Update Classes">
                        </fieldset>
                  </div></form>';
            return true;
        }catch(Exception $e){return false;}
    }

    public function takenclasses()
    {
        try{
            $sql = "SELECT classes.classID, classes.classSchool, classes.classSuffix, classes.className FROM classes INNER JOIN enrollment WHERE enrollment.userID = '$this->id' AND enrollment.progress = 1 AND classes.classID = enrollment.classID";
            $res = mysqli_query($this->db, $sql);
            echo '<form action="courses_taken_check.php" method="post" data-ajax="false">';
            echo '<b>How did you do in your classes?</b><br>';
            echo '<div data-role="fieldcontain">
                        <fieldset data-role="controlgroup">';
            while($row = mysqli_fetch_assoc($res))
            {
                echo '<input type="checkbox" name="checkbox-'.$row['classID'].'" id="checkbox-'.$row['classID'].'" class="custom" onclick="givegrade(\''.$row["classID"].'\')"/>
                      <label for="checkbox-'.$row['classID'].'">'.$row['classSchool'].''.$row['classSuffix'].' - '.$row['className'].'</label>
                      <div id="gradeBox-'.$row['classID'].'" data-role="fieldcontain"></div>';
            }
            echo '            <br><input type="submit" value="Update Classes">
                        </fieldset>
                  </div></form>';
            return true;
        }catch(Exception $e){return false;}
    }

    public function completedclasses()
    {
        try{
            $sql = "SELECT classes.classID, classes.classSchool, classes.classSuffix, classes.className, enrollment.progress FROM classes INNER JOIN enrollment WHERE enrollment.userID = '$this->id' AND enrollment.progress >= 2 AND classes.classID = enrollment.classID";
            $res = mysqli_query($this->db, $sql);
            echo '<b>Classes You Are Currently Enrolled In or Have Completed</b><br>';
            echo '<div data-role="content" class="center">
                    <ul data-role="listview" data-filter="false">';
            while($row = mysqli_fetch_assoc($res))
            {
                echo '<li class="center">'.$row['classSchool'].$row['classSuffix'].' - '.$row['className'].', '.$this->sqltograde($row['progress']).'</li>';
            }
            echo '  </ul>
                  </div>';
            return true;
        }catch(Exception $e){return false;}
    }

    public function profile()
    {
        try{
            $sql = "SELECT users.userID, users.userLogin, users.userPass, userinfo.firstName, userinfo.lastName, userInfo.email FROM users INNER JOIN userinfo WHERE users.userID = userinfo.userID AND users.userID = '$this->id'";
            $res = mysqli_query($this->db, $sql);
            $row = mysqli_fetch_assoc($res);
            echo '<form action="profile_update.php" method="post" data-ajax="false">';
            echo '<b>Classes You Are Currently Enrolled In or Have Completed</b><br>';
            echo '<div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <input type="text" name="user" class="custom" value="'.$row['userLogin'].'"/>
                        <label for="user">User Name</label>
                        <br><input type="submit" value="Update Classes">
                        </fieldset>
                  </div></form>';
            return true;
        }catch(Exception $e){return false;}
    }

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

    private function sqltograde($g)
    {
        #2 = F, 3 = D, 4 = C, 5 = B, 6 = A
        switch($g){
            case 2:
                $grade = "F";
                break;
            case 3:
                $grade = "D";
                break;
            case 4:
                $grade = "C";
                break;
            case 5:
                $grade = "B";
                break;
            case 6:
                $grade = "A";
                break;
            default:
                $grade = "F";
                break;
        }
        return $grade;
    }
} 