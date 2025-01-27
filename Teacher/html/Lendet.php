<?php
session_start();
include('../../backend/login/db.php'); 

require_once('../../backend/Teacher/Lendet.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../html/login.php');
    exit();
}

$subjectManager = new SubjectManager($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_name = $_POST['namee'];
    $password = $_POST['passwordd'];
    $professor_id = $_SESSION['user_id'];

    $message = $subjectManager->createSubject($subject_name, $password, $professor_id);
    $_SESSION['message'] = $message;


}

$subjects = $subjectManager->getSubjects($_SESSION['user_id']);
?>

<?php
if (isset($_GET['logout'])) {
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
    <link rel="stylesheet" href="../css/lendet.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Lendet_UBT</title>
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
                        <input type="text" placeholder="Kerko Lenden">
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
            <div class="form">
                <h3>Regjistro Lenden</h3>
                <form action="Lendet.php" method="POST">
                    <label for="subject_name">Emri i Lëndës:</label>
                    <input type="text" id="name" name="namee" required><br><br>

                    <label for="password">Fjalëkalimi:</label>
                    <input type="password" id="password" name="passwordd" required><br><br>

                    <input type="submit" value="Krijo Lëndën">
                </form>
            </div>
            <div class="Vizitat" style="margin-top:15px;">


                <div class="Aktive">
                    <div class="Top">
                        <h2>Vitet ne UBT</h2>
                        <a href="#" class="btn">Edit</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Lenda</td>
                                <td>viti</td>
                                <td>Materiali</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (!empty($subjects)) {
                                foreach ($subjects as $subject) {
                                    $subject_id = $subject['id'];

                                    $sql_materials = "SELECT * FROM subject_materials WHERE subject_id = ?";
                                    $stmt_materials = $conn->prepare($sql_materials);
                                    $stmt_materials->bind_param("i", $subject_id);
                                    $stmt_materials->execute();
                                    $result_materials = $stmt_materials->get_result();

                                    echo "<tr><td><a href='../../backend/Teacher/upload_material.php?subject_id=" . $subject_id . "' class='subject-link'>" . $subject["name"] . "</a></td><td>Aktiv</td><td>";
                                    if ($result_materials->num_rows > 0) {
                                        while ($material = $result_materials->fetch_assoc()) {
                                            echo "<a href='" . $material["file_path"] . "'>Material</a><br>";
                                        }
                                    } else {
                                        echo "Nuk ka materiale";
                                    }
                                    echo "</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Nuk ka lëndë të krijuara.</td></tr>";
                            }
                            ?>
                        </tbody>

                    </table>
                </div>

            </div>

            <script src="../script/dashboard.js"></script>
</body>

</html>