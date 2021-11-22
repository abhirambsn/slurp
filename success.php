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
    <link rel="stylesheet" href="/slurp/static/css/success.css">
</head>
<body>
    <img src="/slurp/static/svg/success_wave.svg" alt="Wave" class="wave">
    <div class="container">
        <div class="img">
                <img src="/slurp/static/svg/success.svg" alt="Hero">
        </div>
        <div class="success-container">
            <div class="data">
                <h2><?php echo $resp->data; ?></h2>
                <?php if($resp->redirectUri): ?>
                    <a href="<?php echo $resp->redirectUri; ?>" style="text-decoration: none" class="text-muted text-center nav-link"><i class="fas fa-arrow-right"></i>&nbsp; Continue</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>