<?php
    include '../lib/formatter.php';
    include '../lib/usercard.php';

    $user = new UserCard();
    if ($user->isLogged())
    {
        $f = new formatter(false);
        $f->header();
        echo' <iframe class="myframe" src="http://www.utdallas.edu/maps/"></iframe> ';
        $f->footer();
    } else { echo "header('Location: 162.219.3.183/cc/');"; }
?>

