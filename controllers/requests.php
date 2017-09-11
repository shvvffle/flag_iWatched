<?php
	require_once("../models/config.php");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if(isset($_POST["request"]) && $_POST["request"] === "delete") {
		var_dump($delete_record);
	    $delete_record = "DELETE FROM movies WHERE movie_id = ?";        
	    $query = $db->prepare($delete_record);

	    $response = $query->execute(array($_POST["movie_id"]));
	}
?>