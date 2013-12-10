<?php
    include '../lib/usercard.php';
    include '../lib/formatter.php';
    $user = new UserCard();
    if ($user->isLogged())
    {             # Checking to see if the user is logged in
        $f = new formatter();
        $f->header();
        $flag = false;
        if($f->setID($user->userID())){ # Getting the user ID
            if($user->savenotes()){
                echo "Your notes have been saved!<br>You are being redirected back to the home page now, if you would like to go there immediately please, click the button below";
            } else {
                echo "Still messed up";
            }
        }
        echo '<a href="home.php" data-role="button">Take Me There Now</a>';
        echo'<meta http-equiv="refresh" content="5; url=home.php">';
        $f->footer();
    } else { echo "header('Location: 162.219.3.183/cc/');"; }
?>