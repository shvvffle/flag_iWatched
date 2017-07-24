<?php
    require_once("../models/config.php");

    $query = $db->prepare("
                SELECT user_id, username FROM users
            ");
    $query->execute( array($_POST["username"]) );
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
                <h1><a href="index.php" class="logo">iWatched</a></h1>
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
</body>
</html>