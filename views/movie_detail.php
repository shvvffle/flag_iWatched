<?php
    require_once("../models/config.php");

    $user_logged = $_SESSION["user_id"];

    if(isset($user_logged)){
        // get user data
        $query = $db->prepare("
                    SELECT user_id, username FROM users WHERE user_id = $user_logged
                ");
        $query->execute();
        $user = $query->fetchAll( PDO::FETCH_ASSOC );

        // load movie detail
		if(!isset($_GET["movie_id"])) {
			header("Location: ../index.php");
			exit;
		}

		$fetch_movie = $db->prepare("
			SELECT *
			FROM movies
			WHERE movie_id = ?
		");

		$fetch_movie->execute( array((int)$_GET["movie_id"]) );

		$movie = $fetch_movie->fetchAll( PDO::FETCH_ASSOC );

		if(empty($movie)) {
			header("HTTP/1.1 404 Not Found");
			die("404 Not Found.  This movie doesn't exist in our DB.");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>iWatched - <?php echo $movie[0]["title"];?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1><a href="#" class="logo">iWatched</a></h1>
            </div>
            <div class="menu">
                <a href="views/movies.php">Movies</a>
                <?php
                    if(isset($user_logged)){
                        echo "<p class='welcome'>Welcome back " .$user[0]["username"]. "!</p>";
                    } else {
                        echo "<a href='controllers/login.php'>Login</a>";

                    }
                ?>
            </div>
        </nav>
    </header>
    <section class="intro-logged">
        <h2>Hello <span class="red"><?php echo $user[0]["username"]; ?>!</span> What have you been watching lately?</h2>
        <div class="last-seen">
        <?php
            foreach($movie as $movie_detail) {
        ?>
            <div class="movie-thumb">
                <div class="movie-cover">
                    <img src="../images/<?php echo $movie[0]["cover"];?>">
                </div>
                <div class="first-detail-row">
                    <div class="movie-title">
                        <span class="fa fa-film" aria-hidden="true"></span>
                        <h4><?php echo $movie[0]["title"];?></h4>
                    </div>
                    <div class="movie-release-date">
                        <span class="fa fa-calendar-o" aria-hidden="true"></span>
                        <p><?php echo $movie[0]["release_year"];?></p>
                    </div>
                </div>
                <div class="movie-director">
                    <span class="fa fa-video-camera" aria-hidden="true"></span>
                    <p><?php echo $movie[0]["director"];?></p>
                </div>
                <div class="movie-genre">
                    <span class="fa fa-flask" aria-hidden="true"></span>
                    <p><?php echo $movie[0]["genre"];?></p>
                </div>
                <div class="movie-rating">
                    <span class="fa fa-star" aria-hidden="true"></span>
                    <p><?php echo $movie[0]["rating"];?></p>
                </div>
            </div>
        <?php
            }
        ?>
        </div>
    </section>
</body>
</html>