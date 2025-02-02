<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="x-icon" href="../img/ubt-logo-img1.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/programet.css">
    <title>Programet</title>

</head>

<body>

    <nav class="navbar">
        <div class="brand-title"><img src="../img/ubt-logo-img1.png" alt=""></div>
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
                <li><a href="login.php"><button>log in</button></a></li>
            </ul>
        </div>
    </nav>
    <hr>
    <main>
        <div class="content">
            <div class="right">
                <?php
                include 'conn/merr_programet.php';

            
                $selectedId = isset($_POST['programi']) ? $_POST['programi'] : 1;

                $sql = "SELECT * FROM Programet WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $selectedId);
                $stmt->execute();
                $result = $stmt->get_result();
                $programi = $result->fetch_assoc();

                if ($programi) {
                   
                    $imagePath = "../sektori1/uploads/" . htmlspecialchars($programi['image']);
                    echo "<img src='" . $imagePath . "' alt='Program Image'>";
                }
                ?>
            </div>


            <div class="left-section">
                <div class="container">
                    <div class="programet">
                        <h1>Programet</h1>
                        <label class="dropdown" for="drejtimin"></label>
                        <form method="POST" id="programiForm">
                            <select name="programi" id="programi" onchange="this.form.submit()">
                                <option value="" hidden>Zgjedh Programin</option>
                                <?php
                                include '../Crud/db.php';
                                $sql = "SELECT id, name FROM programet";
                                $result = $conn->query($sql);
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
                    $selectedId = isset($_POST['programi']) ? $_POST['programi'] : 1;
                    include 'conn/db.php';
                    $sql = "SELECT * FROM programet WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $selectedId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $programi = $result->fetch_assoc();
                        echo "<h2>" . htmlspecialchars($programi['name']) . "</h2>";
                        echo "<p>" . htmlspecialchars($programi['description']) . "</p>";
                    } else {
                        echo "<p>Skë detaje për programin e zgjedhur.</p>";
                    }
                    ?>
                    <nav class="linkat">
                        <a href="a" class="ka">Broshura-infos</a>
                        <a href="#" class="ka">Plan-programi</a>
                    </nav>
                </div>
            </div>




            <footer>
                <hr color="white">
                <h4>copyrights &#169 all rights reserved from UBT</h4>
            </footer>
            <script src="../js/programet.js"></script>
</body>

</html>