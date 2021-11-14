<?php 
    include('../config/helpers.php');
    include_once('../config/classes.php');
    isAuthenticated();
    $userData = unserialize($_COOKIE['user']);

    echo $userData;
?>