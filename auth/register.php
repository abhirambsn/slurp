<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="/slurp/auth/process.php" method="post">
        Name <input type="text" name="name" /><br />
        Email <input type="email" name="email" /><br />
        Password <input type="password" name="password" /><br />
        Address <br/>
        <textarea name="address" rows="10" cols="10"></textarea><br />
        Phone Number <input type="text" name="phone_number" /><br />
        <input type="submit" value="Register" /><br />
        <input type="hidden" name="type" value="register" />
    </form>
</body>
</html>