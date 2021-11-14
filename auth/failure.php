<?php
    include_once('../config/classes.php');
    $error = null;
    if (isset($_COOKIE['error'])) {
        $error = unserialize($_COOKIE['error']);
    }

    print_r($error);
?>