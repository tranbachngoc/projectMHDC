<?php
// $servername = "localhost";
// $username = "azibai_emailapp";
// $password = "emailapp123456!";

$servername = "222.255.46.49";
$username = "azibai_emailapp";
$password = "Baiazi654321!";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>
