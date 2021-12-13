<?php
    /**
     * CAUTION: This file contains the BACKEND of this WEBSITE. MODIFY ONLY IF YOU KNOW WHAT YOU ARE DOING
     */
    include_once('../util/dotenv.php');
    include_once('../config/db.php');
    include_once('../config/classes.php');
    require_once('../config/SessionConfig.php');
    $connection = connect();
    $user = unserialize($_SESSION['user']);
    if(isset($_POST['new_review'])) {
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];
        $cid = $user->data['customer_id'];
        $rid = $_POST['restaurant'];

        $post_review = new_review($connection, $cid, $rid, $rating, $comment);
        if ($post_review) {
            $response = new SuccessResponse(201, "Review Posted successfully", 'info');
            setcookie("response", serialize($response), time() + 10, "/");
            header("Location: /slurp/restaurant/restaurants.php?id=$rid");
            return;
        } else {
            header('Location: /slurp/error.php');
            return;
        }
    } else if (isset($_POST['add_restaurant'])) {
        $isAdmin = (unserialize($_SESSION['user']))->data['isAdmin'];
        if (!$isAdmin) {
            $error = new ErrorResponse(401, "Unauthorized");
            setcookie("error", serialize($error), time() + 100, "/");
            header('Location: /slurp/error.php');
            return;
        } else {
            $name = $_POST['name'];
            $email =  $_POST['email'];
            $address = $_POST['address'];
            $phoneNumber = $_POST['phone_number'];
            $newRest = new_restaurant($connection, $name, $email, $address, $phoneNumber);
            if ($newRest) {
                $response = new SuccessResponse(201, "Restaurant Registered");
                setcookie("response", serialize($response), time() + 10, "/");
                header('Location: /slurp/admin/');
                return;
            } else {
                header('Location: /slurp/error.php'); 
                return;
            }
        }
    } else if (isset($_POST['edit_restaurant'])) {
        $isAdmin = (unserialize($_SESSION['user']))->data['isAdmin'];
        if (!$isAdmin) {
            $error = new ErrorResponse(401, "Unauthorized");
            setcookie("error", serialize($error), time() + 100, "/");
            header('Location: /slurp/error.php');
            return;
        } else {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $phoneNumber = $_POST['phone_number'];
            $rid = $_POST['rid'];
            $updated = update_restaurant($connection, $rid, $name, $email, $address, $phoneNumber);
            if ($updated) {
                $response = new SuccessResponse(201, "Restaurant Updation Success");
                setcookie("response", serialize($response), time() + 10, "/");
                header('Location: /slurp/admin/');
                return;
            } else {
                header('Location: /slurp/error.php'); 
                return;
            }
        }
    } else if (isset($_GET['type']) && $_GET['type'] == "delete") {
        if (isset($_GET['id'])) {
            $rid = $_GET['id'];
            $isAdmin = (unserialize($_SESSION['user']))->data['isAdmin'];
            if (!$isAdmin) {
                $error = new ErrorResponse(401, "Unauthorized");
                setcookie("error", serialize($error), time() + 100, "/");
                header('Location: /slurp/error.php');
                return;
            } else {
                $delete = delete_restaurant($connection, $rid);
                if ($delete) {
                    $response = new SuccessResponse(201, "Restaurant Deleted");
                    setcookie("response", serialize($response), time() + 10, "/");
                    header('Location: /slurp/admin/');
                    return;
                } else {
                    header('Location: /slurp/error.php'); 
                    return;
                }
            }
        }
    }
?>