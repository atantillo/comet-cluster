<?php
    include '../lib/formatter.php';
    $f = new formatter(false);
    $f->header();
?>

<div data-role="content" class="center">
    <form action="register_save.php" method="post" data-ajax="false">
        <div data-role="fieldcontain" class="ui-hide-label">
            <fieldset data-role="controlgroup">
                <input type="text" name="user" id="basic" data-mini="true" placeholder="User Name" required/>
                <input type="password" name="pass" id="basic" data-mini="true" placeholder="Password" required/>
                <input type="text" name="email" id="basic" data-mini="true" placeholder="E-Mail" required/>
                <input type="text" name="fname" id="basic" data-mini="true" placeholder="First Name" required/>
                <input type="text" name="lname" id="basic" data-mini="true" placeholder="Last Name" required/>
                <?php $f->majors(); $f->minors(); ?><br>
                <input type="submit" name="submit" id="basic" data-mini="true" value="Create">
            </fieldset>
        </div>
    </form>
</div>

<?php $f->footer(); ?>