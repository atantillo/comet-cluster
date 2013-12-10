<?php
    include '../lib/usercard.php';
    include '../lib/formatter.php';
    $user = new UserCard();
    if ($user->isLogged()){
        $f = new formatter(false);
        $f->header();
        $flag = false; # Checking to see if the user is logged in
        $f->setID($user->userID()); # Getting the user ID
        $f->takenclasses();
        $f->footer();
    } else { echo "header('Location: 162.219.3.183/cc/');"; }
?>