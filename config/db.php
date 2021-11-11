<?php
    $connection = null;
    function connect($host, $username, $password, $port, $db) {
        try {
            $connection = new PDO("mysql:host=$host;port=$port;dbname=$db", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            setcookie("type", "error", time() + 100, "/");
            setcookie("error", $e->getMessage(), time() + 100, "/");
            return false;
        }
        return $connection;
    }

    function new_customer($connection, $name, $email, $password) {
        try {
            $password = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
            $sql = "INSERT INTO customer(name, email, password) VALUES(:name, :email, :password)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            setcookie("type", "error", time() + 100, "/");
            setcookie("error", $e->getMessage(), time() + 100, "/");
            return false;
        }
    }

    function new_restaurant($connection, $name, $email, $address, $phone_number) {
        try {
            $sql = "INSERT INTO restaurant(restaurant_name, email, address, phone_number) VALUES(:restaurant_name, :email, :address, :phone_number)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':restaurant_name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            setcookie("type", "error", time() + 100, "/");
            setcookie("error", $e->getMessage(), time() + 100, "/");
            return false;
        }
    }

    function new_review($connection, $cid, $rid, $rating, $comment=null) {
        try {
            if ($comment) {
                $sql = "INSERT INTO review(customer_id, restaurant_id, rating, comment) VALUES(:customer_id, :restaurant_id, :rating, :comment)";
            } else {
                $sql = "INSERT INTO review(customer_id, restaurant_id, rating) VALUES(:customer_id, :restaurant_id, :rating)";
            }
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':customer_id', $cid);
            $stmt->bindParam(':restaurant_id', $rid);
            $stmt->bindParam(':rating', $rating);
            if ($comment) {
                $stmt->bindParam(':comment', $comment);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            setcookie("type", "error", time() + 100, "/");
            setcookie("error", $e->getMessage(), time() + 100, "/");
            return false;
        }
    }

    function update_customer($connection, $customer_id, $name=null, $email=null, $password=null) {
        try {
            if ($name == null && $email == null) {
                $sql = "UPDATE customer SET password=':password' WHERE customer_id=$customer_id";
    
            } else if ($name == null) {
                $sql = "UPDATE customer SET email=':email', password=':password' WHERE customer_id=$customer_id";
            } else if ($email == null) {
                $sql = "UPDATE customer SET name=':name', password=':password' WHERE customer_id=$customer_id";
            }
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':password', $password);
    
            if ($name) {
                $stmt->bindParam(':name', $name);
            } else if ($email) {
                $stmt->bindParam(':email', $email);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            setcookie("type", "error", time() + 100, "/");
            setcookie("error", $e->getMessage(), time() + 100, "/");
            return false;
        }
    }

    function login_check($connection, $email, $password) {
        $sql = "SELECT * FROM users WHERE email=':email'";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $password_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$password_data) {
            return [false, ['error' => 'Invalid Email']];
        } else {
            $hash = $password_data['password'];
            if (password_verify($password, $hash)) {
                return [true, ['id' => $password_data['id'], 'name' => $password_data['name'], 'email' => $password_data['email']]];
            } else {
                return [false, ['error' => 'Invalid Password']];
            }
        }
    }

    function disconnect() {
        $connection = null;
        return true;
    }
?>