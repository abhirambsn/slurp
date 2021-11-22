<?php
    include_once('../util/dotenv.php');
    include_once('../config/db.php');
    if (isset($_COOKIE['user'])) {
        $user = unserialize($_COOKIE['user']);
    }

    if (isset($_GET['query'])) {
        $connection = connect();
        $query = $_GET['query'];
        $filter = null;
        $order = 'asc';
        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
            if (str_contains($filter, "desc")) {
                $order = "desc";
            }
            $filter = explode(" ", $filter, 2)[0];
        }
        $restaurants = search($connection, $query, $filter, $order);
    } else {
        if (isset($_COOKIE['user'])) {
            header('Location: /slurp/dashboard.php');
        } else {
            header('Location: /slurp/index.php');
        }
    }

    $title = "Slurp - Search";
    $svalue = $query;

    include_once('../template/header.php');
?>
    <link rel="stylesheet" href="/slurp/static/css/stars.css">
    <div class="container my-2">
        <h6 class="display-6">Search Results for: <?php echo isset($_POST['query']) ? $query : ''; ?> </h6>
        <div class="sortby my-2">
            <h6>Sort By:</h6>
            <form action="<?php $uri = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];echo $uri ?>" method="get">
                <div class="row">
                    <select class="col form-select" id="filter" name="filter" aria-label="Select Filter">
                        <option selected>Choose a Filter</option>
                        <option value="rating desc">Rating (High to Low)</option>
                        <option value="rating">Rating (Low to High)</option>
                        <option value="restaurant_name">Alphabetical [A-Z]</option>
                        <option value="restaurant_name desc">Alphabetical Descending [Z-A]</option>
                    </select>
                    <button type="button" onclick='window.location.href="<?php echo $uri; ?>&filter="+document.getElementById("filter").value;' class="col mx-2 btn btn-success"><i class="fas fa-filter"></i>&nbsp; Apply Filter</button>
                </div>
            </form>
        </div>
        <div class="row my-2">
            <?php if (!$restaurants): ?>
                <h6 class="my-2 text-muted">No Results Found</h6>
            <?php else: ?>
                <?php foreach ($restaurants as $restaurant): ?>
                    <?php $avg = get_average_rating($connection, $restaurant['restaurant_id']); ?>
                    <div class="col-md-4">
                        <div class="card rest-<?php echo $restaurant['restaurant_id'] ?>" style="width: 18rem;">
                            <img class="card-img-top" src="https://source.unsplash.com/featured/?food,restaurant/268x180" width="268" height="180" alt="<?php echo $restaurant['restaurant_name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $restaurant['restaurant_name']; ?></h5>
                                <p class="card-text">
                                    <?php echo $restaurant['address']; ?>
                                    <p>Rating:&nbsp;<b><?php echo round($avg[0], 2); ?> / 5 Stars</b></p>
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <script>
                                        rating = '<?php echo $avg[0]; ?>';
                                        rid = '<?php echo $restaurant['restaurant_id']; ?>';
                                        displayRating(rating, rid);
                                    </script>
                                </p>
                                <button class="btn btn-primary text-light" onclick="window.location.href='/slurp/restaurant/restaurants.php?id=<?php echo $restaurant['restaurant_id']; ?>'"><i class="fas fa-info"></i>&nbsp;More Details</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php include_once('../template/footer.php'); ?>