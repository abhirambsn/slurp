<?php 
    include('../config/helpers.php');
    isAuthenticated();
    $userData = unserialize($_COOKIE['user']);
?>