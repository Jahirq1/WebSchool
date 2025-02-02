<?php
include('../../backend/login/db.php');  

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../html/login.php");
    exit();
}

$prind_id = $_SESSION['user_id']; 


if (isset($_GET['professor_id'])) {
    $professor_id = $_GET['professor_id'];  
} else {
    echo "Përgjegjësi nuk u gjet.";
    exit();
}


$sql = "SELECT username FROM users WHERE id = '$professor_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $professor_username = $row['username']; 
} else {
    echo "Përgjegjësi nuk u gjet.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = mysqli_real_escape_string($conn, $_POST['message']); 

    if (!empty($message)) {
        $query = "INSERT INTO mesazhet (sender_id, receiver_id, message) 
                  VALUES ('$prind_id', '$professor_id', '$message')";
        if (mysqli_query($conn, $query)) {
            echo "Mesazhi u dërgua me sukses!";
        } else {
            echo "Ka ndodhur një gabim gjatë dërgimit të mesazhit.";
        }
    }
}
?>

