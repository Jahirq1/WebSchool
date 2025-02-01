<?php
include('db.php');

$sql = "SELECT id, name, description FROM kompeticionet";
$result = $conn->query($sql);

$competitions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $competitions[] = $row;
    }
} else {
    echo "Nuk ka kompeticione në bazën e të dhënave.";
}

?>