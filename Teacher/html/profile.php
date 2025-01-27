<?php
session_start();
include('../../backend/login/db.php'); 
include('../../backend/Profile/User.php');  
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../html/login.php");
    exit();
}


$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $user = new User($conn, $user_id);
    $result = $user->changePassword($new_password, $confirm_password);

    echo "<script type='text/javascript'>alert('$result');</script>";
}
?>



<?php if (isset($_GET['logout'])) {
    session_unset();  
    session_destroy();
    header("Location: ../../html/login.php"); 
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../icon/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile_UBT</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <div class="container">
    <div class="navigation">
            <ul>
                <li>
                    <a href="dashboard.php">
                        <span class="iconn">
                            <img src="../icon/ubt.png" alt="">
                        </span>

                        <span class="title">UBT</span>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php">
                        <span class="icon" style="margin-top:15px;">
                         <img src="../icon/home.png" alt="">
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="Smis.php">
                        <span class="icon" style="margin-top:15px;">
                            <img src="../icon/report.png" alt="">
                        </span>
                        <span class="title">Smis</span>
                    </a>
                </li>

                <li>
                    <a href="Lendet.php">
                        <span class="icon" style="margin-top:15px;">
                         <img src="../icon/book.png" alt="">
                        </span>
                        <span class="title">Lendet</span>
                    </a>
                </li>

                <li>
                    <a href="chat.php">
                        <span class="icon" style="margin-top:15px;">
                          <img src="../icon/chat.png" alt="">
                        </span>
                        <span class="title">info</span>
                    </a>
                </li>
                <li>
                <a href="?logout=true">
                        <span class="icon" style="margin-top:15px;">
                            <img src="../icon/log-out.png" alt="">
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>

            </ul>
        </div>
<!--pjesa  e main--->
<div class="main">
    <div class="topbar">
        <div class="toggle">
            <img src="../icon/menu.png" alt="">
        </div>
    </div>
  </div>
  <section class="profile">
    <form action="" method="POST">
        <div class="foto">
            <img src="../icon/user.png" alt="">
            <br>
            <label for="">Name: <?php echo $_SESSION['username']; ?></label>
        </div>
        <div class="password">
            <label for="">New Password: 
                <input type="password" name="new_password" required>
            </label>
            <br>
            <label for="">Confirm Password: 
                <input type="password" name="confirm_password" required>
            </label>
        </div>
        <br>
        <button type="submit">Confirm</button>
    </form>
</section>



</div>






    




    <script src="../script/dashboard.js"></script>
</body>
</html>