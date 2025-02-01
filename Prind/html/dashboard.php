<?php
include('../../backend/login/db.php');
session_start();


class SessionManager {
   
    public static function checkSession() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../html/login.php");
            exit();
        }
    }

    
    public static function logout() {
        session_unset();  
        session_destroy(); 
        header("Location: ../../html/login.php"); 
        exit();
    }
}


class StudentManager {
    private $conn;

   
    public function __construct($conn) {
        $this->conn = $conn;
    }


    public function searchStudents($searchTerm) {
        $sql = "SELECT u.username, s.id AS student_id 
                FROM users u
                LEFT JOIN studenti s ON u.id = s.user_id
                WHERE u.username LIKE ? AND u.role = 'Student'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();
        return $stmt->get_result();
    }

    
    public function displayResults($student_id) {
        $sql_grades = "SELECT sn.grade, sub.name AS subject_name, p.username AS professor_name
                       FROM student_notat sn
                       JOIN subjects sub ON sn.subject_id = sub.id
                       JOIN users p ON sub.professor_id = p.id
                       WHERE sn.student_id = ?";

        $stmt_grades = $this->conn->prepare($sql_grades);
        $stmt_grades->bind_param('i', $student_id);
        $stmt_grades->execute();
        return $stmt_grades->get_result();
    }
}


if (isset($_GET['logout'])) {
    SessionManager::logout();
}


SessionManager::checkSession();


$studentManager = new StudentManager($conn);


$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';


$result = $studentManager->searchStudents($searchTerm);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../icon/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemi-UBT</title>
    <link rel="stylesheet" href="../css/dashboard.css">
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

        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <img src="../icon/menu.png" >
                </div>
                <div class="search">
                    <form method="GET" action="dashboard.php">
                        <label>
                            <input type="text" name="search" placeholder="Kerko Studentin tuaj..." required>
                        </label>
                    </form>
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
                        <h2>Tabela e Femijes</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Emri Studentit</td>
                                <td>Nota</td>
                                <td>Lenda</td>
                                <td>Profesori</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($result->num_rows > 0) {
                                while ($student = $result->fetch_assoc()) {
   
                                    $student_id = $student['student_id'];
                                    $grades_result = $studentManager->displayResults($student_id);

                          
                                    if ($grades_result->num_rows > 0) {
                                        while ($grade = $grades_result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $grade['username'] . "</td>
                                                    <td>" . (isset($grade['grade']) ? $grade['grade'] : 'Nuk ka nota') . "</td>
                                                    <td>" . $grade['subject_name'] . "</td>
                                                    <td>" . $grade['professor_name'] . "</td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr>
                                                <td colspan='4'>Studenti nuk është vlerësuar ende për lëndët e tij</td>
                                              </tr>";
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4'>Nuk ekziston studenti me këtë emër.</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../script/dashboard.js"></script>
</body>
</html>
