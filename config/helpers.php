<?php
require_once('SessionConfig.php');
function isAuthenticated() {
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        $error = new ErrorResponse(401, "Not Authenticated", "http://".$_SERVER['HTTP_HOST'].'/slurp/auth/login.php');
        setcookie("error", serialize($error), time() + 100, "/");
        header('Location: /slurp/error.php');
        return false;
    }
}

function isAdmin() {
    $user = unserialize($_SESSION['user']);
    if (!$user->data['isAdmin']) {
        $error = new ErrorResponse(401, "Unauthorized Access to Admin Area", "http://".$_SERVER['HTTP_HOST'].'/slurp/auth/login.php');
        setcookie("error", serialize($error), time() + 100, "/");
        header('Location: /slurp/error.php');
        return false;
    }
    return $user->data['isAdmin'];
}
?>