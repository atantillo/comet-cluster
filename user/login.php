<?php
    include '../lib/formatter.php';
    $f = new formatter(false);
    $f->header();
?>

<form action="login_check.php" method="post" data-ajax="false">
    <div data-role="fieldcontain" class="ui-hide-label">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="" placeholder="Username"/>
    </div>
    <div data-role="fieldcontain" class="ui-hide-label">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="" placeholder="Password"/>
    </div>
    <input type="submit" value="Log In">
</form>

<?php
    $f->footer();
?>
