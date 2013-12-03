<?php
    include '../lib/usercard.php';
    include '../lib/formatter.php';
    $user = new UserCard();
    $f = new formatter(false);
    $f->header();
    $flag = false; # Checking to see if the user is logged in
    if ($user->isLogged()){
        $f->setID($user->userID()); # Getting the user ID
        $f->takenclasses();
    }
    $f->footer();
?>