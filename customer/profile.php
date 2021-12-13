<?php 
    include_once('../config/helpers.php');
    include_once('../config/classes.php');
    require_once('../config/SessionConfig.php');
    isAuthenticated();
    $user = unserialize($_SESSION['user']);
    $response = null;

    if (isset($_COOKIE['response'])) {
        $response = unserialize($_COOKIE['response']);
    }

    $title = "Slurp - Profile";
    include_once('../template/header.php');
?>
    <div class="container my-2">
        <h5 class="display-5 text-center">My Profile</h5>
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
        <div class="profile">
            <table class="table table-hover table-bordered">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><?php echo $user->data['customer_name']; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $user->data['email'] ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo $user->data['address'] ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td><?php echo $user->data['phone_number'] ?></td>
                    </tr>
                    <tr>
                        <th>Actions</th>
                        <td>
                            <button type="button" class="btn btn-primary text-light" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-edit"></i>&nbsp; Change Password</button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/slurp/customer/process.php" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="oldPass" class="form-label">Old Password</label>
                                                    <input type="password" name="old_password" id="oldPass" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="newPass" class="form-label">New Password</label>
                                                    <input type="password" name="new_password" id="newPass" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="newPass2" class="form-label">Confirm New Password</label>
                                                    <input type="password" name="new_password2" id="newPass2" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="change_password" class="btn btn-primary text-light"><i class="fas fa-edit"></i>&nbsp; Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php include_once('../template/footer.php'); ?>