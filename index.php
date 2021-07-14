<?php
    session_start();

    require_once('config/mysql.php');

    if(!isset($_COOKIE['session'])) {
        session_destroy();
        header("Location: /video/login.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Főoldal</title>
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="col-lg-6" id="home-div">
                <a>Sikeresen beléptél, mint: <?=$row['username'];?></a> <br>
                <a>E-mail címed: <?=$row['email'];?></a> <br>
                <a>Regisztráció dátuma: <?=$row['created'];?></a>
            </div>

            <div class="col-lg-6" id="home-div-2">
                <a href="/video3/logout.php">Kijelentkezéshez kattints ide.</a>
            </div>
        </div>
    </body>
</html>