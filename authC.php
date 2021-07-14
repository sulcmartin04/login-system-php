<?php
    session_start();

    require_once('config/mysql.php');

    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    $registration_active = true;
    $login_active = true;

    if($_POST['function'] == 'register') {
        if($registration_active) {
            $username = $conn->real_escape_string($_POST['username']);
            $email = $conn->real_escape_string($_POST['email']);
            $password = $conn->real_escape_string($_POST['password']);
            $password2 = $conn->real_escape_string($_POST['password2']);

            if(!empty($username) AND !empty($email) AND !empty($password)) {
                $check_username = $conn->query("SELECT * FROM users WHERE username = '$username'");
                $check_email = $conn->query("SELECT * FROM users WHERE email = '$email'");

                if($check_username->num_rows == 0) {
                    if($check_email->num_rows == 0) {
                        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            if($password == $password2) {
                                $db_sql = "INSERT INTO users (username, password, email, created) VALUES ('$username', '".hash("SHA256", $password)."', '$email', NOW())";

                                $conn->query($db_sql);
    
                                echo json_encode(array("msg" => "Sikeres regisztráció!", "success" => 1));
                            } else {
                                echo json_encode(array("msg" => "A két jelszó nem egyezik meg!"));
                            }
                        } else {
                            echo json_encode(array("msg" => "Hibás e-mail formátum!"));
                        }
                    } else {
                        echo json_encode(array("msg" => "Ez az e-mail cím foglalt!"));
                    }
                } else {
                    echo json_encode(array("msg" => "Ez a felhasználónév foglalt!"));
                }
            } else {
                echo json_encode(array("msg" => "Minden mező kitöltése kötelező!"));
            }
        } else {
            echo json_encode(array("msg" => "A regisztráció ki van kapcsolva!"));
        }
    }

    if($_POST['function'] == 'login') {
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);

        if(!empty($username) AND !empty($password)) {
            $query = $conn->query("SELECT * FROM users WHERE username = '$username' AND password = '".hash("SHA256", $password)."'");
            $row = $query -> fetch_assoc();

            if($query -> num_rows > 0) {
                $code = generateRandomString(rand(5, 10));

                $query = $conn->query("INSERT INTO sessions (code, created, user)
                    VALUES ('$code', NOW(), '".$row['id']."');");

                setcookie("session", $code, time() + (86400 * 14), "/");

                echo json_encode(array("success" => 1));
            } else {
                echo json_encode(array("msg" => "Hibás felhasználónév vagy jelszó!"));
            }
        } else {
            echo json_encode(array("msg" => "Minden mező kitöltése kötelező!"));
        }
    }
?>