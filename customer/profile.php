<?php 
    include('../config/helpers.php');
    include_once('../config/classes.php');
    isAuthenticated();
    $userData = unserialize($_COOKIE['user']);
    $response = null;

    if (isset($_COOKIE['response'])) {
        $response = unserialize($_COOKIE['response']);
        print_r($response);
    }

    print_r($userData);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <form action="/slurp/customer/process.php" method="post">
        Old Password <input type="password" name="old_password" /><br />
        New Password <input type="password" name="new_password" /><br />
        Re-Enter Password <input type="password" name="new_password2" /><br />
        <input type="submit" name="change_password" value="Update" /><br />
    </form>
</body>
</html>