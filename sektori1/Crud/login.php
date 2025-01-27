<?php       
session_start();
include('db.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

  
    $stmt = $db->prepare("SELECT * FROM `admin` WHERE username = ?");
    $stmt->bind_param("s", $input_username); 
    $stmt->execute();


    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

   
    if ($user && $user['password'] == $input_password) {
      
        $_SESSION['id'] = $user['id'];
        header("Location: ../html/home.php");
        exit;
    } else {
      
        header("Location: ../html/login.php"); 
        exit;
    }
} else {
   
    $_SESSION['message'] = "Username or password is incorrect.";
    header("Location: ../html/login.php");
    exit;
}
?>
