<?php

    define ('DB_USER', 'USERNAME');
    define ('DB_PASS', 'PASSWORD');
    define ('DB_HOST', 'HOST');
    define ('DB_NAME', 'NAME');
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
