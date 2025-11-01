<?php
// Define the database connection details
$servername = "localhost";  // the hostname of your local server
$username = "root";         // default username for phpMyAdmin
$password = "";             // default password is empty
$dbname = "book_inventory"; // the name of your database

// Create a new MySQLi object for database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection failed
// ->connect_error is a built-in property that stores connection errors
if ($conn->connect_error) {
  // die() stops the script and outputs an error message
  die("Connection failed: " . $conn->connect_error);
}

// If this part runs, it means connection was successful
?>
