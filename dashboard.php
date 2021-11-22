<?php 
    include_once('./util/dotenv.php');
    include_once('./config/helpers.php');
    include_once('./config/db.php');
    include_once('./config/classes.php');
    isAuthenticated();
    $connection = connect();
    $user = unserialize($_COOKIE['user']);
    $restaurants = get_all_restaurants($connection);

    $title = "Slurp - ".$user->data['customer_name'];
    include('./template/header.php');
?>
    <link rel="stylesheet" href="/slurp/static/css/stars.css">
    <div class="container my-2">
        <div class="row">
            <?php foreach ($restaurants as $restaurant): ?>
                <?php $avg = get_average_rating($connection, $restaurant['restaurant_id']); ?>
                <div class="col-md-4">
                    <div class="card rest-<?php echo $restaurant['restaurant_id'] ?>" style="width: 18rem;">
                        <img class="card-img-top" src="https://source.unsplash.com/featured/?food,restaurant/268x180" height="180" width="268" alt="<?php echo $restaurant['restaurant_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $restaurant['restaurant_name']; ?></h5>
                            <p class="card-text">
                                <?php echo $restaurant['address']; ?>
                                <p>Rating:&nbsp;<b><?php echo round($avg[0], 2); ?> / 5 Stars</b></p>
                                <div class="stars-outer">
                                    <div class="stars-inner"></div>
                                </div>
                                <script>
                                    const rating = '<?php echo $avg[0]; ?>';
                                    const rid = '<?php echo $restaurant['restaurant_id']; ?>';
                                    displayRating(rating, rid);
                                </script>
                            </p>
                            <button class="btn btn-primary text-light" onclick="window.location.href='/slurp/restaurant/restaurants.php?id=<?php echo $restaurant['restaurant_id']; ?>'"><i class="fas fa-info"></i>&nbsp;More Details</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php include('./template/footer.php'); ?>