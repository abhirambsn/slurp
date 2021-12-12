<?php
    include_once('./config/classes.php');
    $resp = null;
    if (isset($_COOKIE['response'])) {
        $resp = unserialize($_COOKIE['response']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="/static/css/success.css">
    <link rel="stylesheet" href="/static/css/bootstrap-modified.min.css">
    <script src="https://kit.fontawesome.com/8586a77d33.js" crossorigin="anonymous"></script>
</head>
<body>
    <img src="/static/svg/success_wave.svg" alt="Wave" class="wave">
    <div class="container">
        <div class="img">
                <img src="/static/svg/success.svg" alt="Hero">
        </div>
        <div class="success-container">
            <div class="data">
                <h2><?php echo $resp->data; ?></h2>
                <?php if($resp->redirectUri): ?>
                    <a href="<?php echo $resp->redirectUri; ?>" class="text-center nav-link text-dark"><i class="fas fa-arrow-right"></i>&nbsp; Continue</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>