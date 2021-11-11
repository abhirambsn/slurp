<?php
function isAuthenticated() {
    if (isset($_COOKIE['user'])) {
        return true;
    } else {
        header('Location: /slurp/auth/login.php');
        return false;
    }
}
?>