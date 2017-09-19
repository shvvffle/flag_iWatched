<?php
	require_once("config.php");
	$movies = array();

	if(isset($_SESSION["user_id"])){
    // load movies
	    $fetch_movie = $db->prepare("
	    	SELECT title, movie_id FROM movies WHERE user_id = ?
	    ");

	    $fetch_movie->execute(array($_SESSION["user_id"]));
	    $movies = $fetch_movie->fetchAll( PDO::FETCH_ASSOC );
    } else {
        header("Location: index.php");
        exit;
    }

	$results = json_encode($movies);
	header("Content-Type: application/json");
	echo $results;
?>
