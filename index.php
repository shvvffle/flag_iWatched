<?php
    require_once("models/config.php");

    $user_logged = $_SESSION["user_id"];

    if(isset($user_logged)){
        // get user data
        $query = $db->prepare("
                    SELECT user_id, username FROM users
                ");
        $query->execute( array($_GET["username"]) );
        $user = $query->fetchAll( PDO::FETCH_ASSOC );

        // load movies
        $fetch_movie = $db->prepare("
                SELECT * FROM movies WHERE user_id = $user_logged ORDER BY movie_id DESC
            ");

        $fetch_movie->execute();
        $movies = $fetch_movie->fetchAll( PDO::FETCH_ASSOC );
    }
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
    <?php
        if(isset($user_logged)){
    ?>
    <section class="intro-logged">
        <h2>Hello <span class="red"><?php echo $user[0]["username"]; ?>!</span> What have you been watching lately?</h2>
        <div class="last-seen">
        <?php
            foreach($movies as $movie) {
        ?>
            <div class="movie-thumb">
                <div class="movie-cover">
                    <img src="images/<?php echo $movie["cover"];?>">
                </div>
                <div class="movie-title">
                    <h4><?php echo $movie["title"];?></h4>
                </div>
                <div class="movie-release-date">
                    <p><?php echo $movie["release_year"];?></p>
                </div>
                <div class="movie-director">
                    <p><?php echo $movie["director"];?></p>
                </div>
                <div class="movie-actors">
                    <p><?php echo $movie["actors"];?></p>
                </div>
                <div class="movie-genre">
                    <p><?php echo $movie["genre"];?></p>
                </div>
                <div class="movie-description">
                    <p><?php echo $movie["description"];?></p>
                </div>
                <div class="movie-rating">
                    <p><?php echo $movie["rating"];?></p>
                </div>
            </div>
        <?php
            }
        ?>
        </div>
        <div class="movies-actions">
            <button><a href="controllers/add_movie.php">Add a Movie</a></button>
        </div>
    </section>
    <?php
       } else {
    ?>
    <section class="intro-not-logged">
        <span class="fa fa-clock-o" aria-hidden="true"></span>
        <span class="fa fa-film" aria-hidden="true"></span>
        <h2><span class="red">iWatched</span> enables you to keep a record of the movies you watched</h2>
        <p>Pretty cool right?</p>
        <p class="login-register">Before starting, please <a href="controllers/login.php">login or register!</a></p>
    </section>
    <?php
       }
    ?>
</body>
</html>