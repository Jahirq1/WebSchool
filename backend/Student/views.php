<?php
session_start();
include('../login/db.php');


class SubjectMaterials
{
    private $conn;
    private $user_id;

    public function __construct($conn)
    {
        $this->conn = $conn;
       
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../html/login.php");
            exit();
        }
        $this->user_id = $_SESSION['user_id']; 
    }

  
    public function logout()
    {
        session_unset();  
        session_destroy(); 
        header("Location: ../../html/login.php"); 
        exit();
    }

   
    public function getMaterials($subject_id)
    {
        $sql = "SELECT file_title, file_name, file_path FROM subject_materials WHERE subject_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}

$subjectMaterials = new SubjectMaterials($conn);


if (isset($_GET['logout'])) {
    $subjectMaterials->logout();
}


$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : 0;


$result = $subjectMaterials->getMaterials($subject_id);
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../../Studenti/icon/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="upload.css">
    <link rel="stylesheet" href="../Teacher/upload.css">
    <title>Lendet_UBT</title>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="../../Studenti/html/dashboard.php">
                        <span class="iconn">
                            <img src="../../Studenti/icon/ubt.png" alt="">
                        </span>

                        <span class="title">UBT</span>
                    </a>
                </li>
                <li>
                    <a href="../../Studenti/html/dashboard.php">
                        <span class="icon" style="margin-top:15px;">
                         <img src="../../Studenti/icon/home.png" alt="">
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="../../Studenti/html/Smis.php">
                        <span class="icon" style="margin-top:15px;">
                            <img src="../../Studenti/icon/report.png" alt="">
                        </span>
                        <span class="title">Smis</span>
                    </a>
                </li>

                <li>
                    <a href="../../Studenti/html/Lendet.php">
                        <span class="icon" style="margin-top:15px;">
                         <img src="../../Studenti/icon/book.png" alt="">
                        </span>
                        <span class="title">Lendet</span>
                    </a>
                </li>
                <li>
                <a href="?logout=true">
                <span class="icon" style="margin-top:15px;">
                            <img src="../../Studenti/icon/log-out.png" alt="">
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>

            </ul>
        </div>
    
     <div class="main">
        <div class="topbar">
            <div class="toggle">
                <img src="../../Studenti/icon/menu.png" alt="">
            </div>

          
            <div class="user">
                <a href="profile.php">
                <img src="../../Studenti/icon/user.png">
                </a>
            </div>
        </div>
       
       
        <div class="Vizitat" style="margin-top:15px;">
      

            <div class="Aktive">
                <div class="Top">
                    <h2>Materiali i lendes mundsuar nga UBT</h2>
                </div>

                <table >
                    <thead  >
                        <tr>
                            <td>Titulli materialit</td>
                            <td>Materiali</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                           
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['file_title'] . "</td>";
                                 
                                    echo "<td><a href='" . $row['file_path'] . "' target='_blank' class='subject-link'>Kliko ketu : File</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>Nuk ka materiale të ngarkuara për këtë lëndë.</td></tr>";
                            }
                        ?>
                        </tbody>
                </table>
            </div>
    
    </div>

        <script src="../script/dashboard.js"></script>
</body>
</html>