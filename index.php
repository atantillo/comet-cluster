<?php
    include 'lib/formatter.php';
    $f = new formatter(true);
    $f->header();
?>
            <div data-role="content" class="center">
                <ul data-role="listview" data-filter="false">
                    <li class="center"><a href="user/login.php">Log In</a></li>
                    <li class="center"><a href="user/register.php">Register</a></li>
                </ul>
            </div>
<?php $f->footer(); ?>
