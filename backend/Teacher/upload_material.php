<?php
session_start();
include('../../backend/login/db.php');
include('../../backend/Teacher/File/FileManager.php'); 
include('../../backend/Teacher/File/Subject.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../html/login.php');
    exit();  
}

$fileManager = new FileManager();
$subjectMaterialManager = new SubjectMaterialManager($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file']) && isset($_POST['subject_id']) && isset($_POST['file_title'])) {
    $subjectId = $_POST['subject_id'];
    $fileTitle = $_POST['file_title'];

    if (!$subjectMaterialManager->checkSubjectExists($subjectId)) {
        echo "Lënda me këtë ID nuk ekziston!";
        exit();
    }

    $uploadPath = $fileManager->uploadFile($_FILES['file']);
    if (strpos($uploadPath, 'Gabim') === false) { 
        if ($subjectMaterialManager->saveMaterial($subjectId, $_FILES['file']['name'], $uploadPath, $fileTitle)) {
            header("Location: upload_material.php?subject_id=" . $subjectId);
            exit();
        } else {
            echo "Ndodhi një gabim gjatë ruajtjes së materialit në databazë!";
        }
    } else {
        echo $uploadPath; 
    }
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
    <link rel="shortcut icon" type="x-icon" href="../../Studenti/icon/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Teacher/css/lendet.css">
    <link rel="stylesheet" href="upload.css">
    <title>Lendet_upload_UBT</title>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="../../Teacher/html/dashboard.php">
                        <span class="iconn" >
                            <img src="../../Teacher/icon/ubt.png" alt="">
                        </span>
                        <span class="title">UBT</span>
                    </a>
                </li>
                <li>
                    <a href="../../Teacher/html/dashboard.php">
                        <span class="icon" style="margin-top:15px;">
                         <img src="../../Teacher/icon/home.png" alt="">
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="../../Teacher/html/Smis.php">
                        <span class="icon" style="margin-top:15px;">
                            <img src="../../Teacher/icon/report.png" alt="">
                        </span>
                        <span class="title">Smis</span>
                    </a>
                </li>

                <li>
                    <a href="../../Teacher/html/Lendet.php">
                        <span class="icon" style="margin-top:15px;">
                         <img src="../../Teacher/icon/book.png" alt="">
                        </span>
                        <span class="title">Lendet</span>
                    </a>
                </li>

                <li>
                    <a href="../../Teacher/html/chat.php">
                        <span class="icon" style="margin-top:15px;">
                          <img src="../../Teacher/icon/chat.png" alt="">
                        </span>
                        <span class="title">info</span>
                    </a>
                </li>
                <li>
                <a href="?logout=true">
                        <span class="icon" style="margin-top:15px;">
                            <img src="../../Teacher/icon/log-out.png" alt="">
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
                <img src="../../Teacher/icon/menu.png" alt="">
            </div>

            <div class="search">
                <label>
                    <input type="text" placeholder="Kerko Lenden">
                    <ion-icon name="search-outline"></ion-icon>
                </label>
            </div>
            <div class="user">
                <a href="../../Teacher/html/profile.php">
                <img src="../../Teacher/icon/user.png">
                </a>
            </div>
        </div>
        <!------================================Tabela e lendeve =======================----------->
        <div class="form">
                <h3>Ngarko Materialin</h3>
                <form action="upload_material.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="subject_id" value="<?php echo $_GET['subject_id']; ?>" >
      <div class="tek">
     <label for="file_title">Titulli i Materialit:</label>
        <input type="text" name="file_title" required><br><br>
    </div>
      <label for="file" id="label">Futni materialin tuaj :</label>
    <input type="file" name="file" id="file" required><br><br>

          <input type="submit" value="Ngarko Materialin">
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
                            <td>titulli</td>
                      
                            <td>Materiali</td>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    if (isset($_GET['subject_id'])) {
                        $subject_id = $_GET['subject_id'];
                        $stmt_materials = $conn->prepare("SELECT * FROM subject_materials WHERE subject_id = ?");
                        $stmt_materials->bind_param("i", $subject_id);
                        $stmt_materials->execute();
                        $result_materials = $stmt_materials->get_result();

                        while ($material = $result_materials->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $material['file_title'] . "</td>"; 
                            echo "<td><a href='" . $material['file_path'] . "' target='_blank' class='subject-link'>Shiko Materialin</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                      
                    </tbody>
                </table>
            </div>
    
    </div>

        <script src="../../Teacher/script/dashboard.js"></script>
</body>
</html>