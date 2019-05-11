<?php
$servername = "localhost";
$username = "abbottbf";
$password = "900653518";
$dbname = "3430-f18-t6";

// Create connection
$mysqli_conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli_conn->connect_error) {
    die("Connection failed: " . $mysqli_conn->connect_error);
}
// Close connection
mysqli_close($link);