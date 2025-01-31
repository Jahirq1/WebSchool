<?php
include('../Crud/db.php');
include('../Crud/kompeticionet.php');

if (isset($_GET['kompeticioni']) && !empty($_GET['kompeticioni'])) {
   
    $selectedId = $_GET['kompeticioni'];

   
    $competition = new kompeticionet($db);
    $competition_details = $competition->getCompetitionDetails($selectedId);

    if ($competition_details) {
        
        echo "<h3>" . htmlspecialchars($competition_details['name']) . "</h3>";
        echo "<p>" . htmlspecialchars($competition_details['description']) . "</p>";

     
        if ($competition_details['image']) {
            $imagePath = "../uploads/" . htmlspecialchars($competition_details['image']);
            echo "<img src='" . $imagePath . "' alt='Post Image'>";
        }
    } else {
        echo "<p>Detaje të tjera për këtë kompeticion nuk u gjetën.</p>";
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
           
            $competition = new kompeticionet($db); 
            if ($competition->addCompetition($name, $description, $imagePath)) {
              
                echo "<script>
        alert('Kompeticioni u shtua me sukses!');
        window.location.href = 'Kompeticionet.php';
        </script>";
                
                exit();
            } else {
                echo "Ka ndodhur një gabim gjatë shtimit të kompeticionit.";
            }
        } else {
            echo "Të dhënat për 'Emri' dhe 'Përshkrimi' duhet të plotësohen.";
        }
    }
}



if (isset($_POST['delete']) && isset($_POST['competicion_id'])) {
    $competicion_id = $_POST['competicion_id']; 

   
    $competition = new kompeticionet($db);
    if ($competition->deleteCompetition($competicion_id)) {
        echo "<script>
        alert('Kompeticioni u fshi me sukses!');
        window.location.href = 'Kompeticionet.php';
    </script>";
       
        exit();
    } else {
        
        echo "Ka ndodhur një gabim gjatë fshirjes.";
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
    <link rel="shortcut icon" type="x-icon" href="../img/ubt.png">
    <link rel="shortcut icon" type="x-icon" href="../img/ubt-logo-img1.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kompeticionet</title>
    <link rel="stylesheet" href="../css/kompeticionet.css">
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
    <div class="shtimi">
        <h2>Forma për Futjen e Kompeticioneve</h2>
        <form action="Kompeticionet.php" method="post" enctype="multipart/form-data">
            <label for="name">Emri i Kompeticionit:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="description">Përshkrimi:</label><br>
            <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

            <label for="image" class="file">Zgjidhni një Imazh:</label>
            <input type="file" id="image" name="image"><br><br>

            <input type="submit" value="Regjistro Kompeticionin">
        </form>
    </div>

    <section class="content">
        <div class="right">
            <?php
            if (isset($_POST['kompeticioni'])) {
                $selected_id = $_POST['kompeticioni'];  // ID e kompeticionit të zgjedhur
                $competition = new kompeticionet($db);
                $competition_details = $competition->getCompetitionDetails($selected_id);

                if ($competition_details) {
                    $imagePath = "../uploads/" . htmlspecialchars($competition_details['image']);
                    echo "<img src='" . $imagePath . "' alt='Post Image'>";
                }
            }
            ?>
        </div>

        <div class="left-section">
            <div class="container">
                <div class="programet">
                    <h1>Kompeticionet</h1>
                </div>

                
                <label class="dropdown" for="kompeticioni">Zgjedh kompeticioni:</label>
                <form method="POST" action="">
                    <select name="kompeticioni" id="kompeticioni" onchange="this.form.submit()">
                        <option value="" hidden>Zgjedh kompeticioni</option>
                        <?php
                      
                        $competition = new kompeticionet($db);
                        $competitions = $competition->getCompetitions();

                        if (count($competitions) > 0) {
                            foreach ($competitions as $comp) {
                                echo "<option value='" . $comp['id'] . "'>" . $comp['name'] . "</option>";
                            }
                        } else {
                            echo "<option value='' disabled>Asnjë kompeticion aktiv</option>";
                        }
                        ?>
                    </select>
                </form>

            </div>

            <br>
            <div id="competitionDescription">
                <?php
                if (isset($_POST['kompeticioni']) && !empty($_POST['kompeticioni'])) {
              
                    $selectedId = $_POST['kompeticioni'];

                  
                    $competition = new kompeticionet($db);
                    $competition_details = $competition->getCompetitionDetails($selectedId);

                    if ($competition_details) {
                       
                        echo "<h3>" . htmlspecialchars($competition_details['name']) . "</h3>";
                        echo "<p>" . htmlspecialchars($competition_details['description']) . "</p>";

                       
                        echo "<form action='' method='POST'>
                      <input type='hidden' name='competicion_id' value='" . $competition_details['id'] . "'>
                      <button type='submit' class='delete-btn' name='delete'>Fshi</button>
                        </form>";
                    } else {
                        echo "<p>Detaje të tjera për këtë kompeticion nuk u gjetën.</p>";
                    }
                }
                ?>

                <div class="linkat">
                    <a href="../img/post/kompeticionet.pdf" download="kompeticionet.pdf" class="ka">Rezultatet</a>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSf7-1sraLcGFvq9-k7tTabXF-TJ-_M5OrzdIddCM89uW-BTlQ/viewform?usp=sf_link"
                        class="sa">Apliko</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <hr color="white">
        <h4>copyrights &#169 all rights reserved from UBT</h4>
    </footer>
</body>

</html>