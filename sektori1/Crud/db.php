<?php
$servername = "localhost:3306";
$username = "root"; 
$password = "";     
$dbname = "news_db"; 


$db = mysqli_connect($servername, $username, $password, $dbname);


if (!$db) {
    die("Lidhja ka dështuar: " . mysqli_connect_error());
}
?>
