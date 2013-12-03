<?php
include '../lib/usercard.php';
include '../lib/formatter.php';
$user = new UserCard();
$f = new formatter();
$f->header();
$flag = false; # Checking to see if the user is logged in
if ($user->isLogged()){
    if($f->setID($user->userID())){ # Getting the user ID
        if($f->currentclasses()){
            $flag = true;
        }
    }
}
if ($flag == false){
    echo "Still messed up";
}
$f->footer();
?>