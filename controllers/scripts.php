<?php
	require_once("../models/config.php");

	$user_logged = $_SESSION["user_id"];

    // load movies
    $fetch_movie = $db->prepare("
    	SELECT title, movie_id FROM movies WHERE user_id = $user_logged
    	");

    $fetch_movie->execute();
    $movies = $fetch_movie->fetchAll( PDO::FETCH_ASSOC );
	$results = json_encode($movies);

	echo $results;

	$fp = fopen('results.json', 'w');
	fwrite($fp, $results);
	fclose($fp);
?>
