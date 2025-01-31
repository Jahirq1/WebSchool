<?php
session_start();
include('../../backend/login/db.php');
include('../../backend/Student/Lendet/Student.php'); 


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../html/login.php");
    exit();
}

$student_id = $_SESSION['user_id']; 

$student = new Student($conn, $student_id);


$student_id = $student->checkAndRegisterStudent();

$items_per_page = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;


$active_subjects = $student->getActiveSubjects($items_per_page, $offset);


$registered_subjects = $student->getRegisteredSubjects();
if (isset($_POST['register_subject'])) {
    $subject_id = $_POST['subject_id'];
    $password = $_POST['password'];



    if ($student->checkPassword($subject_id, $password)) {
        $student->registerSubject($subject_id);
        echo "<script>alert('Jeni regjistruar me sukses!');</script>";
    } else {
        echo "<script>alert('Fjalëkalimi është i gabuar!');</script>";
    }
}

if (isset($_GET['logout'])) {
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
    <title>Sistemi-UBT</title>
    <link rel="stylesheet" href="../css/Lendet.css">
    <link rel="stylesheet" href="../css/style.css">
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
                    <a href="?logout=true">
                        <span class="icon" style="margin-top:15px;">
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
                    <img src="../icon/menu.png">
                </div>

                <div class="user">
                    <a href="profile.php">
                        <img src="../icon/user.png">
                    </a>
                </div>

            </div>
            <div class="Vizitat" style="margin-bottom:10%;">
                <div class="Aktive">
                    <div class="Top">
                        <h2>Lendet e Aktive</h2>
                        <a href="../../backend/Student/subjects.php" class="btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Emri Lendes</td>
                                <td>Arsimtari</td>
                                <td>Password</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($active_subjects->num_rows > 0) {
                                while ($row = $active_subjects->fetch_assoc()) {
                                    $subject_id = $row['id'];

                                  
                                    $is_registered = $student->checkSubjectExists($subject_id);
                                    if (!$is_registered) {
                                        echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['professor'] . "</td>";
                                        echo "<td>";
                                        echo "<form method='POST' action='Lendet.php'>";
                                        echo "<input type='hidden' name='subject_id' value='" . $subject_id . "'>";
                                        echo "<label for='password'>Fut Passwordin:</label>";
                                        echo "<input type='password' name='password' required>";
                                        echo "<button type='submit'name='register_subject' >Regjistrohu</button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    } else {
                                        echo "<tr>";
                                        echo "<td>" . $row['name'] . " (Regjistruar)</td>";
                                        echo "<td>" . $row['professor'] . "</td>";
                                        echo "<td> - </td>";
                                        echo "</tr>";
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='3'>Nuk ka lëndë të regjistruara.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


                 <div class="Lendet">


                    <table >
                        <thead>
                            <td>Lendet e regjistruara</td>
                            <td>Arsimtari</td>
                            <td>linku</td>
                        </thead>
                        <tbody>
                            <?php
                          
                            if ($registered_subjects->num_rows > 0) {
                                while ($row = $registered_subjects->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['professor'] . "</td>";
                                    echo "<td><a href='../../backend/Student/views.php?subject_id=" . $row['id'] . "' class='subject-link'>Shiko Materialin</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<p>Nuk ka lëndë të regjistruara.</p>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





    </script>
    <script src="../script/dashboard.js"></script>
</body>

</html>