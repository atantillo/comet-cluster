<?php

class formatter {
    private $db = false;
    private $index = false;

    public function __construct($i){
        $this->dbconnect();
        $this->index = $i;
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
                                <li><a href="../index.php">Home</a>
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
        #$sql = "SELECT id, school FROM schools";
        #$res = mysqli_query($this->db, $sql);
        echo '<select name="majors" id="majors">';
        #while($row = mysqli_fetch_assoc($res)){ echo'<option value="'.$row['id'].'">'.$row['school'].'</option>'; }
        echo '<option value="1">Major : MIS</option>';
        echo '</select>';
    }

    public function minors()
    {
        $sql = "SELECT id, school FROM schools";
        $res = mysqli_query($this->db, $sql);
        echo '<select name="minors" id="minors">';
        while($row = mysqli_fetch_assoc($res)){ echo'<option value="'.$row['id'].'">Minor : '.$row['school'].'</option>'; }
        echo '</select>';
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
} 