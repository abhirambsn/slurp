<?php 
    include_once('./config/helpers.php');
    include_once('./util/dotenv.php');
    include_once('./config/db.php');
    include_once('./config/classes.php');
    $connection = connect();
    if (!$connection) {
        header('Location: /error.php');
    }
    $restaurants = get_all_restaurants($connection);
    $title = "Slurp - Home";
    include_once('./template/header.php');
?>
    <link rel="stylesheet" href="/static/css/stars.css">
    <div class="container my-2">
        <div class="row">
            <?php $counter=0;foreach ($restaurants as $restaurant): ?>
                <?php $avg = get_average_rating($connection, $restaurant['restaurant_id']); ?>
                <div class="col-md-4 col-xs-12 col-sm-12 my-1 mx-2">
                    <div class="card rest-<?php echo $restaurant['restaurant_id'] ?>" style="width: 18rem;">
                        <img class="card-img-top" src="https://source.unsplash.com/featured/?food,restaurant/268x18<?php echo $counter; ?>" width="268" height="180" alt="<?php echo $restaurant['restaurant_name']; ?>">
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
                            <button class="btn btn-primary text-light" onclick="window.location.href='/restaurant/restaurants.php?id=<?php echo $restaurant['restaurant_id']; ?>'"><i class="fas fa-info"></i>&nbsp;More Details</button>
                        </div>
                    </div>
                </div>
                <?php $counter++; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php include_once('./template/footer.php'); ?>