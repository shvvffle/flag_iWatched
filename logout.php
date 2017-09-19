<?php
	require_once("config.php");

	if(isset($_SESSION["user_id"])){
			session_destroy();
    } else {
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>iWatched - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1><a href="index.php" class="logo">iWatched</a></h1>
            </div>
            <div class="menu">
                <a href="login.php">Login</a>
            </div>
        </nav>
    </header>
    <section class="intro-not-logged">
        <h2>You have been successfully logged out.</h2>
        <p>If you want, you can always <a href="login.php">login</a> again!</p>
     </section>
</body>
</html>