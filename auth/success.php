<?php
    include_once('../config/classes.php');
    $resp = null;
    if (isset($_COOKIE['response'])) {
        $resp = unserialize($_COOKIE['response']);
    }

    print_r($resp);
?>