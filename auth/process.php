<?php
    include('../config/db.php');
    include_once('../config/classes.php');
    if (isset($_POST['type'])) {
        $connection = connect("localhost", "root", "", 3307, "test");
        if ($_POST['type'] == 'register') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $insert = new_customer($connection, $name, $email, $password);
            if ($insert) {
                $response = new SuccessResponse(201, "Registration Successful");
                setcookie("response", serialize($response), time() + 100, "/");
                header('Location: /slurp/autn/success.php'); 
            } else {
                $response = new ErrorResponse(500, "Error Occurred");
                setcookie("error", serialize($response), time() + 100, "/");
                header('Location: /slurp/auth/failure.php');
            }
        } else if ($_POST['type'] == 'login') {
            $email =  $_POST['email'];
            $password = $_POST['password'];
            $check_login = login_check($connection, $email, $password);
            if ($check_login[0]) {
                $userResp = new UserCookie();
                $userResp->set_login_status(true);
                $userResp->data($check_login[1]);
                setcookie("user", serialize($userResp), time() + 86400, "/");
                header('Location: /slurp/dashboard.php');
            } else {
                $userResp = new ErrorResponse(401, "Incorrect email or password");
                setcookie("error", serialize($userResp), time() + 100, "/");
                header('Location: /slurp/auth/failure.php');
            }
        }
    } else if (isset($_GET['logout'])) {
        if (isset($_COOKIE['user'])) {
            unset($_COOKIE['user']);
            // setcookie("loggedIn", false, time() - 1, "/");
            // setcookie("data", [], time() - 1, "/");
            $response = new SuccessResponse(200, "Logout Successful");
            setcookie("response", serialize($response), time() + 100, "/");
            header('Location: /slurp/index.php');
        }
    } else {
        $error = new ErrorResponse(405, "Message not allowed");
        setcookie("error", serialize($error), time() + 100, "/");
        header('Location: /slurp/error.php');
    }
?>