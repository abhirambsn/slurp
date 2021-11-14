<?php
    include_once('../config/helpers.php');
    include_once('../config/classes.php');

    isAuthenticated();
    isAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Restaurant</title>
</head>
<body>
    <form action="/slurp/restaurant/process.php" method="post">
        Restaurant Name: <input type="text" name="name" /><br />
        Restaurant Email: <input type="email" name="email" /><br />
        Address:<br/>
        <textarea name="address" id="address" cols="30" rows="10"></textarea><br/>
        Phone Number: <input type="text" name="phone_number" id="phone_number" /><br />
        <input type="submit" value="Add Restaurant" name="add_restaurant" /><br/>
    </form>
</body>
</html>