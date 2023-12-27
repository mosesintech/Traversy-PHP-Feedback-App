<?php
// define constants
define('DB_HOST', 'localhost');
define('DB_USER', 'traversy');
define('DB_PASS', 'admin21');
define('DB_NAME', 'traversy_php');

/*
    The following lines were using mysqli to connect with our database.

    // create db connection with mysqli
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection Failed $conn->connect_error");
    }
*/

// Set DSN
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

// Create a PDO Instance
$pdo = new PDO($dsn, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
