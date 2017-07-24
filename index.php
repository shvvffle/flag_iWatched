<?php
    require_once("models/config.php");

    $query = $db->prepare("
                SELECT user_id, username FROM users
            ");
    $query->execute( array($_POST["username"]) );
    $user = $query->fetchAll( PDO::FETCH_ASSOC );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>iWatched</title>
    <meta charset="UTF-8">
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
                <a href="views/movies.php">Movies</a>
                <?php
                    if(isset($_SESSION["user_id"])){
                        echo "<p class='welcome'>Welcome back " .$user[0]["username"]. "!</p>";
                    } else {
                        echo "<a href='controllers/login.php'>Login</a>";

                    }
                ?>
            </div>
        </nav>
    </header>
    <?php
        if(isset($_SESSION["user_id"])){
    ?>
    <section class="intro-logged">
        <h2>Hello <span class="red"><?php echo $user[0]["username"]; ?>!</span> What have you been watching lately?</h2>
        <div class="last-seen">
            <div class="movie-thumb">
                <div class="movie-cover">
                    <img src="http://img.moviepostershop.com/heartbeats-movie-poster-2010-1010557028.jpg">
                </div>
                <div class="movie-title">
                    <h4>Movie Title</h4>
                </div>
                <div class="movie-rating">
                    <p>4 stars</p>
                </div>
            </div>
            <div class="movie-thumb">
                <div class="movie-cover">
                    <img src="http://img.moviepostershop.com/heartbeats-movie-poster-2010-1010557028.jpg">
                </div>
                <div class="movie-title">
                    <h4>Movie Title</h4>
                </div>
                <div class="movie-rating">
                    <p>4 stars</p>
                </div>
            </div>
            <div class="movie-thumb">
                <div class="movie-cover">
                    <img src="http://img.moviepostershop.com/heartbeats-movie-poster-2010-1010557028.jpg">
                </div>
                <div class="movie-title">
                    <h4>Movie Title</h4>
                </div>
                <div class="movie-rating">
                    <p>4 stars</p>
                </div>
            </div>
            <div class="movie-thumb">
                <div class="movie-cover">
                    <img src="http://img.moviepostershop.com/heartbeats-movie-poster-2010-1010557028.jpg">
                </div>
                <div class="movie-title">
                    <h4>Movie Title</h4>
                </div>
                <div class="movie-rating">
                    <p>4 stars</p>
                </div>
            </div>
            <!-- show latest added movies -->
        </div>
        <div class="movies-actions">
            <button><a href="controllers/add_movie.php">Add a Movie</a></button>
        </div>
    </section>
    <?php
       } else {
    ?>
    <section class="intro-not-logged">
        <h2><span class="red">iWatched</span> enables you to keep a record of the movies you watched</h2>
        <p>Pretty cool right?</p>
        <p class="login-register">Before starting, please <a href="controllers/login.php">login or register!</a></p>
    </section>
    <?php
       }
    ?>
</body>
</html>