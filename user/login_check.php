<?php
    include '../lib/formatter.php';
    $f = new formatter(false);
    $f->header();
    $flag = false;
    if(isset($_POST['username'], $_POST['password'])) #If the user entered in
    {
        include '../lib/usercard.php';
        $card = new UserCard();
        if ($card->withlogin($_POST['username'], $_POST['password'])) { $flag = true; } # User log in successful! Let's let the user know
    }
    if($flag){ # If the user logged in
        echo'User Login Successful! Please wait while we forward you to your home page.<br>';
        echo'<meta http-equiv="refresh" content="5; url=home.php">';
        echo '<a href="home.php" data-role="button">Take Me There Now</a>';

    } else {
        echo'User Login Unsuccessful. Please try again.<br>';
        echo '<a href="login.php" data-role="button">Try Logging In Again</a>';
    }
    $f->footer();
?>