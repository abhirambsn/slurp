<?php
    include('../config/db.php');
    include_once('../config/classes.php');
    $connection = connect("localhost", "root", "", 3307, "test");
    if(isset($_POST['change_password'])) {
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $user = unserialize($_COOKIE['user']);
        $email = $user->data['email'];
        $updated = update_customer($connection, $email, $oldPassword, password: $newPassword);
        if ($updated) {
            $response = new SuccessResponse(201, "Password updated successfully");
            setcookie("response", serialize($response), time() + 100, "/");
            header('Location: /slurp/customer/profile.php');
        } else {
            header('Location: /slurp/error.php');
        }
    }
?>