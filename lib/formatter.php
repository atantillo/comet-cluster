<?php

class formatter
{
    private $db = false;
    private $index = false;
    private $about = false;
    private $id = false;

    public function __construct($i, $a)
    {
        session_start();
        $this->dbconnect();
        $this->index = $i;
        $this->about = $a;
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
                        <title>CourseChex</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <link rel="stylesheet" href="../themes/style.css" />
                        <script src="../js/jquery-1.9.1.min.js"></script>
                        <script src="../js/jquery.mobile-1.3.2.min.js"></script>
                        <script src="../js/functions.js"></script>
                    </head>
                    <body>
                    <div data-role="page">
                        <div data-role="header">
                            <h1>Welcome to the CourseChex</h1>
                            <a href="../" data-icon="home" data-iconpos="notext" data-theme="b" data-ajax="false" class="ui-btn-right ui-btn-corner-bl">Log Out</a>
                        </div>
                        <div data-role="content" class="bodyC">
                            <h2>CourseChex</h2>';
        } else {
            echo '<!DOCTYPE html>
                    <html>
                    <head>
                        <title>CourseChex</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <link rel="stylesheet" href="themes/style.css" />
                        <script src="js/jquery-1.9.1.min.js"></script>
                        <script src="js/jquery.mobile-1.3.2.min.js"></script>
                        <script src="js/functions.js"></script>
                    </head>
                    <body>
                    <div data-role="page">
                        <div data-role="header">
                            <h1>Welcome to the CourseChex</h1>
                        </div>
                        <div data-role="content" class="bodyC">
                            <h2>CourseChex</h2>';
        }
    }

    public function footer()
    {
        if ($this->index){
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
        else  if ($this->about){
            echo'</div>
                    <div data-role="footer">
                        <div data-role="navbar">
                            <ul>
                                <li><a href="../index.php">Home</a>
                                <li><a href="about.php">About</a>
                                <li><a href="contact.php">Contact Us</a>
                            </ul>
                        </div>
                    </div>
                </div>
                </body>
                </html>';
        }
        else
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
            echo '<b>Classes That Are Required For Your Major</b><br>';
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

    public function currentclasses()
    {
        try{
            $sql = "SELECT classes.classID, classes.classSchool, classes.classSuffix, classes.className,
                    classavailable.timeStart, classavailable.timeEnd, classavailable.classDays, classavailable.classRoom, classavailable.classInst,
                    instructors.name FROM classes INNER JOIN enrollment INNER JOIN instructors INNER JOIN classavailable
                    WHERE enrollment.userID = '$this->id' AND enrollment.progress = 1 AND classes.classID = enrollment.classID
                    AND classes.classID = classavailable.classID AND classavailable.instID = instructors.instID ORDER BY classes.classID ASC";
            $res = mysqli_query($this->db, $sql);
            echo '<form action="courses_current_check.php" method="post" data-ajax="false">';
            echo '<b>What Class Did You Enroll In?</b><br>';
            echo '<div data-role="fieldcontain">
                        <fieldset data-role="controlgroup">';
            while($row = mysqli_fetch_assoc($res))
            {
                echo '<input type="radio" name="checkbox-'.$row['classID'].'" id="checkbox-'.$row['classID'].'" class="custom" value="'.$row['classInst'].' checked"/>
                      <label for="checkbox-'.$row['classID'].'">'.$row['classSchool'].''.$row['classSuffix'].' - '.$row['className'].' with '.$row['name'].' on '.$row['classDays'].' at '.$row['timeStart'].'-'.$row['timeEnd'].'</label>';
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
            echo '<b>Courses You Have Completed</b><br>';
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

    public function schedule()
    {
        try{
            $sql = "SELECT classes.classSchool, classes.classSuffix, classes.className,
                    classavailable.timeStart, classavailable.timeEnd, classavailable.classDays, classavailable.classRoom, classavailable.classInst,
                    instructors.name FROM classes INNER JOIN enrollment INNER JOIN instructors INNER JOIN classavailable
                    WHERE enrollment.userID = '$this->id' AND enrollment.progress = 1 AND enrollment.classInst != 0 AND classes.classID = enrollment.classID
                    AND classes.classID = classavailable.classID AND classavailable.instID = instructors.instID";
            $res = mysqli_query($this->db, $sql);
            echo '<b>Classes You Are Currently Enrolled In</b><br>';
            echo '<div data-role="content" class="center">
                    <ul data-role="listview" data-filter="false">';
            while($row = mysqli_fetch_assoc($res))
            {
                echo '<li class="center">'.$row['classSchool'].''.$row['classSuffix'].' - '.$row['className'].' with '.$row['name'].' on '.$row['classDays'].' at '.$row['timeStart'].'-'.$row['timeEnd'].'</li>';
            }
            echo '  </ul>
                  </div>';
            return true;
        }catch(Exception $e){return false;}
    }

    public function notes()
    {
        try{
            $sql = "SELECT notes FROM notes WHERE userID = '$this->id'";
            $res = mysqli_query($this->db, $sql);
            $row = mysqli_fetch_assoc($res);
            echo '<b>Your Note Pad</b><br>';
            echo '<form action="save_notes.php" method="post" data-ajax="false">';
            echo '<div data-role="fieldcontain" class="center">';
            echo '<textarea cols="100" rows="8" name="textarea" id="textarea">'.$row['notes'].'</textarea>';
            echo '<br><input type="submit" value="Save Notes">
                  </div></form>';
            return true;
        }catch(Exception $e){return false;}
    }


    public function profile()
    {
        try{
            $sql = "SELECT users.userID, users.userLogin, users.userPass, userinfo.firstName, userinfo.lastName, userinfo.email FROM users INNER JOIN userinfo WHERE users.userID = userinfo.userID AND users.userID = '$this->id'";
            $res = mysqli_query($this->db, $sql);
            $row = mysqli_fetch_assoc($res);
            echo '<form action="profile_update.php" method="post" data-ajax="false">';
            echo '<b>Classes You Are Currently Enrolled In or Have Completed</b><br>';
            echo '<div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="user">User Name</label>
                        <input type="text" id="basic" data-mini="true" name="user" placeholder="User Name" readonly value="'.$row['userLogin'].'"/>
                        <label for="user">New Password</label>
                        <input type="password" id="basic" data-mini="true" name="pass"/>
                        <label for="user">First Name</label>
                        <input type="text" id="basic" data-mini="true" name="fname" placeholder="First Name" value="'.$row['firstName'].'"/>
                        <label for="user">Last Name</label>
                        <input type="text" id="basic" data-mini="true" name="lname" placeholder="Last Name" value="'.$row['lastName'].'"/>
                        <label for="user">Email Name</label>
                        <input type="text" id="basic" data-mini="true" name="email" placeholder="Email" value="'.$row['email'].'"/>
                        <label for="user">Current Password</label>
                        <br><input type="password" id="basic" data-mini="true" name="cpass" value=""/>
                        <br><input type="submit" value="Update Info">
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