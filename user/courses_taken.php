<?php
    include '../lib/usercard.php';
    include '../lib/formatter.php';
    $user = new UserCard();
    $f = new formatter();
    $f->header();
    $flag = false; # Checking to see if the user is logged in
    if ($user->isLogged()){
        $flag = true;
        $f->setID($user->userID()); # Getting the user ID

    }

?>



<?php ?>