<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'traversy');
define('DB_PASS', 'admin21');
define('DB_NAME', 'traversy_php');

// create db connection with mysqli
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed $conn->connect_error");
}
