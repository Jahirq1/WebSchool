<?php
session_start();
include('../../backend/login/db.php');


class Student
{
    private $conn;
    private $student_id;

    public function __construct($conn)
    {
        $this->conn = $conn;
       
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../html/login.php");
            exit();
        }
        $this->student_id = $_SESSION['user_id']; 
    }

   
    public function logout()
    {
        session_unset();  
        session_destroy(); 
        header("Location: ../../html/login.php"); 
        exit();
    }

    
    public function getGrades()
    {
        $sql = "SELECT sn.grade, u.username AS professor_name, sub.name AS subject_name 
                FROM student_notat sn
                JOIN studenti s ON s.id = sn.student_id
                JOIN users u ON u.id = (SELECT professor_id FROM subjects WHERE id = sn.subject_id) 
                JOIN subjects sub ON sub.id = sn.subject_id
                WHERE sn.student_id = ?";  

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->student_id);  
        $stmt->execute();
        return $stmt->get_result();
    }
}


$student = new Student($conn);


if (isset($_GET['logout'])) {
    $student->logout();
}


$result = $student->getGrades();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../../Studenti/icon/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Smis.css">
    <title>SMIS_Studenti_UBT</title>
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
                <img src="../icon/menu.png" alt="">
            </div>

            <div class="search">
                <label>
                    <input type="text" placeholder="Kerko Lenden (Noten)">
                    <ion-icon name="search-outline"></ion-icon>
                </label>
            </div>
            <div class="user">
                <a href="profile.php">
                <img src="../icon/user.png">
                </a>
            </div>
        </div>
       <div class="Vizitat">
            <div class="Aktive">
                <div class="Top">
                    <h2>Smis : Notat</h2>
                </div>

                <table>
                    <thead>
                        <tr>
                            <td>Nota</td>
                            <td>Profesori</td>
                            <td>Lenda</td>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['grade'] . "</td>";  
                                    echo "<td>" . $row['professor_name'] . "</td>"; 
                                    echo "<td>" . $row['subject_name'] . "</td>";  
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Nuk ka nota të regjistruara për këtë student.</td></tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
    </div>

        <script src="../script/dashboard.js"></script>
</body>
</html>