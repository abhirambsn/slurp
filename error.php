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
    <title>Error - <?php echo $error->code; ?></title>
    <link rel="stylesheet" href="/slurp/static/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/8586a77d33.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="display-1">Oops!</h1>
                <p class="display-3">Error Code: <?php echo $error->code; ?></p>
                <p class="display-4"><?php echo $error->data; ?></p>
            </div>
            <div class="col">
                <img src="/slurp/static/img/error.jpg" alt="error" height="90%" width="90%" />
            </div>
        </div>
    </div>
    <script src="/slurp/static/js/bootstrap.bundle.js"></script>
    <script src="/slurp/static/js/index.js"></script>
</body>
</html>