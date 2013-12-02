<?php
    include '../lib/formatter.php';
    $f = new formatter(false);
    $f->header();
?>
<div data-role="content" class="center">
    <ul data-role="listview" data-filter="false">
        <li class="center"><a href="courses_taken.php">Courses Taken</a></li>
        <li class="center"><a href="courses_pending.php">Pending Courses</a></li>
        <li class="center"><a href="map.php">Map</a></li>
        <li class="center"><a href="profile.php">Profile</a></li>
    </ul>
</div>
<?php $f->footer(); ?>
