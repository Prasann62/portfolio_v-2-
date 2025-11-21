<?php
$servername = "localhost";
$username ="u913997673_prasanna";   // change if needed
$password = "Ko%a/2klkcooj]@o";       // change if needed
$dbname = "u913997673_prasanna";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
