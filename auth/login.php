<?php
    require_once('../config/SessionConfig.php');
    if (isset($_SESSION['user'])) {
        header('Location: /slurp/dashboard.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/slurp/static/css/login.css">
    <script src="https://kit.fontawesome.com/8586a77d33.js" crossorigin="anonymous"></script>
</head>
<body>
    <img src="/slurp/static/svg/wave.svg" alt="Wave" class="wave">
    <div class="container">
        <div class="img">
            <img src="/slurp/static/svg/hero.svg" alt="Hero">
        </div>
        <div class="login-container">
            <form action="/slurp/auth/process.php" method="post">
                <img src="/slurp/static/svg/avatar.svg" alt="Avatar" class="avatar">
                <h2>Welcome</h2>
                <h3>Login here</h3>
                <br><br><br>
                <div class="input-group">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="group">
                        <h5>Email</h5>
                        <input type="email" class="form-input" name="email" id="email" required />
                    </div>
                </div>
                <div class="input-group">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="group">
                        <h5>Password</h5>
                        <input type="password" class="form-input" name="password" id="password" required />
                    </div>
                </div>
                <input type="submit" class="btn" name="login" value="Login" />
                <input type="hidden" name="type" value="login" />
            </form> 
        </div>
    </div>
    <script src="/slurp/static/js/input.js"></script>
</body>
</html>