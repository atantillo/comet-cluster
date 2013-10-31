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
        <h1>Welcome to the Comet Cluster</h1>
    </div>
    <div data-role="content" class="bodyC">
        <h2>Comet Cluster</h2>
        <div data-role="content" class="center">
            <form action="" method="post">
                <div data-role="fieldcontain" class="ui-hide-label">
                    <fieldset data-role="controlgroup">
                        <input type="text" name="user" id="basic" data-mini="true" placeholder="User Name" />
                        <input type="text" name="pass" id="basic" data-mini="true" placeholder="Password" />
                        <input type="text" name="email" id="basic" data-mini="true" placeholder="E-Mail" />
                        <input type="text" name="fname" id="basic" data-mini="true" placeholder="First Name" />
                        <input type="text" name="lname" id="basic" data-mini="true" placeholder="Last Name" />
                    </fieldset>
                </div>
            </form>
        </div>
    </div>
    <div data-role="footer">
        <div data-role="navbar">
            <ul>
                <li><a href="index.php">Home</a>
                <li><a href="help/about.php">About</a>
                <li><a href="help/contact.php">Contact Us</a>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
