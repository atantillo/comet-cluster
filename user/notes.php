<?php
    include '../lib/usercard.php';
    include '../lib/formatter.php';
    $user = new UserCard();
    if ($user->isLogged())
    {
        $f = new formatter();
        $f->header();
        $f->setID($user->userID()); # Getting the user ID
        $f->notes();
        $f->footer();
    } else { echo "header('Location: 162.219.3.183/cc/');"; }
?>