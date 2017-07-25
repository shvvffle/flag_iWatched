<?php
    require_once("../models/config.php");

    $query = $db->prepare("
                SELECT user_id, username FROM users
            ");
    $query->execute( array($_GET["username"]) );
    $user = $query->fetchAll( PDO::FETCH_ASSOC );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>iWatched - Add a movie</title>
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
        <section class="add-movie-form">
	    <?php
			if(isset($message)) echo "<p class='red'>" .$message. "</p>";
		?>
    	<h2>Add the latest movie you've watched</h2>
		<form method="post" action="add_movie.php" enctype="multipart/form-data">
			<div class="title">
				<label>
					<span class="fa fa-film" aria-hidden="true"></span>
					<span class="hidden">Movie Title</span>
				</label>
				<input type="text" name="title" placeholder="Movie Title" required>
			</div>
			<div class="release-date">
				<label>
					<span class="fa fa-calendar-o" aria-hidden="true"></span>
					<span class="hidden">Movie Release Year Date</span>
				</label>
				<input type="text" name="release_year" placeholder="Movie Release Year Date" required>
			</div>
			<div class="director">
				<label>
					<span class="fa fa-user" aria-hidden="true"></span>
					<span class="hidden">Movie Director</span>
				</label>
				<input type="text" name="director" placeholder="Movie Director" required>
			</div>
			<div class="actors">
				<label>
					<span class="fa fa-user-o" aria-hidden="true"></span>
					<span class="hidden">Movie Actors</span>
				</label>
				<input type="text" name="actors" placeholder="Movie Actors" required>
			</div>
			<div class="genre">
				<label>
					<span class="fa fa-flask" aria-hidden="true"></span>
					<span class="hidden">Movie Genre</span>
				</label>
				<input type="text" name="genre" placeholder="Movie Genre" required>
			</div>
			<div class="description">
				<label>
					<span class="fa fa-commenting" aria-hidden="true"></span>
					<span class="hidden">Movie Description</span>
				</label>
				<textarea name="description" placeholder="Movie Description" required></textarea>
			</div>
			<div class="rating">
				<label>
					<span class="fa fa-star" aria-hidden="true"></span>
					<span class="hidden">Movie Rating</span>
				</label>
				<select name="rating">
					<option value="" disabled selected>Movie Rating</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</div>
			<!-- photo upload -->
			<div class="cover">
				<label>
					<span class="fa fa-picture-o" aria-hidden="true"></span>
					<span class="hidden">Movie Cover</span>
				</label>
				<input type="file" name="cover" placeholder="Movie Cover">
			</div>
			<div class="submit">
				<input class="add" type="submit" name="submit" value="Add a movie">
			</div>
		</form>
    </section>
</body>
</html>