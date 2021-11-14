<?php
    /**
     * CAUTION: This file contains the BACKEND of this WEBSITE. MODIFY ONLY IF YOU KNOW WHAT YOU ARE DOING
     */
    include('../config/db.php');
    include_once('../config/classes.php');
    if (isset($_POST['type'])) {
        $connection = connect("localhost", "root", "", 3307, "test");
        if ($_POST['type'] == 'register') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $password = $_POST['password'];
            $address = $_POST['address'];
            $insert = new_customer($connection, $name, $email, $address, $phone_number, $password);
            if ($insert) {
                $response = new SuccessResponse(201, "Registration Successful");
                setcookie("response", serialize($response), time() + 100, "/");
                header('Location: /slurp/auth/success.php'); 
            } else {
                header('Location: /slurp/auth/failure.php');
            }
        } else if ($_POST['type'] == 'login') {
            $email =  $_POST['email'];
            $password = $_POST['password'];
            $check_login = login_check($connection, $email, $password);
            if ($check_login[0]) {
                $userResp = new UserCookie();
                $userResp->set_login_status(true);
                $userResp->set_data($check_login[1]);
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
            setcookie("user", null, time() - 1, "/");
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