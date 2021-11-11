<?php
    $error = null;
    if (isset($_COOKIE['error'])) {
        $error = unserialize($_COOKIE['error']);
    }
?>