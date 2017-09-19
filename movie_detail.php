<?php
    require_once("config.php");
    
    if(isset($_SESSION["user_id"])){
        $user_logged = $_SESSION["user_id"];
        // get user data
        $query = $db->prepare("
                    SELECT user_id, username FROM users WHERE user_id = ?
                ");
        $query->execute(array($user_logged));
        $user = $query->fetchAll( PDO::FETCH_ASSOC );

        // load movie detail
		if(!isset($_GET["movie_id"])) {
			header("Location: index.php");
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
    } else {
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>iWatched - <?php echo $movie[0]["title"];?></title>
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
                        if(div.innerHTML.indexOf(link.textContent) != -1) {
                            break;
                        } else {
                           div.style.display = 'block';
                           div.appendChild(link);
                        }
                    }
                }
            }

            search_bar.onkeyup = function(){
                var timeout = 0,
                    suggestions_search = document.getElementById('suggestions_search');

                clearTimeout(timeout);
                if(this.value.length > 2){
                    timeout = setTimeout(queryDB, 500);
                }

                if(!this.value.length && suggestions_search.hasChildNodes()){
                    suggestions_search.innerHTML = '';
                    suggestions_search.style.display = 'none';
                }
            }
        }
    </script>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1><a href="index.php" class="logo">iWatched</a></h1>
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
                <a href="movies.php">Movies</a>
				<p class="welcome">Welcome back <?php echo $user[0]["username"]; ?>!</p>
                <a href="logout.php">Log out</a>
            </div>
        </nav>
    </header>
    <section class="movie-detail">
       	<h2>Oh so you've watched <span class="red"><?php echo $movie[0]["title"];?></span> already? That's cool</h2>
		<div class="movie-card">
		  <section class="movie-image">
		    <img class="movie-poster" src="images/<?php echo $movie[0]["cover"];?>" alt="<?php echo $movie[0]["title"];?>" />
		  </section>
		  <section class="movie-wrapper">
		    <div class="about-movie">
		      <h3><?php echo $movie[0]["title"];?></h3>
		      <div class="movie-info">
		        <p>
		        	<span class="fa fa-calendar-o" aria-hidden="true"></span>
		        	<?php echo $movie[0]["release_year"];?>
		        </p>
		        <p>
		        	<span class="fa fa-star" aria-hidden="true"></span>
		        	<?php echo $movie[0]["rating"];?>
		        </p>
		        <p>
		        	<span class="fa fa-flask" aria-hidden="true"></span>
		        	<?php echo $movie[0]["genre"];?>
		        </p>
		      </div>
		      <div class="movie-info">
		        <p>
		        	<span class="fa fa-video-camera" aria-hidden="true"></span>
		        	<?php echo $movie[0]["director"];?>
		        </p>
		        <p>
		        	<span class="fa fa-user-o" aria-hidden="true"></span>
		        	<?php echo $movie[0]["actors"];?>
		        </p>
		      </div>
		      <div class="movie-desc">
		        <p><?php echo $movie[0]["description"];?></p>
		      </div>
		    </div>
		  </section>
		  <svg class="wavy" viewBox="0 0 500 500" preserveAspectRatio="xMinYMin meet">
		    <path d="M0,100 C150,200 350,0 500,100 L500,00 L0,0 Z" style="stroke: none;"></path>
		  </svg>
		</div>
	</section>
</body>
</html>