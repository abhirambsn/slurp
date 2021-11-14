<?php 
    include('../config/helpers.php');
    include('../config/db.php');
    include_once('../config/classes.php');
    isAuthenticated();
    $connection = connect("localhost", "root", "", 3307, "test");
    $userData = unserialize($_COOKIE['user']);
    $reviews = get_user_reviews($connection, $userData->data['customer_id']);

    print_r($reviews);
?>