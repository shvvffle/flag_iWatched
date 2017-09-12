<?php
// primeiro um script php que vai pegar em todos os filmes e vai mete-los num ficheiro txt ou json com os titulos, separados por um break ou virgula
// outro ficheiro vai abrir esse ficheiro e vai descompilar tudo num array basico e dps vai usar um ciclo para ver cada registo do array e comparar cada linha com o enviado por ajax que o user escreveu na search bar

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
