<?php
    require_once("../models/config.php");

    if(isset($_SESSION["user_id"])) {
		header("Location: cart.php");
		exit;
	}

	$query = $db->prepare("
		SELECT country_id, name
		FROM countries
	");
	$query->execute();
	$countries = $query->fetchAll( PDO::FETCH_ASSOC );

	if(isset($_POST["submit"])) {
		foreach($_POST as $key => $value) {
			$_POST[$key] = strip_tags(trim($value));
		}

		if(
			!empty($_POST["name"]) &&
			!empty($_POST["address"]) &&
			!empty($_POST["city"]) &&
			!empty($_POST["postal_code"]) &&
			!empty($_POST["password"]) &&
			filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) &&
			$_POST["password"] === $_POST["rep_password"]
		) {

			/* confirmar se o utilizador já existe */
			$query = $db->prepare("SELECT email FROM users WHERE email = ?");
			$query->execute( array($_POST["email"]) );
			$result = $query->fetchAll( PDO::FETCH_ASSOC );

			if(empty($result)) {
				/* se não existir, fazer o INSERT na BD */

				$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

				$query = $db->prepare("
					INSERT INTO users
					(name, email, password, address, city, postal_code, country_id)
					VALUES(?, ?, ?, ?, ?, ?, ?)
				");
				$query->execute(
					array(
						$_POST["name"],
						$_POST["email"],
						$password,
						$_POST["address"],
						$_POST["city"],
						$_POST["postal_code"],
						$_POST["country_id"]
					)
				);

				$message = "Conta criada com sucesso";
				header("Location: login.php");
			}
			else {
				$message = "Utilizador já existente";
			}
		}
		else {
			$message = "Preencha todos os campos correctamente";
		}
	}
?>