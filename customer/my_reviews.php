<?php 
    require_once('../config/SessionConfig.php');
    include('../config/helpers.php');
    include_once('../util/dotenv.php');
    include('../config/db.php');
    include_once('../config/classes.php');
    isAuthenticated();
    $connection = connect("localhost", "root", "", 3307, "test");
    $user = unserialize($_SESSION['user']);
    $reviews = get_user_reviews($connection, $user->data['customer_id']);
    $title = "Slurp - My Reviews";
    include('../template/header.php');
?>
    <link rel="stylesheet" href="/slurp/static/css/stars.css">
    <div class="container my-2">
        <h3>My Reviews</h3>
        <table class="table table-hover table-bordered">
            <thead>
                <th>#</th>
                <th>Restaurant Name</th>
                <th>Rating</th>
                <th>Comment</th>
            </thead>
            <tbody>
                <?php $counter=1;foreach($reviews as $review): ?>
                    <tr class="rest-<?php echo $review['review_id']; ?>">
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $review['restaurant_name']; ?></td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <p>Rating: <b><?php echo $review['rating']; ?> / 5 Stars</b></p>
                                </div>
                                <div class="col">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                current_rating = '<?php echo $review['rating']; ?>';
                                current_rid = '<?php echo $review['review_id']; ?>';
                                displayRating(current_rating, current_rid);
                            </script>
                        </td>
                        <td><?php echo $review['comment']; ?></td>
                    </tr>
                    <?php $counter++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php include('../template/footer.php'); ?>