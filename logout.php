<?php
    session_start();

    require_once('config/mysql.php');

    if(isset($_COOKIE['session'])) {
        session_destroy();
        setcookie("session", $code, time() + 1, "/");
        $conn->query("DELETE FROM sessions WHERE user = '".$row['id']."'");
        header("Location: /video3/login.php");
    }
?>