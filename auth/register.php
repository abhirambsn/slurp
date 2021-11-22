<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/slurp/static/css/register.css">
    <script src="https://kit.fontawesome.com/8586a77d33.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="img">
            <img src="/slurp/static/svg/hero.svg" alt="Hero">
        </div>
        <div class="register-container">
            <form action="/slurp/auth/process.php" method="post">
                <img src="/slurp/static/svg/avatar.svg" alt="Avatar" class="avatar">
                <h2>Hey There</h2>
                <h3>Register here</h3>
                <div class="input-group">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="group">
                        <h5>Name</h5>
                        <input type="text" class="form-input" name="name" id="name" required />
                    </div>
                </div>
                <div class="input-group">
                    <div class="i">
                        <i class="fas fa-envelope"></i>
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
                <div class="input-group">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="group">
                        <h5>Confirm Password</h5>
                        <input type="password" class="form-input" name="password2" id="password2" required />
                    </div>
                </div>
                <div class="input-group">
                    <div class="i">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <div class="group">
                        <h5>Address</h5>
                        <textarea name="address" class="form-input" rows="10" cols="10"></textarea>
                    </div>
                </div>
                <div class="input-group">
                    <div class="i">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="group">
                        <h5>Phone Number</h5>
                        <input type="text" class="form-input" name="phone_number" id="phone_number" required />
                    </div>
                </div>
                <input type="submit" class="btn" value="Register" /><br />
                <input type="hidden" name="type" value="register" />
            </form>
        </div>
    </div>
    <script src="/slurp/static/js/input.js"></script>
</body>
</html>