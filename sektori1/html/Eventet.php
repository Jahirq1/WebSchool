<?php
include('../Crud/db.php');
include('../Crud/Eventet.php');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_event') {
    $event = new Event($db);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $event->setDetails($image, $title, $content);
        if ($event->addEvent()) {
            echo "<script>alert('Ngjarja është shtuar me sukses!'); window.location.href = '../html/Eventet.php';</script>";
        } else {
            echo "<script>alert('Gabim gjatë shtimit të ngjarjes.'); window.history.back();</script>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $event = new Event($db);
    $id = $_POST['id'];
    if ($event->deleteEvent($id)) {
        echo "<script>alert('Eventi u fshi me sukses!'); window.location.href='../html/Eventet.php';</script>";
    } else {
        echo "<script>alert('Gabim gjatë fshirjes së eventit.'); window.history.back();</script>";
    }
}



if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$event = new Event($db);
$events = $event->getEvents();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../img/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventet</title>
    <link rel="stylesheet" href="../css/Eventet.css">
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
    <main>

    <hr>
    <div class="shtimi">
            <h2>Shto një Event të Ri</h2>
            <form action="Eventet.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_event">
               
               
                <label for="title">Titulli:</label>
                <input type="text" id="title" name="title" placeholder="Titulli i Eventit..." required>
                <label for="content">Përmbajtja:</label>
                <textarea id="content" name="content" placeholder="Shkruani përmbajtjen e Eventit..." required></textarea>
               
                <label for="image" class="file">Zgjidhni një Foto:</label>
                <input type="file" id="image" name="image" required>
                <input type="submit" value="Shto Eventin:">
            </form>
            </div>
        
        


        <hr>
        <div class="span">
            <span class="p-titulli">Eventet</span>
            <input type="search" id="search" placeholder="search">
        </div>
        <section class="Eventet">
            <?php
            if ($events->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($events)) {
                    echo '<div class="post">';
                    echo '<div class="photo">';
                    $imagePath = '../uploads/' . htmlspecialchars($row['image']);
                    echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['title']) . '">';
                    echo '</div>';
                    echo '<div class="tekst">';
                    echo '<div class="titulli"><h3>' . htmlspecialchars($row['title']) . '<hr class="hr"></h3></div>';
                    echo '<div class="paragrafi"><p>' . htmlspecialchars($row['content']) . '</p></div>';
                    echo '<div class="data"><p><strong>Data e eventit:</strong> ' . htmlspecialchars($row['date']) . '</p></div>';
                    echo '</div>';
                    echo '<form action="Eventet.php" method="POST" onsubmit="return confirm(\'A jeni i sigurt që dëshironi të fshini këtë event?\');">';
                    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    echo '<button type="submit" class="delete-btn">Fshi</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo "<p>Nuk ka evente për momentin.</p>";
            }
            mysqli_close($db);
            ?>
        </section>
    </main>
    <footer>
        <hr>
        <h4>copyrights &#169 all rights reserved from UBT</h4>
    </footer>
    <script>
        const toggleButton = document.getElementsByClassName('toggle-button')[0]
        const navbarLinks = document.getElementsByClassName('navbar-links')[0]
        toggleButton.addEventListener('click', () => {
            navbarLinks.classList.toggle('active')
        })
    </script>
    <script src="../js/Eventet.js"></script>
</body>
</html>

