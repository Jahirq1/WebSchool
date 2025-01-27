<?php
include('../../backend/login/db.php'); 

class ProfessorDashboard {
    private $conn;
    private $professor_id;
    
    public function __construct($conn, $professor_id) {
        $this->conn = $conn;
        $this->professor_id = $professor_id;
    }

    public function getSubjects() {
        $sql = "SELECT subjects.id AS subject_id, subjects.name AS subject_name 
                FROM subjects 
                WHERE subjects.professor_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->professor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getStudents($subject_ids) {
        if (count($subject_ids) > 0) {
            $subject_ids_str = implode(",", $subject_ids);
            $student_query = "
                SELECT users.username AS student_name, 
                       student_subjects.registration_date,
                       subjects.name AS subject_name
                FROM student_subjects
                JOIN studenti ON student_subjects.student_id = studenti.id
                JOIN users ON studenti.user_id = users.id
                JOIN subjects ON student_subjects.subject_id = subjects.id
                WHERE student_subjects.subject_id IN ($subject_ids_str)";
            return $this->conn->query($student_query);
        }
        return null;
    }

    public function getBestSubjects($subject_ids) {
        $best_subjects = [];
        if (count($subject_ids) > 0) {
            $subject_ids_str = implode(",", $subject_ids);
            $subject_count_query = "
                SELECT subjects.name AS subject_name, 
                       COUNT(student_subjects.student_id) AS num_registered
                FROM student_subjects
                JOIN subjects ON student_subjects.subject_id = subjects.id
                WHERE student_subjects.subject_id IN ($subject_ids_str)
                GROUP BY student_subjects.subject_id
                ORDER BY num_registered DESC";
            $subject_count_stmt = $this->conn->query($subject_count_query);
            while ($row = $subject_count_stmt->fetch_assoc()) {
                $best_subjects[] = $row;
            }
        }
        return $best_subjects;
    }

    public function getSubjectCount() {
        $subject_count_query = "
            SELECT COUNT(*) AS subject_count 
            FROM subjects 
            WHERE professor_id = ?";
        $stmt_count = $this->conn->prepare($subject_count_query);
        $stmt_count->bind_param("i", $this->professor_id);
        $stmt_count->execute();
        $count_result = $stmt_count->get_result();
        $subject_count = $count_result->fetch_assoc()['subject_count'];
        return $subject_count > 0 ? $subject_count : 0;
    }

    public function getMonthlyRegistrations($current_month) {
        $monthly_registration_query = "
            SELECT COUNT(*) AS monthly_count
            FROM student_subjects
            WHERE DATE_FORMAT(student_subjects.registration_date, '%Y-%m') = ?";
        $stmt_monthly = $this->conn->prepare($monthly_registration_query);
        $stmt_monthly->bind_param("s", $current_month);
        $stmt_monthly->execute();
        $monthly_result = $stmt_monthly->get_result();
        return $monthly_result->fetch_assoc()['monthly_count'];
    }
}

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../html/login.php");
    exit();
}

$professor_id = $_SESSION['user_id']; 
$dashboard = new ProfessorDashboard($conn, $professor_id);

$subjects = $dashboard->getSubjects();

$subject_ids = array_column($subjects, 'subject_id');
$students_stmt = $dashboard->getStudents($subject_ids);

$best_subjects = $dashboard->getBestSubjects($subject_ids);

$subject_count = $dashboard->getSubjectCount();

if ($subject_count == 0) {
    $subject_count = 0;
}

$current_month = date('Y-m'); 
$monthly_count = $dashboard->getMonthlyRegistrations($current_month);
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
    <!---======================== Pjesa e main ======================================== --->
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
            <!-- pjesa e  poshtme e main--->

            <div class="cardBox" style="    grid-template-columns: repeat(2, 1fr);">
                <div class="card">
                    <div>
                        <div class="cardName">Lendet Aktive</div>
                        <div class="numbers"><?php echo htmlspecialchars($subject_count); ?></div> <!-- Display the subject count -->
                    
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="cardName">Vizitat mujore</div>
                        <div class="numbers"><?php echo htmlspecialchars($monthly_count); ?></div> <!-- Display the monthly count -->
                        </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>
            </div>
            <!--pjesa e vizitavee-->
            <div class="Vizitat">
                <div class="Aktive">
                    <div class="Top">
                        <h2>Vizitoret e Lendeve</h2>
                        <a href="#" class="btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Emri Studentit</td>
                                <td>Data</td>
                                <td>Lenda</td>
                            </tr>
                        </thead>

                        <tbody>
                        <?php 
                if ($students_stmt && $students_stmt->num_rows > 0) {
                    while ($student = $students_stmt->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                            <td><?php echo htmlspecialchars(date("Y-m-d H:i:s", strtotime($student['registration_date']))); ?></td>
                            <td><?php echo htmlspecialchars($student['subject_name']); ?></td>
                        </tr>
                    <?php } 
                } else {
                    echo "<tr><td colspan='3'>Nuk ka studentë të regjistruar për lëndët e krijuara nga ky profesor.</td></tr>";
                }
                ?>
                        </tbody>
                    </table>
                </div>
                 <!-- ================= Lendet ma tmira ================ -->
                 <div class="Lendet">
                    <div class="teksti">
                        <h2>Lendet me te Ndjekura</h2>
                    </div>

                    <table>
                    <thead>
                            <tr>
                                <td>Lenda</td>
                                <td>nr Studentve </td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                if (!empty($best_subjects)) {
                    foreach ($best_subjects as $subject) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                            <td><?php echo htmlspecialchars($subject['num_registered']); ?></td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='2'>Nuk ka lëndë të regjistruara.</td></tr>";
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