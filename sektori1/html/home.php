<?php
session_start();
include('../Crud/db.php');  
include('../Crud/home.php');


if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    
    if (News::addNews($db, $_FILES['image'], $title, $content)) {
        echo "<script>
                alert('Lajmi ne slider home është shtuar me sukses!');
                window.location.href = 'home.php';
              </script>";
    } else {
        echo "Ka ndodhur një gabim gjatë shtimit të lajmit ne sliderin e home.";
    }
} 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    if (News::deleteNews($db, $id)) {
        echo "<script>
                alert('Lajmi nga slideri i home u fshi me sukses!');
                window.location.href = 'home.php';
              </script>";
    } else {
        echo "<script>
                alert('Gabim gjatë fshirjes së lajmit nga slideri i home.');
                window.history.back();
              </script>";
    }
}

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
    <link rel="stylesheet" href="../css/home.css">
    <link rel="shortcut icon" type="x-icon" href="../img/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gjimnazi-UBT</title>

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
        <h2>Shto një Lajm të Ri ne slider</h2>
        <form action="home.php" method="POST"  enctype="multipart/form-data">
        
            <label for="title" id="title1">Titulli:</label>
            <input type="text" id="title" name="title" placeholder="Titulli i lajmit..." required>

            <label for="content" id="permbajtja">Përmbajtja:</label>
            <textarea id="content" name="content" placeholder="Shkruani përmbajtjen e lajmit..." required></textarea>
            
            <label for="image1" id="label" class="file">Zgjidhni një Foto:</label>
            <input type="file" id="image1" name="image" required>
            <input type="submit" value="Dërgo">
        </form>

        </div>
    
    <!--- Sektori Lajmet -->
    <section class="lajmet">
        <h1>Lajmet</h1>
        <section class="slideri-1">
            <button class="button next" onclick="leviz(1)">&#10095;</button>
            <button class="button prev" onclick="leviz(-1)">&#10094;</button>

            <div class="slid">
                <?php
                $news = News::getAllNews($db);

                if (empty($news)) {
                    echo "<p>Aktualisht nuk ka lajme për të shfaqur.</p>";
                } else {
                    foreach ($news as $rowSlider) {
                        echo '<div class="post">';
                        $imagePath = "../uploads/" . htmlspecialchars($rowSlider['image_url']);
                        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($rowSlider['title']) . '">';
                        echo '<h3>' . htmlspecialchars($rowSlider['title']) . '</h3>';
                        echo '<p>' . htmlspecialchars($rowSlider['content']) . '</p>';

                       
                        echo '<form action="home.php" method="POST" onsubmit="return confirm(\'A jeni i sigurt që dëshironi të fshini këtë lajm te sliderit home?\');">';
                        echo '<input type="hidden" name="id" value="' . $rowSlider['id'] . '">';
                        echo '<button type="submit" class="delete-btn">Fshi</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </section>
    </section>

    <!-- contact form -->
    <hr>
    <section class="contact">
        <div class="h1">
            <h1>Kontaktet e pranuara</h1>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Emri</th>
                    <th>Email</th>
                    <th>Mesazhi</th>
                    <th>Koha e kontaktit</th>
                </tr>
            </thead>
            <tbody>
                <?php

          
                $sql = "SELECT emri, email, mesazhi, data_regjistrimi FROM contacts ORDER BY data_regjistrimi DESC";
                $result = $db->query($sql);

                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['emri']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['mesazhi']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['data_regjistrimi']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Nuk ka mesazhe të regjistruara.</td></tr>";
                }

              
                $db->close();
                ?>
            </tbody>
        </table>

    </section>

    <!--- footeri-->

    <footer>
        <hr color="white">
        <h4>copyrights &#169 all rights reserved from UBT</h4>
    </footer>

    <!---- javascript  -->
    <script>
        const toggleButton = document.getElementsByClassName('toggle-button')[0]
        const navbarLinks = document.getElementsByClassName('navbar-links')[0]

        toggleButton.addEventListener('click', () => {
            navbarLinks.classList.toggle('active')
        })


        let a = 0;
        let currentIndex = 0;
        const slides = document.querySelectorAll('.slide');
        console.log('.slide');
        const totalSlides = slides.length;

        function nextSlide() {

            currentIndex = (currentIndex + 1) % totalSlides;
            document.querySelector('.slider').style.transform = `translateX(-${currentIndex * 100}%)`;
        }


        setInterval(nextSlide, 5000);

        function leviz(drejtimi) {
            const b = document.querySelector(".slid");
            const c = document.querySelectorAll(".post");
            const totali = c.length;
            a += drejtimi;
            if (a < 0) {
                a = totali - 3;
            }
            else if (a > totali - 3) {
                a = 0;
            }
            b.style.transform = `translateX(-${a * 20.33}%)`;
        }


    </script>
</body>

</html>