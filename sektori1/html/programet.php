<?php
include('../Crud/db.php');
include('../Crud/programet.php');


if (isset($_GET['programet']) && !empty($_GET['programet'])) {
    
    $selectedId = $_GET['programet'];

    
    $programet = new programet($db);
    $programet_details = $programet->getProgrametDetails($selectedId);

    if ($programet_details) {
      
        echo "<h3>" . htmlspecialchars($programet_details['name']) . "</h3>";
        echo "<p>" . htmlspecialchars($programet_details['description']) . "</p>";

        
        if ($programet_details['image']) {
            $imagePath = "../uploads/" . htmlspecialchars($programet_details['image']);
            echo "<img src='" . $imagePath . "' alt='Post Image'>";
        }
    } else {
        echo "<p>Detaje për këtë program nuk u gjetën.</p>";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (isset($_POST['name']) && isset($_POST['description'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];

        
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageName = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageDestination = "../uploads/" . basename($imageName);

           
            if (!is_dir("../uploads")) {
                mkdir("../uploads", 0777, true);
            }

           
            if (move_uploaded_file($imageTmpName, $imageDestination)) {
                $imagePath = $imageName; 
            } else {
                $imagePath = NULL; 
            }
        } else {
            $imagePath = NULL;
        }

      
        if (!empty($name) && !empty($description)) {
          
            $programet = new programet($db);
            if ($programet->addProgramet($name, $description, $imagePath)) {
                echo "<script>
                alert('Programi u shtua me sukses!');
                window.location.href = 'programet.php';
            </script>";
               
                exit();
            } else {
                echo "Gabim gjatë shtimit të programit.";
            }
        } else {
            echo "Emri dhe Përshkrimi duhet të plotësohen.";
        }
    }
}


if (isset($_POST['delete']) && isset($_POST['programet_id'])) {
    $programet_id = $_POST['programet_id']; 

    
    $programet = new programet($db);
    if ($programet->deleteProgramet($programet_id)) {
        echo "<script>
        alert('Programi  u fshi me sukses!');
        window.location.href = 'programet.php';
    </script>";
        exit();
    } else {
        echo "Gabim gjatë fshirjes.";
    }
}


session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/programet.css">
    <link rel="shortcut icon" type="x-icon" href="../img/ubt.png">
    <title>Programet</title>
</head>

<body>

    <nav class="navbar">
        <div class="brand-title"><img src="../img/administrator.png" alt=""></div>
        <a href="#" class="toggle-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </a>
        <div class="navbar-links">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="Lajmet.php">Lajmet</a></li>
                <li><a href="programet.php">Programet</a></li>
                <li><a href="Eventet.php">Eventet</a></li>
                <li><a href="Kompeticionet.php">Kompeticionet</a></li>
                <li><a href="?logout=true"><button>Log out</button></a></li>
            </ul>
        </div>
    </nav>

    <hr>

    <main>
        <div class="shtimi">
            <h2>Shtimi i Programeve </h2>
            <form action="programet.php" method="post" enctype="multipart/form-data">
                <label for="name">Emri i programit:</label>
                <input type="text" id="name" name="name" required>

                <label for="description">Përshkrimi:</label>
                <textarea id="description" name="description" rows="4" cols="50"></textarea>

                <label for="image" class="file">Zgjidhni një Imazh:</label>
                <input type="file" id="image" name="image"><br><br>

                <input type="submit" value="Regjistro Programin">
            </form>
        </div>

        <div class="content">
            <div class="right">
                <?php
                if (isset($_POST['programet'])) {
                    $selected_id = $_POST['programet'];  // ID e programit të zgjedhur
                    $programet = new programet($db);
                    $programet_details = $programet->getProgrametDetails($selected_id);

                    if ($programet_details) {
                        $imagePath = "../uploads/" . htmlspecialchars($programet_details['image']);
                        echo "<img src='" . $imagePath . "' alt='Post Image'>";
                    }
                }
                ?>
            </div>

            <div class="left-section">
                <div class="container">
                    <div class="programet">
                        <h1>Programet</h1>
                        <label class="dropdown" for="drejtimin"></label>
                        <form method="POST" id="programiForm">
                            <select name="programet" id="programet" onchange="this.form.submit()">
                                <option value="" hidden>Zgjedh Programin</option>
                                <?php
                                $sql = "SELECT id, name FROM programet";
                                $result = $db->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>Asnjë program aktiv</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>

                <div id="programiDescription">
                    <?php
                    if (isset($_POST['programet'])) {
                        $selectedId = $_POST['programet'];
                        $sql = "SELECT * FROM programet WHERE id = ?";
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param("i", $selectedId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $programet = $result->fetch_assoc();
                            echo "<div>" . $programet['description'] . "</div>";
                            echo "<form action='' method='POST'>
                            <input type='hidden' name='programet_id' value='" . $programet['id'] . "'>
                            <button type='submit' class='delete-btn' name='delete'>Fshi</button>
                        </form>";
                        } else {
                            echo "<p>Ska detaje për programin.</p>";
                        }
                    }
                    ?>
                    <nav class="linkat">
                        <a href="#" class="ka">Broshura-info</a>
                        <a href="#" class="ka">Plan-programi</a>
                    </nav>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <hr color="white">
        <h4>copyrights &#169 all rights reserved from UBT</h4>
    </footer>
</body>

</html>
