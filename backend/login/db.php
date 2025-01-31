<?php

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "sistemi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Lidhja me databazën ka dështuar: " . $conn->connect_error);
}

return $conn;  
?>

