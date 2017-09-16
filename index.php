<?php
    require_once("config.php");

    if(isset($_SESSION["user_id"])){
        $user_logged = $_SESSION["user_id"];
        // get user data
        $query = $db->prepare("
                    SELECT user_id, username FROM users WHERE user_id = ?
                ");
        $query->execute( array($_SESSION["user_id"]) );
        $user = $query->fetchAll( PDO::FETCH_ASSOC );

        // load movies
        $fetch_movie = $db->prepare("
                SELECT * FROM movies WHERE user_id = $user_logged ORDER BY movie_id LIMIT 4
            ");

        $fetch_movie->execute();
        $movies = $fetch_movie->fetchAll( PDO::FETCH_ASSOC );
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>iWatched</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <script type="text/javascript">
        window.onload = function(){
            function queryDB(){
                var xhttp = new XMLHttpRequest(),
                    response;

                xhttp.open("GET", "search.php", true);

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        response = JSON.parse(xhttp.responseText);
                        compareResults(response);
                    }
                };
                xhttp.send();
            }

            function compareResults(response){
                var search_bar = document.getElementById('search_bar'),
                    div = document.getElementById('suggestions_search'),
                    search_bar_value = search_bar.value,
                    movies_db = response,
                    movie_title,
                    movie_id,
                    link = document.createElement('a');

                for(var i = 0; i < movies_db.length; i++){

                    if(movies_db[i].title.toLowerCase().indexOf(search_bar_value.toLowerCase()) != -1){
                        link.textContent = movies_db[i].title;
                        link.href = 'movie_detail.php?movie_id=' + movies_db[i].movie_id;
                        div.style.display = 'block';
                        div.appendChild(link);
                    }
                }
            }

            search_bar.onkeyup = function(){
                var timeout = 0;
                clearTimeout(timeout);
                if(this.value.length > 2){
                    timeout = setTimeout(queryDB, 500);
                }
            }
        }
    </script>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1><a href="#" class="logo">iWatched</a></h1>
            </div>
            <div class="search-bar">
                <div class="search-container">
                  <div class="search-icon-btn">
                    <i class="fa fa-search"></i>
                  </div>
                  <div class="search-input">
                    <input type="search" id="search_bar" class="search-bar" placeholder="Search for a movie...">
                  </div>
                </div>
                <div id="suggestions_search"></div>
            </div>
            <div class="menu">
                <?php
                    if(isset($user_logged)){
                ?>
                    <a href="movies.php">Movies</a>
                <?php
                    }
                ?>
                <?php
                    if(isset($user_logged)){
                        echo "<p class='welcome'>Welcome back " .$user[0]["username"]. "!</p>";
                    } else {
                        echo "<a href='login.php'>Login</a>";

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
                <div class="hover-movie-detail">
                    <div class="hover-movie-detail-content">
                        <a href="movie_detail.php?movie_id=<?php echo $movie["movie_id"];?>">
                            <span class="fa fa-search-plus" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <div class="movie-cover">
                    <img src="images/<?php echo $movie["cover"];?>">
                </div>
                <div class="first-detail-row">
                    <div class="movie-title">
                        <span class="fa fa-film" aria-hidden="true"></span>
                        <h4 class="truncate"><?php echo $movie["title"];?></h4>
                    </div>
                    <div class="movie-release-date">
                        <span class="fa fa-calendar-o" aria-hidden="true"></span>
                        <p><?php echo $movie["release_year"];?></p>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        </div>
        <div class="movies-actions">
            <button><a href="add_movie.php">Add a Movie</a></button>
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
        <p class="login-register">Before starting, please <a href="login.php">login or register!</a></p>
    </section>
    <?php
       }
    ?>
</body>
</html>

