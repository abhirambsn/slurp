<?php
    include('../config/db.php');
    $connection = connect("localhost", "root", "", 3307, "test");
    $id = $_GET['id'];
    $restaurant = get_restaurant_data($connection, $id);
?>