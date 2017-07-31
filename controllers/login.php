<?php
    require_once("../models/config.php");

    if(isset($_SESSION["user_id"])) {
		header("Location: ../index.php");
		exit;
	}

	if(isset($_POST["submit"])) {
		/* sanitize */
		foreach($_POST as $key => $value) {
			$_POST[$key] = strip_tags(trim($value));
		}

		/* validation */
		if(
			!empty($_POST["password"]) &&
			!empty($_POST["username"])
		) {

			$query = $db->prepare("
				SELECT user_id, password FROM users WHERE username = ?
			");
			$query->execute( array($_POST["username"]) );
			$user = $query->fetchAll( PDO::FETCH_ASSOC );

			if(!empty($user)) {
				/* compare password sent with the one that is encrypted on the db */
				if(password_verify($_POST["password"], $user[0]["password"])) {
					/* password is valid, user is now logged in */
					$_SESSION["user_id"] = $user[0]["user_id"];

					header("Location: ../index.php");
					exit;
				}
				else {
					$message = "The username and password you entered did not match our records. Please double-check and try again."; 
				}
			}
			else {
				$message = "The username and password you entered did not match our records. Please double-check and try again.";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>iWatched - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../images/favicon-16x16.png" sizes="16x16" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1><a href="../index.php" class="logo">iWatched</a></h1>
            </div>
            <div class="menu">
                <a href="../views/movies.php">Movies</a>
                <a class="selected" href="#">Login</a>
            </div>
        </nav>
    </header>
    <section class="login-register-form">
	    <?php
			if(isset($message)) echo "<p class='red'>" .$message. "</p>";
		?>
    	<h2>Log in to keep record of what you've been watching</h2>
		<form method="post" action="login.php">
			<div class="username">
				<label>
					<span class="fa fa-user" aria-hidden="true"></span>
					<span class="hidden">Username</span>
				</label>
				<input type="text" name="username" placeholder="Username" required>
			</div>
			<div class="password">
				<label>
					<span class="fa fa-lock" aria-hidden="true"></span>
					<span class="hidden">Password</span>
				</label>
				<input type="password" name="password" placeholder="Password" required>
			</div>
			<div class="submit">
				<input class="login" type="submit" name="submit" value="Login">
			</div>
		</form>
		<p>Not registered? <a href="register.php">Sign up now</a></p>
    </section>
</body>
</html>