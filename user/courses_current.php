<?php
    include '../lib/usercard.php';
    include '../lib/formatter.php';
    $user = new UserCard();
    if ($user->isLogged())
    {
        $f = new formatter();
        $f->header();
        $flag = false; # Checking to see if the user is logged in
        if($f->setID($user->userID())){ # Getting the user ID
            if($f->currentclasses()){
                $flag = true;
            }
        }
        if ($flag == false){
            echo "Still messed up";
        }
        $f->footer();
    } else { header('Location: http://162.219.3.183/cc/'); }
?>