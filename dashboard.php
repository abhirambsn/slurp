<?php 
    include('./config/helpers.php');
    include('./config/db.php');
    include_once('./config/classes.php');
    isAuthenticated();
    $connection = connect("localhost", "root", "", 3307, "test");
    $userData = unserialize($_COOKIE['user']);
    $restaurants = get_all_restaurants($connection);
    print_r($userData);
    echo "<br><br>";
    print_r($restaurants);
?>