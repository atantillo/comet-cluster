<?php
    include '../lib/usercard.php';
    include '../lib/formatter.php';
    $user = new UserCard();
    if ($user->isLogged())
    {
        $f = new formatter();
        $f->header();
        if($f->setID($user->userID())){ # Getting the user ID
            if($user->profile()){          # saving new profile information
                echo "Your user information has been updated. You are being forwarded back to the home page";
            }
            else {
                echo "Your user information has not been updated. You either entered in the incorrect information or something terrible has happened.<br>You are being forwarded back to the home page.";
            }
        }
        echo'<meta http-equiv="refresh" content="5; url=home.php">';
        echo '<a href="home.php" data-role="button">Take Me There Now</a>';
        $f->footer();
    } else { header('Location: http://162.219.3.183/cc/'); }
?>