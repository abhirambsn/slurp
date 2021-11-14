<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="/slurp/static/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/8586a77d33.js" crossorigin="anonymous"></script>
</head>
<body>
    <script src="/slurp/static/js/bootstrap.bundle.js"></script>
    <script src="/slurp/static/js/index.js"></script>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <?php if(isset($user)) : ?>
                <a class="navbar-brand" href="/slurp/dashboard.php">Slurp</a>
            <?php else : ?>
                <a class="navbar-brand" href="/slurp/index.php">Slurp</a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-grow-1 justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <form class="d-flex flex-fill" action="/slurp/restaurant/search.php" method="post">
                            <div class="input-group mb-12">
                                <input class="form-control w-50 me-2" type="search" name="squery" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i>&nbsp;Search</button>
                            </div>
                        </form>
                    </li>
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if (isset($user)) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $user->data['customer_name']; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="/slurp/customer/profile.php"><i class="fas fa-user-circle"></i>&nbsp;My Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/slurp/auth/process.php?logout=true"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a></li>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/slurp/auth/login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/slurp/auth/register.php">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>