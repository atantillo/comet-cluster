<?php
    include '../lib/registercard.php';
    include '../lib/formatter.php';
    try
    {
        if(isset($_POST['submit']))
        {
            $flag = "step making card";
            $user = new RegisterCard();
            $flag = "done making card";
            if(isset($_POST['user'],$_POST['pass'],$_POST['email'],$_POST['fname'],$_POST['lname'],$_POST['majors'],$_POST['minors'])) # Check if they filled out the forms
            {
                $flag = "all values set";
                if($user->getinfo($_POST['user'],$_POST['pass'],$_POST['email'],$_POST['fname'],$_POST['lname'],$_POST['majors'],$_POST['minors'])) # Throw them into the object
                {
                    $flag = "user info stored locally";
                    $message = $user->createuser(); # Throw the information into the database
                    $flag = "user info stored globally";
                    $flag = false;
                }
            }
            if ($flag != false)
            {
                echo "<script>alert('There was an error creating your user account. ".$flag."')</script>";
                echo "<script>console.log('There was an error creating your user account. ".$flag."')</script>";
            }
        }
    } catch(Exception $e) {echo $e;}
    $f = new formatter(false);
    $f->header();
?>
bloop

<?php $f->footer(); ?>