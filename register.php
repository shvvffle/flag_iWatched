<?php
    require_once("config.php");

    if(isset($_SESSION["user_id"])) {
		header("Location: index.php");
		exit;
	}

	if(isset($_POST["submit"])) {
		foreach($_POST as $key => $value) {
			$_POST[$key] = strip_tags(trim($value));
		}

		if(
			!empty($_POST["username"]) &&
			!empty($_POST["password"]) &&
			$_SESSION["captcha"] === $_POST["captcha"] &&
			filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) &&
			$_POST["password"] === $_POST["rep_password"]
		) {

			/* check and confirm if the user already exists */
			$query = $db->prepare("SELECT email FROM users WHERE email = ?");
			$query->execute( array($_POST["email"]) );
			$result = $query->fetchAll( PDO::FETCH_ASSOC );

			if(empty($result)) {
				/* if the user doesn't exist, INSERT in db */
				$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

				$query = $db->prepare("
					INSERT INTO users
					(email, password, username)
					VALUES(?, ?, ?)
				");
				$query->execute(
					array(
						$_POST["email"],
						$password,
						$_POST["username"]
					)
				);

				$message = "Account created successfully!";
				header("Location: login.php");
			} else {
				$message = "This user already exists. Please <a href='login.php'>login instead.</a>";
			}
		} else {
			$message = "Fill in all fields correctly.";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>iWatched - Register</title>
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
                <?php
                    if(isset($user_logged)){
                ?>
                    <a href="movies.php">Movies</a>
                <?php
                    }
                ?>
                <a href="login.php">Login</a>
            </div>
        </nav>
    </header>
    <section class="login-register-form">
    <?php
		if(isset($message)) echo "<p class='red'>" .$message. "</p>";
	?>
    	<h2>Create an account to keep record of what you've been watching</h2>
		<form method="post" action="register.php">
			<div class="email">
				<label>
					<span class="fa fa-envelope" aria-hidden="true"></span>
					<span class="hidden">Email</span>
				</label>
				<input type="email" name="email" placeholder="Email" required>
			</div>
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
			<div class="repeat-password">
				<label>
					<span class="fa fa-lock red" aria-hidden="true"></span>
					<span class="hidden">Repeat password</span>
				</label>
				<input type="password" name="rep_password" placeholder="Repeat password" required>
			</div>
			<div class="captcha">
				<img src="captcha.php" alt="captcha">
				<input type="text" name="captcha" required>
			</div>
			<div class="submit">
				<input class="register" type="submit" name="submit" value="Create account">
			</div>
		</form>
		<p class="register">Already registered? <a href="login.php">Login now</a></p>
    </section>
</body>
</html>