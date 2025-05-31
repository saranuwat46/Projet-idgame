<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_account_store";

// Create Connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// No need to close the connection here
?>