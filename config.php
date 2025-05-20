<?php

define('DB_HOST',     'localhost');    // usually 'localhost'
define('DB_USER',     'root');         // your MySQL user
define('DB_PASSWORD', '');             // your MySQL password (often empty on XAMPP)
define('DB_NAME',     'login_system');
$conn = new mysqli("localhost", "root", "", "login_system");
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$islogin = true;
$_SESSION['posted'] = false;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
