<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="/slurp/auth/process.php" method="post">
        Email: <input type="email" name="email" required /><br />
        Password: <input type="password" name="password" required /><br />
        <input type="submit" name="login" value="Login" /><br />
        <input type="hidden" name="type" value="login" />
    </form>
</body>
</html>