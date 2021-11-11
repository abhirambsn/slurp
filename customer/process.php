<?php
    include('../config/db.php');
    $connection = connect("localhost", "root", "", 3307, "test");
    if(isset($_POST['change_password'])) {
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $updated = update_customer($connection, $_COOKIE['data']['customer_id'], password: $newPassword);
        if ($updated) {
            setcookie("type", "info", time() + 100, "/");
            setcookie("message", "Password Changed Successfully", time() + 100, "/");
            header('Location: /slurp/profile.php');
        }
    }
?>