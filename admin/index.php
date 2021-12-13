<?php 
    include_once('../util/dotenv.php');
    include_once('../config/helpers.php');
    include_once('../config/db.php');
    require_once('../config/SessionConfig.php');

    $user = unserialize($_SESSION['user']);
    $connection = connect();
    $stats = get_admin_stats($connection);
    $response = null;
    if (isset($_COOKIE['response'])) {
        $response = unserialize($_COOKIE['response']);
    }

    $restaurants = get_all_restaurants($connection);
    if (!$stats) {
        header('Location: /slurp/error.php');
        return;
    }
    $title = "Slurp - Admin";
    isAuthenticated();
    isAdmin();

    include('../template/header.php');
?>
    <link rel="stylesheet" href="/slurp/static/css/admin.css">
    <div class="container my-2">
        <h5 class="text-center display-5">Admin Dashboard</h5>
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
        <div class="row">
            <div class="col-md-4 col-xl-4">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Active Users</h6>
                        <h2 class="text-right"><i class="fa fa-user"></i><span>&nbsp; <?php echo $stats[0]; ?></span></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 col-xl-4">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Restaurants in Database</h6>
                        <h2 class="text-right"><i class="fa fa-utensils"></i><span>&nbsp; <?php echo $stats[1]; ?></span></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 col-xl-4">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Number of Reviews</h6>
                        <h2 class="text-right"><i class="fa fa-list"></i><span>&nbsp; <?php echo $stats[2]; ?></span></h2>
                    </div>
                </div>
            </div>
        </div>
        <h6 class="text-center display-6 my-2">Restaurants &amp; Action</h6>
        <div class="row">
            <button class="col btn btn-primary text-light" data-bs-toggle="modal" data-bs-target="#addRestaurant"><i class="fas fa-plus"></i>&nbsp; Add New Restaurant</button>
            
        </div>
        <table class="table table-bordered table-hover my-2">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Phone Number</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1;foreach($restaurants as $restaurant): ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $restaurant['restaurant_name'] ?></td>
                        <td><?php echo $restaurant['email'] ?></td>
                        <td><?php echo $restaurant['address'] ?></td>
                        <td><?php echo $restaurant['phone_number'] ?></td>
                        <td>
                            <div class="row">
                                <button class="col mx-2 btn btn-success"><i class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#editRestaurant-<?php $restaurant['restaurant_id']; ?>"></i>&nbsp; Edit</button>
                                <button class="col mx-2 btn btn-danger text-light" onclick="window.location.href='/slurp/restaurant/process.php?type=delete&id=<?php echo $restaurant['restaurant_id']; ?>'"><i class="fas fa-trash"></i>&nbsp; Delete</button>
                            </div>
                        </td>
                    </tr>
                    <!-- Edit Restaurant Modal -->
                    <div class="modal fade" id="editRestaurant-<?php echo $restaurant['restaurant_id']; ?>" tabindex="-1" aria-labelledby="editRestaurantLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editRestaurantLabel">Edit Restaurant Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/slurp/restaurant/process.php" method="post">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Restaurant Name</label>
                                            <input type="text" name="name" class="form-control" value='<?php echo $restaurant['restaurant_name'] ?>'>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value='<?php echo $restaurant['email'] ?>'>
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea name="address" class="form-control" id="address" rows="3"><?php echo $restaurant['address'] ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Phone Number</label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" value='<?php echo $restaurant['phone_number'] ?>'>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="hidden" name="rid" value='<?php echo $restaurant['restaurant_id']; ?>'>
                                        <button type="submit" name="edit_restaurant" class="btn btn-success"><i class="fas fa-edit"></i>&nbsp; Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php $counter++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
	</div>
    <!-- Add Restaurant Modal -->
    <div class="modal fade" id="addRestaurant" tabindex="-1" aria-labelledby="addRestaurantLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRestaurantLabel">Add a Restaurant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/slurp/restaurant/process.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Restaurant Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" class="form-control" id="address" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_restaurant" class="btn btn-primary text-light"><i class="fas fa-plus"></i>&nbsp; Add Restaurant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include('../template/footer.php'); ?>