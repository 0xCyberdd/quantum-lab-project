<?php
$host = "localhost";  // Database host
$user = "root";       // Database username (default in XAMPP)
$pass = "";           // Database password (leave empty for XAMPP)
$dbname = "quantum_db"; // Database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
