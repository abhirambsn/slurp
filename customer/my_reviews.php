<?php 
    include('../config/helpers.php');
    isAuthenticated();
    $userData = unserialize($_COOKIE['user']);
    $reviews = get_user_reviews($userData->data['customer_id']);
?>