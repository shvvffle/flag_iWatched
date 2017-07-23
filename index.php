<?php
    require_once("models/config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>iWatched</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/main.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1><a href="#" class="logo">iWatched</a></h1>
            </div>
            <div class="menu">
                <a href="#">Movies</a>
                <a href="#">Login</a>
            </div>
        </nav>
    </header>
    <!-- if user is logged in, see this -->
    <section class="intro-logged">
        <h2>What have you been watching lately?</h2>
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
            <button><a href="#">Add a Movie</a></button>
        </div>
    </section>

    <!-- if user is NOT logged in, see this -->
    <section class="intro-not-logged">
        <h2><span class="red">iWatched</span> enables you to keep a record of the movies you watched</h2>
        <p>Pretty cool right?</p>
        <p class="login-register">Before starting, please <a href="#">login or register!</a></p>
    </section>
</body>

</html>