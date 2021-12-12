<?php
    /**
     * CAUTION: This file contains the BACKEND of this WEBSITE. MODIFY ONLY IF YOU KNOW WHAT YOU ARE DOING
     */
    include_once('../util/dotenv.php');
    include_once('../config/db.php');
    include_once('../config/classes.php');
    $connection = connect();
    if(isset($_POST['change_password'])) {
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $newPassword2 = $_POST['new_password2'];
        if (!($newPassword == $newPassword2)) {
            $error = new ErrorResponse(500, "Passwords Don't Match", "http://".$_SERVER['HTTP_HOST']."/customer/profile.php");
            setcookie("error", serialize($error), time() + 100, "/");
            header('Location: /error.php');
            return;
        }
        $user = unserialize($_COOKIE['user']);
        $email = $user->data['email'];
        $updated = update_customer($connection, $email, $oldPassword, password: $newPassword);
        if ($updated) {
            $response = new SuccessResponse(201, "Password updated successfully");
            setcookie("response", serialize($response), time() + 10, "/");
            header('Location: /customer/profile.php');
            return;
        } else {
            $error = new ErrorResponse(500, "Password update failed");
            setcookie("error", serialize($error), time() + 100, "/");
            header('Location: /error.php');
            return;
        }
    }
?>