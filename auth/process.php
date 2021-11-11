<?php
    include('../config/config.php');
    if (isset($_POST['type'])) {
        $connection = connect("localhost", "root", "", 3307, "test");
        if ($_POST['type'] == 'register') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $insert = new_customer($connection, $name, $email, $password);
            if ($insert) {
                setcookie("type", "success", time() + 100, "/");
                setcookie("message", "Registration Successful", time() + 100, "/");
                header('Location: success.php'); 
            } else {
                setcookie("type", "error", time() + 100, "/");
                setcookie("message", "Registration Failed", time() + 100, "/");
                header('Location: failure.php');
            }
        } else if ($_POST['type'] == 'login') {
            $email =  $_POST['email'];
            $password = $_POST['password'];
            $check_login = login_check($connection, $email, $password);
            if ($check_login[0]) {
                setcookie("loggedIn", true, time() + 86400, "/");
                setcookie("data", $check_login[1], time() + 86400, "/");
                header('Location: /slurp/dashboard.php');
            } else {
                setcookie("loggedIn", false, time() + 86400, "/");
                setcookie("type", "error", time() + 100, "/");
                setcookie("message", $check_login[1]['error'], time() + 100, "/");
                header('Location: /slurp/auth/failure.php');
            }
        }
    } else if (isset($_GET['logout'])) {
        if (isset($_COOKIE['loggedIn']) && isset($_COOKIE['data'])) {
            unset($_COOKIE['loggedIn']);
            unset($_COOKIE['data']);
            // setcookie("loggedIn", false, time() - 1, "/");
            // setcookie("data", [], time() - 1, "/");
            header('Location: /slurp/index.php');
        }
    } else {
        setcookie("type", "error", time() + 100, "/");
        setcookie("error", "Method not allowed", time() + 100, "/");
        setcookie("errcode", 405, time() + 100, "/");
        header('Location: /slurp/error.php');
    }
?>