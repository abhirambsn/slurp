<?php 
    include('./config/helpers.php');
    include('./config/db.php');
    include_once('./config/classes.php');
    isAuthenticated();
    $connection = connect("localhost", "root", "", 3307, "test");
    $user = unserialize($_COOKIE['user']);
    $restaurants = get_all_restaurants($connection);
    $title = "Dashboard";
    include("./templates/head.php");
?>

<div class="container my-2">
    <h3>All Restaurants</h3><br>
    <?php foreach ($restaurants as $restaurant) :?>
        <div class="card my-2">
            <div class="card-body">
                <h5 class="card-title" style="cursor: pointer" onclick="window.location.href='/slurp/restaurant/restaurants.php?id=<?php echo $restaurant['restaurant_id']; ?>'"><?php echo $restaurant['restaurant_name']; ?></a></h5>
                <p class="card-text">
                    <h6>Address: </h6><?php echo $restaurant['address'] ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include("./templates/bottom.php"); ?>