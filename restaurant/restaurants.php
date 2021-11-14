<?php
    include('../config/db.php');
    $connection = connect("localhost", "root", "", 3307, "test");
    $id = $_GET['id'];
    $user = unserialize($_COOKIE['user']);
    $restaurant = get_restaurant_data($connection, $id);
    $reviews = get_restaurant_reviews($connection, $id);
    $title = "Restaurant ". $restaurant['restaurant_name'];
    include('../templates/head.php');
?>

<div class="container my-2">
    <h3>Restaurant Data</h3>
    <div class="card my-2">
        <div class="card-body">
            <h5 class="card-title"><?php echo $restaurant['restaurant_name']; ?></h5>
            <h6>Address: </h6><?php echo $restaurant['address'] ?><br/><br/>
            <h6>Email: </h6><a href="mailto:<?php echo $restaurant['email'] ?>"><?php echo $restaurant['email'] ?></a><br/><br/>
            <h6>Phone Number: </h6><a href="tel:<?php echo $restaurant['phone_number']; ?>"><?php echo $restaurant['phone_number'] ?></a><br/><br/>
            <button type="button" class="btn btn-primary" onclick="window.location.href='/slurp/restaurant/post_review.php?restaurant=<?php echo $restaurant['restaurant_id'] ?>'"><i class="fas fa-edit"></i>&nbsp; Post Review</button><br/>
        </div>
    </div>
    <hr>
    <h3>All Reviews</h3>
    <ul class="list-group">
        <?php foreach ($reviews as $review): ?>
            <li class="list-group-item">
                <b><?php echo $review['customer_name']; ?></b><br>
                <i>Rating: <?php echo $review['rating']; ?></i><br>
                <?php echo $review['comment'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include('../templates/bottom.php'); ?>