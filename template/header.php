<?php 
    if (file_exists('./config/helpers.php')) {
        include_once('./config/helpers.php');
    } else {
        include_once('../config/helpers.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="/static/css/bootstrap-modified.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/8586a77d33.js" crossorigin="anonymous"></script>
</head>
<body>
    <script src="/static/js/bootstrap.bundle.js"></script>
    <script src="/static/js/starRating.js"></script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <?php if(isset($user)) : ?>
                <a class="navbar-brand" href="/dashboard.php">Slurp</a>
            <?php else : ?>
                <a class="navbar-brand" href="/index.php">Slurp</a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-grow-1 justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <?php if(isset($user)): ?>
                            <?php if ($user->data['isAdmin']): ?>
                                <div class=""></div>
                            <?php else: ?>
                                <form class="d-flex flex-fill" action="/restaurant/search.php" method="get">
                                    <div class="input-group mb-12">
                                        <?php if(isset($squery)): ?>
                                            <input class="form-control w-50 me-2" type="search" name="query" placeholder="Search" value="<?php echo $squery; ?>" aria-label="Search">
                                        <?php else: ?>
                                            <input class="form-control w-50 me-2" type="search" name="query" placeholder="Search" aria-label="Search">
                                        <?php endif; ?>
                                        <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i>&nbsp;Search</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <form class="d-flex flex-fill" action="/restaurant/search.php" method="get">
                                <div class="input-group mb-12">
                                    <?php if(isset($squery)): ?>
                                        <input class="form-control w-50 me-2" type="search" name="query" placeholder="Search" value="<?php echo $squery; ?>" aria-label="Search">
                                    <?php else: ?>
                                        <input class="form-control w-50 me-2" type="search" name="query" placeholder="Search" aria-label="Search">
                                    <?php endif; ?>
                                    <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i>&nbsp;Search</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </li>
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if (isset($user)) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $user->data['customer_name']; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php if($user->data['isAdmin']): ?>
                                        <li><a href="/admin/" class="dropdown-item"><i class="fas fa-user-shield"></i>&nbsp;Admin Dashboard</a></li>    
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="/customer/profile.php"><i class="fas fa-user-circle"></i>&nbsp;My Profile</a></li>
                                    <li><a href="/customer/my_reviews.php" class="dropdown-item"><i class="fas fa-list"></i>&nbsp;My Reviews</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/auth/process.php?logout=true"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a></li>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="/auth/login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="/auth/register.php">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>