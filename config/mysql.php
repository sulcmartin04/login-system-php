<?php

$host = "127.0.0.1";
$user = "root";
$password = "";
$database = "video";

$conn = new mysqli($host, $user, $password, $database);

if($conn->connect_error) {
    die($conn->connect_error);
}

if(isset($_COOKIE['session'])) {
	$_SESSION['sessid'] = $conn->real_escape_string($_COOKIE['session']);
	
	$sess_query = $conn->query("SELECT * FROM sessions WHERE code = '".$_SESSION['sessid']."'");
	$sess_row = $sess_query->fetch_assoc();
	
	if($sess_query->num_rows != 0) {
		$_SESSION['userid'] = $sess_row['user'];
		
		$query = $conn->query("SELECT * FROM users WHERE id = '".$_SESSION['userid']."'");
		$row = $query->fetch_assoc();
	} else {
		setcookie("session", "", time() + (1000 * 1), "/");
		session_destroy();
		header("Location: /video3/login.php");
	}
}

?>