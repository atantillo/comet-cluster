<?php
    include '../lib/registercard.php';
    include '../lib/formatter.php';
    $flag = false;
    try
    {
        $user = new RegisterCard();
        if(isset($_POST['user'],$_POST['pass'],$_POST['email'],$_POST['fname'],$_POST['lname'],$_POST['majors'],$_POST['minors'])) # Check if they filled out the forms
        {
            if($user->getinfo($_POST['user'],$_POST['pass'],$_POST['email'],$_POST['fname'],$_POST['lname'],$_POST['majors'],$_POST['minors'])) # Throw them into the object
            {
                if($user->createuser()){ # Throw the information into the database
                    $flag = true;
                }
            }
        }
    } catch(Exception $e) { echo $e; }
    $f = new formatter(false);
    $f->header();
    if($flag){
        echo 'Congratulations! Your account was successfully made. Please click the following button to return and log in with your credentials<br>';
        echo '<a href="login.php" data-role="button">Return to Log In</a>';
    } else {
        echo 'Either something went wrong with the user registration, or an account is already registered to that e-mail address. Please try again.<br>';
        echo '<a href="register.php" data-role="button">Try Registering Again</a>';
    }
    $f->footer();
?>