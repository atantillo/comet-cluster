<?php
    include '../lib/formatter.php';
    include '../lib/usercard.php';
    $user = new UserCard();
    if ($user->isLogged())
    {
        $f = new formatter(false);
        $f->header();
        echo'<div data-role="content" class="center">
                <ul data-role="listview" data-filter="false">
                    <li class="center"><a href="courses_pending.php">Required Courses</a></li>
                    <li class="center"><a href="courses_current.php">Current Courses</a></li>
                    <li class="center"><a href="courses_taken.php">Grade Courses</a></li>
                    <li class="center"><a href="courses_completed.php">Completed Courses</a></li>
                    <li class="center"><a href="schedule.php">Schedule</a></li>
                    <li class="center"><a href="map.php">Map</a></li>
                    <li class="center"><a href="notes.php">Notes</a></li>
                    <li class="center"><a href="profile.php">Profile</a></li>
                </ul>
            </div>';
        $f->footer();
    } else { echo "header('Location: 162.219.3.183/cc/');"; }
?>