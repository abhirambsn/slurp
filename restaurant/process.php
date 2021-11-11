<?php 
    include('../config/db.php');
    include('../config/classes.php');
    $connection = connect("localhost", "root", "", 3307, "test");
    if(isset($_POST['new_review'])) {
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];
        $cid = $_COOKIE['data']['customer_id'];
        $rid = $_POST['restaurant'];

        $post_review = new_review($connection, $cid, $rid, $rating, $comment);
        if ($post_review) {
            $response = new SuccessResponse(201, "Review Posted successfully", 'info');
            setcookie("response", serialize($response), time() + 100, "/");
            header("Location: /slurp/restaurants?id=$rid");
        }
    }
    if (isset($_POST['add_restaurant'])) {
        $isAdmin = (unserialize($_COOKIE['data']))->isAdmin;
        if (!$isAdmin) {
            $error = new ErrorResponse(401, "Unauthorized");
            header('Location: /slurp/error.php');
        } else {
            $name = $_POST['name'];
            $email =  $_POST['email'];
            $address = $_POST['address'];
            $phoneNumber = $_POST['phone_number'];
            $newRest = new_restaurant($connection, $name, $email, $address, $phoneNumber);
            if ($newRest) {
                $respose = new SuccessResponse(201, "Restaurant Registered");
                setcookie("response", serialize($response), time() + 100, "/");
                header('Location: /slurp/dashboard.php');
            }
        }
    }
?>