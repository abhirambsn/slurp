<?php
function isAuthenticated() {
    if (isset($_COOKIE['user'])) {
        return true;
    } else {
        header('Location: /slurp/auth/login.php');
        return false;
    }
}

function isAdmin() {
    isAuthenticated();
    $user = unserialize($_COOKIE['user']);
    if (!$user->data['isAdmin']) {
        header('Location: /slurp/auth/login.php');
    }
    return $user->data['isAdmin'];
}
?>