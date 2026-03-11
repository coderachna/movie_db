<?php
$connection = mysqli_connect("127.0.0.1:3307", "root", "", "moviedb");

if (!$connection) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
