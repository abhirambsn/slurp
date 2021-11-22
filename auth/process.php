<?php
    /**
     * CAUTION: This file contains the BACKEND of this WEBSITE. MODIFY ONLY IF YOU KNOW WHAT YOU ARE DOING
     */
    include_once('../util/dotenv.php');
    include('../config/db.php');
    include_once('../config/classes.php');
    if (isset($_POST['type'])) {
        $connection = connect();
        if ($_POST['type'] == 'register') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            if (!($password == $password2)) {
                $error = new ErrorResponse(500, "Passwords Don't Match", "http://".$_SERVER['HTTP_HOST']."/slurp/auth/register.php");
                setcookie("error", serialize($error), time() + 100, "/");
                header('Location: /slurp/error.php');
                return;
            }
            $address = $_POST['address'];
            $insert = new_customer($connection, $name, $email, $address, $phone_number, $password);
            if ($insert) {
                $response = new SuccessResponse(201, "Registration Successful", "http://" . $_SERVER['HTTP_HOST'] ."/slurp/auth/login.php");
                setcookie("response", serialize($response), time() + 100, "/");
                header('Location: /slurp/success.php'); 
                return;
            } else {
                $response = new ErrorResponse(500, "Registration Failure");
                setcookie("error", serialize($response), time() + 100, "/");
                header('Location: /slurp/error.php');
                return;
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
                if ($userResp->data['isAdmin']) {
                    header('Location: /slurp/admin/');
                    return;
                }
                header('Location: /slurp/dashboard.php');
                return;
            } else {
                $userResp = new ErrorResponse(401, "Incorrect email or password", "http://" . $_SERVER['HTTP_HOST'] ."/slurp/auth/login.php");
                setcookie("error", serialize($userResp), time() + 100, "/");
                header('Location: /slurp/error.php');
                return;
            }
        }
    } else if (isset($_GET['logout'])) {
        if (isset($_COOKIE['user'])) {
            unset($_COOKIE['user']);
            setcookie("user", null, time() - 1, "/");
            $response = new SuccessResponse(200, "Logout Successful");
            setcookie("response", serialize($response), time() + 10, "/");
            header('Location: /slurp/index.php');
            return;
        }
    } else {
        $error = new ErrorResponse(405, "Message not allowed");
        setcookie("error", serialize($error), time() + 100, "/");
        header('Location: /slurp/error.php');
        return;
    }
?>