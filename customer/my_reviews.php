<?php 
    include('../config/helpers.php');
    include_once('../config/classes.php');
    isAuthenticated();
    $userData = unserialize($_COOKIE['user']);
    $reviews = get_user_reviews($userData->data['customer_id']);

    echo $reviews;
?>