<?php
    include_once('./config/classes.php');
    $error = null;
    if (isset($_COOKIE['error'])) {
        $error = unserialize($_COOKIE['error']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error: <?php echo $error->code; ?></title>
    <link rel="stylesheet" href="/slurp/static/css/failure.css">
    <link rel="stylesheet" href="/slurp/static/css/bootstrap-modified.min.css">
    <script src="https://kit.fontawesome.com/8586a77d33.js" crossorigin="anonymous"></script>
</head>
<body>
<img src="/slurp/static/svg/fail_wave.svg" alt="Wave" class="wave">
    <div class="container">
        <div class="img">
            <img src="/slurp/static/svg/error.svg" alt="Hero">
        </div>
        <div class="error-container">
            <div class="data">
                <br>
                <h2>Error Code: <?php echo $error->code; ?></h2>
                <h3><?php echo $error->data; ?></h3>
                <?php if($error->redirectUri): ?>
                    <a href="<?php echo $error->redirectUri; ?>" class="text-light text-center nav-link"><i class="fas fa-arrow-left"></i>&nbsp; Go Back</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>