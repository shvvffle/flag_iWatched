<?php
	require_once("config.php");

	if(isset($_SESSION["user_id"])){
	    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if(isset($_POST["request"]) && $_POST["request"] === "delete") {
		    $delete_record = "DELETE FROM movies WHERE movie_id = ?";        
		    $query = $db->prepare($delete_record);

		    $response = $query->execute(array($_POST["movie_id"]));
		}
    } else {
        header("Location: index.php");
        exit;
    }
?>