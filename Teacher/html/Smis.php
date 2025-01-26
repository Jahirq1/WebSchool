<?php
session_start();
include('../../backend/login/db.php'); 
require_once('../../backend/Teacher/Smis.php');


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Arsimtar') {
    header("Location: ../../html/login.php");
    exit();
}

$teacher_id = $_SESSION['user_id']; 

$teacher = new Teacher($teacher_id, $conn);


$subjects_result = $teacher->getSubjects();


$no_subjects = ($subjects_result->num_rows == 0);


$students_result = $teacher->getStudents();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['grade'], $_POST['student_id'], $_POST['subject_id'])) {
    $grade = $_POST['grade'];
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $teacher_id = $_SESSION['user_id'];  

    $save_result = $teacher->saveGrade($student_id, $subject_id, $grade);

    if ($save_result) {
        $_SESSION['message'] = "Nota u ruajt me sukses!";
    } else {
        $_SESSION['message'] = "Ka ndodhur një gabim gjatë ruajtjes së notës!";
    }

    header("Location: Smis.php");
    exit();
}

?>


<?php if (isset($_GET['logout'])) {
    session_unset(); 
    session_destroy();
    header("Location: ../../html/login.php"); 
    exit();
}
?>


<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../icon/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Smis.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>SMIS_UBT</title>
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
        <!--============================== pjesa e main========================= -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <img src="../icon/menu.png" alt="">
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Kerko Studentin">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <div class="user">
                    <a href="profile.php">
                        <img src="../icon/user.png">
                    </a>
                </div>
            </div>
            <!------================================Tabela e lendeve =======================----------->

            <div class="Vizitat">
                <div class="Aktive">
                    <div class="Top">
                        <h2>Smis : Studentet</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Emri</td>
                                <td>Lenda</td>
                                <td>Nota</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($no_subjects) {
                                echo "<tr><td colspan='3'>Duhet te krijoni nje lende per te vlersuar nje Student</td></tr>";
                            } else {
                                if ($students_result->num_rows > 0) {
                                    while ($row_student = $students_result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row_student['username'] . "</td>"; 
                                        echo "<td>" . $row_student['subject_name'] . "</td>"; 
                                        echo "<td>
                                            <form action='Smis.php' method='POST'>
                                                <input type='number' name='grade' min='1' max='5' placeholder='nota'>
                                                <input type='hidden' name='student_id' value='" . $row_student['student_id'] . "'>
                                                <input type='hidden' name='subject_id' value='" . $row_student['subject_id'] . "'>
                                                <button type='submit'>Ruaj Notën</button>
                                            </form>
                                          </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>Nuk ka studentë të regjistruar për këtë lëndë.</td></tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <script src="../script/dashboard.js"></script>
</body>

</html>

