<?php
include '../lib/formatter.php';
include '../lib/usercard.php';
$f = new formatter(false);
$f->header();
$user = new UserCard();
$flag = false;
if ($user->isLogged()){ $flag = true; }
if($flag)
{
    echo' <iframe class="myframe" src="http://www.utdallas.edu/maps/"></iframe> ';
} else {
    echo 'Your session has ended. Please try logging in again.';
    echo'<meta http-equiv="refresh" content="5; url=../index.php">';
}
?>

<?php $f->footer(); ?>
