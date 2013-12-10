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
            if($user->savecurrentclasses()){
                $flag = true;
            }
        }
        if ($flag == false){
            echo "Still messed up";
        } else {
            echo "Classes successfully updated. Check out your schedule now!<br>";
            echo "You are being redirected back to the home page now, if you would like to go there immediately please, click the button below<br>";
            echo '<a href="home.php" data-role="button">Take Me There Now</a>';
            echo'<meta http-equiv="refresh" content="5; url=home.php">';
        }
        $f->footer();
    } else { header('Location: http://162.219.3.183/cc/'); }
?>