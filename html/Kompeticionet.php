<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../img/ubt-logo-img1.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kompeticionet</title>
    <link rel="stylesheet" href="../css/kompeticionet.css">
</head>

<body>

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
        <section class="content">
            <section class="content">
                <div class="right">
                    <?php
                    include 'conn/merr_kompeticionet.php';

                    $selectedId = isset($_POST['kompeticioni']) ? $_POST['kompeticioni'] : 14;  // ID default është 1
                    
                    $sql = "SELECT * FROM kompeticionet WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $selectedId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $competition = $result->fetch_assoc();

                    if ($competition) {
                        $imagePath = "../sektor1/uploads/" . htmlspecialchars($competition['image']);
                        echo "<img src='" . $imagePath . "' alt='Competiton Image'>";
                    }
                    ?>

                </div>
                <div class="left-section">
                    <div class="container">
                        <div class="programet">
                            <h1>Kompeticionet</h1>
                        </div>

                        <label class="dropdown" for="kompeticioni">Zgjedh kompeticionin:</label>
                        <form method="POST" id="competitionForm" action="">
                            <select name="kompeticioni" id="kompeticioni" onchange="this.form.submit()">
                                <option value="" hidden>Zgjedh kompeticioni</option>
                                <?php
                                $sql = "SELECT id, name FROM kompeticionet";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $selected = ($row['id'] == $selectedId) ? 'selected' : '';  
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>asni kompetiicion aktiv</option>";
                                }
                                ?>
                            </select>
                        </form>

                    </div>

                    <br>

                    <div id="competitionDescription">
                        <?php
                        $sql = "SELECT * FROM kompeticionet WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $selectedId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $selectedId = isset($_POST['kompeticioni']) ? $_POST['kompeticioni'] : 14;

                        if ($result->num_rows > 0) {
                            $competition = $result->fetch_assoc();
                            echo "<h2>" . htmlspecialchars($competition['name']) . "</h2>";
                            echo "<p>" . htmlspecialchars($competition['description']) . "</p>";
                        } else {
                            echo "<p>Skë detaje për kompeticionin e zgjedhur.</p>";
                        }

                        $conn->close();
                        ?>
                        <div class="linkat">
                            <a href="../img/post/kompeticionet.pdf" download="kompeticionet.pdf"
                                class="ka">Rezultatet</a>
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

        <script src="../js/kompeticionet.js"></script>
    </body>

</html>