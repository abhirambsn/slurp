<?php
    include_once('../util/dotenv.php');
    include_once('../config/db.php');
    include_once('../config/classes.php');
    require_once('../config/SessionConfig.php');
    $connection = connect();
    $id = $_GET['id'];
    $restaurant = get_restaurant_data($connection, $id);
    if (!$restaurant) {
        $error = new ErrorResponse(500, "An Error Occured", "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        setcookie("error", serialize($error), time() + 100, "/");
        header('Location: /slurp/error.php');
    }
    $reviews = get_restaurant_reviews($connection, $id);
    if (isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
    }
    $title = "Slurp - ".$restaurant['restaurant_name'];
    $response = null;
    if (isset($_COOKIE['response'])) {
        $response = unserialize($_COOKIE['response']);
    }
    include_once('../template/header.php');
?>
<link rel="stylesheet" href="/slurp/static/css/stars.css">
<div class="container my-2">
    <h3 class="display-4"><?php echo $restaurant['restaurant_name']; ?></h3>
    <?php if($response): ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                <?php echo $response->data; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    <div class="img" style="height: 30%;width: 100%">
        <div id="restaurantImaageCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="https://source.unsplash.com/featured/?food,restaurant/268x180" height="500" width="720" class="d-block w-100" alt="<?php echo $restaurant['restaurant_name'].'1'; ?>">
                </div>
                <div class="carousel-item">
                <img src="https://source.unsplash.com/featured/?food,restaurant/268x181" height="500" width="720" class="d-block w-100" alt="<?php echo $restaurant['restaurant_name'].'2'; ?>">
                </div>
                <div class="carousel-item">
                <img src="https://source.unsplash.com/featured/?food,restaurant/268x182" height="500" width="720" class="d-block w-100" alt="<?php echo $restaurant['restaurant_name'].'3'; ?>">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#restaurantImaageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#restaurantImaageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <h5 class="display-5 my-2">Details</h5>
    <div class="details" style="">
        <table class="table table-hover table-bordered">
            <tbody>
                <tr>
                    <th>#</th>
                    <th colspan="2" class="text-center">Data</th>
                </tr>
                <tr class="table-danger">
                    <th>1</th>
                    <th>Address</th>
                    <td><?php echo $restaurant['address']; ?></td>
                </tr>
                <tr class="table-primary">
                    <th>2</th>
                    <th>Email</th>
                    <td><a href="mailto:<?php echo $restaurant['email']; ?>"><?php echo $restaurant['email']; ?></a></td>
                </tr>
                <tr class="table-success">
                    <th>3</th>
                    <th>Phone Number</th> 
                    <td><a href="tel:+91<?php echo $restaurant['phone_number']; ?>"><?php echo $restaurant['phone_number']; ?></a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <h5 class="display-5 my-2">Reviews</h5>
    <div class="reviews rest-<?php echo $restaurant['restaurant_id']; ?>">
        <h6 style="font-size: calc(1rem + 0.3vw);">Average Rating:</h6>
        <p>
            <div class="stars-outer">
                <div class="stars-inner"></div>
            </div>
            <?php $avg = get_average_rating($connection, $restaurant['restaurant_id'])['average']; echo '<b>'.round($avg, 2).'/5 Stars</b>'; ?>
            <script type="text/javascript">
                let avg = '<?php echo $avg; ?>';
                let rid = '<?php echo $restaurant['restaurant_id']; ?>';
                displayRating(avg, rid);

                const updateRating = () => {
                   document.getElementById('rating-value').innerHTML = "<b>" + document.getElementById('rating-slider').value + " / 5 Stars</b>";
                }
            </script>
        </p>
        <div class="posting">
            <?php if(!isset($_SESSION['user'])): ?>
                <button class="btn btn-primary text-light disabled" type="button"><i class="fas fa-plus"></i>&nbsp;Post New Review</button>
                <p class="text-muted my-2"><a href="/slurp/auth/login.php">Login</a> to post a review :)</p>
            <?php else: ?>
                <button class="btn btn-primary text-light" type="button" data-bs-toggle="modal" data-bs-target="#newReviewModal"><i class="fas fa-plus"></i>&nbsp;Post New Review</button>
                <!-- Modal -->
                <div class="modal fade" id="newReviewModal" tabindex="-1" aria-labelledby="newReviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newReviewModalLabel">New Review</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/slurp/restaurant/process.php" method="post">
                                <div class="modal-body">
                                    <h5>Posting Review for <strong><?php echo $restaurant['restaurant_name']; ?></strong></h5>
                                    <h6>Posting as <strong><?php echo $user->data['customer_name']; ?></strong></h6>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">
                                            <div>
                                                Rating
                                            </div>
                                            <div id="rating-value">0 / 5 stars</div>
                                        </label>
                                        <input type="range" name="rating" class="form-range" onchange="updateRating()" value="0.0" min="0" max="5" step="0.5" id="rating-slider">
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Comment</label>
                                        <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
                                    </div>
                                    <input type="hidden" name="restaurant" value="<?php echo $_GET['id']; ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary text-light" name="new_review"><i class="fas fa-plus"></i>&nbsp; Post Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <ul class="reviews list-group my-2">
            <?php foreach($reviews as $review): ?>
                <li class="list-group-item rest-<?php echo $review['review_id']; ?>">
                    <p class="rating">
                        <h6>Rating:&nbsp;<?php echo round($review['rating']).'/5 Stars'; ?></h6>
                        <div class="stars-outer">
                            <div class="stars-inner"></div>
                        </div>
                        <script>
                            avg = '<?php echo $review['rating']; ?>';
                            rid = '<?php echo $review['review_id']; ?>';
                            displayRating(avg, rid);
                        </script>
                    </p>
                    <p class="author">
                        <b>By:- <?php echo $review['customer_name']; ?></b>
                    </p>
                    <p class="comment">
                        <?php echo $review['comment']; ?>
                    </p>
                </li>
            <?php endforeach;  ?>
        </ul>
    </div>

</div>

<?php include_once('../template/footer.php'); ?>