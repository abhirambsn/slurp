<?php
    use DotEnv\DotEnv;
    $path = dirname(dirname(__FILE__)) . '/.env';
    (new DotEnv($path))->load();
    include('classes.php');
    $connection = null;
    function connect() {
        try {
            $host = $_ENV["DB_HOST"];
            $password = $_ENV["DB_PASSWORD"];
            $username = $_ENV["DB_USER"];
            $port = (int) $_ENV["DB_PORT"];
            $db = $_ENV["DB_NAME"];
            $connection = new PDO("mysql:host=$host;port=$port;dbname=$db", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
        return $connection;
    }

    function new_customer($connection, $name, $email, $address, $phone_number, $password, $isAdmin = false) {
        try {
            $password = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
            $sql = "INSERT INTO customer(customer_id, customer_name, address, email, phone_number, isAdmin) VALUES(:custId, :name, :address, :email, :phone_number, :isAdmin)";
            $stmt = $connection->prepare($sql);
            $cid = uniqid($more_entropy = true);
            $stmt->bindParam(':custId', $cid);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->bindParam(':isAdmin', $isAdmin);
            $stmt->execute();
            $sql = "SELECT customer_id FROM customer WHERE email=:email";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch();
            $id = $result['customer_id'];
            $sql = "INSERT INTO users(user_id, email, password, customer_id) VALUES (:userId, :email, :password, :customer_id)";
            $stmt = $connection->prepare($sql);
            $uid = uniqid($more_entropy=true);
            $stmt->bindParam(':userId', $uid);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':customer_id', $id);  
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function get_all_restaurants($connection) {
        try {
            $sql = "SELECT * FROM restaurant";
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function update_restaurant($connection, $rid, $name, $email, $address, $phoneNumber) {
        try {
            $sql = "UPDATE restaurant SET restaurant_name=:name, email=:email, address=:address, phone_number=:phone_number WHERE restaurant_id=:rid";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":phone_number", $phoneNumber);
            $stmt->bindParam(":rid", $rid);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function delete_restaurant($connection, $rid) {
        try {
            $sql = "DELETE FROM restaurant WHERE restaurant_id=:rid";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":rid", $rid);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function new_restaurant($connection, $name, $email, $address, $phone_number) {
        try {
            $sql = "INSERT INTO restaurant(restaurant_id, restaurant_name, email, address, phone_number) VALUES(:restId, :restaurant_name, :email, :address, :phone_number)";
            $rid = uniqid($more_entropy = true);
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':restId', $rid);
            $stmt->bindParam(':restaurant_name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function get_average_rating($connection, $restaurant_id) {
        try {
            $sql = "SELECT AVG(rating) AS average FROM review WHERE restaurant_id=:rid";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':rid', $restaurant_id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function search($connection, $query, $filter=null, $order="asc") {
        try {
            $sql = "SELECT restaurant.*, AVG(rating) as avg_rating from restaurant, review WHERE restaurant.restaurant_id = review.restaurant_id AND restaurant_name LIKE :name GROUP BY restaurant.restaurant_id";
            if ($filter) {
                if (str_contains($filter, "rating")) {
                    $sql .= " ORDER BY avg_rating ".$order;
                } else {
                    $sql .= " ORDER BY $filter ".$order;
                }
            }
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':name', '%'.$query.'%');
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function new_review($connection, $cid, $rid, $rating, $comment=null) {
        try {
            if ($comment) {
                $sql = "INSERT INTO review(review_id, customer_id, restaurant_id, rating, comment) VALUES(:revId, :customer_id, :restaurant_id, :rating, :comment)";
            } else {
                $sql = "INSERT INTO review(review_id, customer_id, restaurant_id, rating) VALUES(:revId, :customer_id, :restaurant_id, :rating)";
            }
            $rating = (float)$rating;
            $revId = uniqid($more_entropy = true);
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':revId', $revId);
            $stmt->bindParam(':customer_id', $cid);
            $stmt->bindParam(':restaurant_id', $rid);
            $stmt->bindParam(':rating', $rating);
            if ($comment) {
                $stmt->bindParam(':comment', $comment);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function update_customer($connection, $email, $oldPassword, $password) {
        try {
            $sql = "SELECT password FROM users WHERE email=:email";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch();
            $result = $result['password'];
            if (password_verify($oldPassword, $result)) {
                $password = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
                $sql = "UPDATE users SET password=:password WHERE email=:email";
                $stmt = $connection->prepare($sql);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                return true;
            } else {
                $error = new ErrorResponse(401, "Old Password mismatch");
                setcookie("error", serialize($error), time() + 100, "/");
                return false;
            }
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function get_restaurant_data($connection, $id) {
        try {
            $sql = "SELECT * FROM restaurant WHERE restaurant_id=:id";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $restaurant = $stmt->fetch();
            return $restaurant;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function get_user_reviews($connection, $cid) {
        try {
            $sql = "SELECT review_id, restaurant_name, rating, comment FROM review, restaurant WHERE review.restaurant_id = restaurant.restaurant_id AND customer_id=:cid";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":cid", $cid);
            $stmt->execute();
            $user_reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $user_reviews;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function get_restaurant_reviews($connection, $rid) {
        try {
            $sql = "SELECT review_id, restaurant_name, rating, comment, customer_name FROM review, restaurant, customer WHERE review.restaurant_id = restaurant.restaurant_id AND review.customer_id = customer.customer_id AND review.restaurant_id=:rid";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":rid", $rid);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reviews;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function login_check($connection, $email, $password) {
        $sql = "SELECT * FROM users WHERE email=:email";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $password_data = $stmt->fetch();
        if (!$password_data) {
            return [false, ['error' => 'Invalid Email']];
        } else {
            $hash = $password_data['password'];
            if (password_verify($password, $hash)) {
                $custId = $password_data['customer_id'];
                $sql = "SELECT * FROM customer where customer_id=:cust_id";
                $stmt = $connection->prepare($sql);
                $stmt->bindParam(':cust_id', $custId);
                $stmt->execute();
                $profile = $stmt->fetch();
                $stmt = null;
                return [true, $profile];
            } else {
                return [false, ['error' => 'Invalid Password']];
            }
        }
    }

    function get_admin_stats($connection) {
        try {
            $stats = array();
            $sql1 = "SELECT COUNT(*) as cnt FROM customer";
            $sql2 = "SELECT COUNT(*) as cnt FROM restaurant";
            $sql3 = "SELECT COUNT(*) as cnt FROM review";
            $stmt = $connection->prepare($sql1);
            $stmt->execute();
            array_push($stats, $stmt->fetch()['cnt']);
            $stmt = $connection->prepare($sql2);
            $stmt->execute();
            array_push($stats, $stmt->fetch()['cnt']);
            $stmt = $connection->prepare($sql3);
            $stmt->execute();
            array_push($stats, $stmt->fetch()['cnt']);
            return $stats;
        } catch (PDOException $e) {
            $error = new ErrorResponse(500, $e->getMessage());
            setcookie("error", serialize($error), time() + 100, "/");
            return false;
        }
    }

    function disconnect() {
        $connection = null;
        return true;
    }
?>