<?php
$host = "localhost";
$username = "root";
$password = ""; 
$database = "sambajon_db"; 

// Create connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
