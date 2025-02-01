<?php

include('../../backend/login/db.php');  
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../html/login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 


include('../../backend/Student/dashboard/Subject.php');  


$subject = new Subject($conn, $user_id);


$total_subjects = $subject->getTotalSubjects();


$result = $subject->getSubjects();
?>

<?php if (isset($_GET['logout'])) {
  
    session_unset(); 
    session_destroy(); 
    header("Location: ../../html/login.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../icon/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemi-Studneti-UBT</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="iconn">
                            <img src="../icon/ubt.png" alt="">
                        </span>
                        <span class="title">UBT</span>
                    </a>
                </li>
                <li>
                    <a href="dashboardS.php">
                        <span class="icon">
                         <img src="../icon/home.png" alt="">
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="Smis.php">
                        <span class="icon">
                            <img src="../icon/report.png" alt="">
                        </span>
                        <span class="title">Smis</span>
                    </a>
                </li>

                <li>
                    <a href="Lendet.php">
                        <span class="icon">
                         <img src="../icon/book.png" alt="">
                        </span>
                        <span class="title">Lendet</span>
                    </a>
                </li>

             
                <li>
                    <a href="?logout=true">
                        <span class="icon">
                            <img src="../icon/log-out.png" alt="">
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>

            </ul>
        </div>
       <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <img src="../icon/menu.png" >
                </div>

                
                <div class="user">
                    <a href="profile.php">
                    <img src="../icon/user.png">
                    </a>
                </div>
               
            </div>
           
            <div class="cardBox">
                <div class="card cardi">
                    <div>
                        <div class="cardName">Mire se erdhe ne UBT</div>
                        <img src="../icon/smile.png" alt="">
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

           

                <div class="card">
                    <div>
                        <div class="cardName">Lendet e Regjistruara</div>
                        <div class="numbers"><?php echo $total_subjects; ?></div> <!-- Numri i lëndëve të kompletuara -->
                        </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>
            </div>
           <div class="Vizitat">
                <div class="Aktive">
                    <div class="Top">
                        <h2>Lendet e regjistruara se fundi</h2>
                        <a href="#" class="btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Lenda</td>
                                <td>profa</td>
                                <td>Date</td>

                            </tr>
                        </thead>

                        <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['professor_name']); ?></td>
                                    <td><?php echo date("d-m-Y H:i:s", strtotime($row['registration_date'])); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                 
    </div>


   <script src="../script/dashboard.js"></script>
</body>
</html>