<?php
    include '../lib/usercard.php';
    include '../lib/formatter.php';
    $user = new UserCard();
    $f = new formatter();
    $f->header();
    $flag = false; # Checking to see if the user is logged in
    if ($user->isLogged()){
        if($f->setID($user->userID())){ # Getting the user ID
            if($user->profile()){          # saving new profile information
                $flag = true;
            }
        }
    }
    if($flag)
    {
        echo "Your user information has been updated. You are being forwarded back to the home page";
    }
    if ($flag == false)
    {
        echo "Your user information has not been updated. You either entered in the incorrect information or something terrible has happened.<br>";
        echo "You are being forwarded back to the home page.";
    }
    echo'<meta http-equiv="refresh" content="5; url=home.php">';
    echo '<a href="home.php" data-role="button">Take Me There Now</a>';
    $f->footer();
?>