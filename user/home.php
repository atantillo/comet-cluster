<?php ?>

<!DOCTYPE html>
<html>
<head>
    <title>Comet Cluster</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../themes/Test.css" />
    <link rel="stylesheet" href="../themes/jquery.mobile-1.2.0.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>
<div data-role="page">
    <div data-role="header">
        <h1>Comet Cluster</h1>
    </div>
    <div data-role="content" class="bodyC">
        <h2>Log In</h2>
        <form action="login.php" method="post" data-ajax="false">
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
    </div>
    <div data-role="footer">
        <div data-role="navbar">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../help/about.php">About</a></li>
                <li><a href="../help/contact.php">Contact Us</a></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
