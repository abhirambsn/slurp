<?php
    include('../config/db.php');
    $connection = connect("localhost", "root", "", 3307, "test");
    $id = $_GET['id'];
    $restaurant = get_restaurant_data($connection, $id);
    $reviews = get_restaurant_reviews($connection, $id);
    print_r($restaurant);
    echo '<br><br>';
    print_r($reviews);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants</title>
</head>
<body>
    <?php
        
    ?>
</body>
</html>