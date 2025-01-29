<?php

include('../Crud/db.php');
include('../Crud/Lajmet.php');
session_start();


if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
  
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}


$newsManager = new Lajmet($db);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    if ($newsManager->addNews($_FILES['image'], $title, $content)) {
        echo "<script>alert('Lajmi është shtuar me sukses!'); window.location.href = 'Lajmet.php';</script>";
    } else {
        echo "<script>alert('Gabim gjatë shtimit të lajmit.');</script>";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['head_image'])) {
    $headTitle = $_POST['head_title'];
    $headContent = $_POST['head_content'];
    if ($newsManager->addHeadNews($_FILES['head_image'], $headTitle, $headContent)) {
        echo "<script>alert('Lajmi kryesor është shtuar me sukses!'); window.location.href = 'Lajmet.php';</script>";
    } else {
        echo "<script>alert('Gabim gjatë shtimit të lajmit kryesor.');</script>";
    }
}


if (isset($_POST['delete_news'])) {
    $id = $_POST['id'];
    if ($newsManager->deleteNews($id)) {
        echo "<script>alert('Lajmi u fshi me sukses!'); window.location.href = 'Lajmet.php';</script>";
    }
}


if (isset($_POST['delete_head_news'])) {
    $id = $_POST['id'];
    if ($newsManager->deleteHeadNews($id)) {
        echo "<script>alert('Lajmi kryesor u fshi me sukses!'); window.location.href = 'Lajmet.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../img/ubt.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Lajmett.css">
    <title>Lajmet</title>
    
</head>
<body>
    <!--Pjesa e navbarit-->
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
 

<section class="add-head-news-section">
    <h2>Shto Një Lajm Kryesor</h2>
    <form action="Lajmet.php" method="POST" class="add-head-news-form" enctype="multipart/form-data">
        <label for="head-image" class="fotoimg">Zgjidhni një Foto Kryesore:</label>
        <input type="file" id="head-image" name="head_image" required>
        
        <label for="head-title">Titulli Kryesor:</label>
        <input type="text" id="head-title" name="head_title" placeholder="Titulli kryesor i lajmit..." required>
        
        <label for="head-content">Përmbajtja Kryesore:</label>
        <textarea id="head-content" name="head_content" placeholder="Shkruani përmbajtjen kryesore të lajmit..." required></textarea>
        
        <button type="submit">Shto Lajmin Kryesor</button>
    </form>
</section>

<?php

$news = $newsManager->getNews();
$headNews = $newsManager->getHeadNews();

foreach ($headNews as $row) {
    echo "<section class='News'>";
    echo "<h2>" . htmlspecialchars($row['head_title']) . "</h2>";
    echo '<div class="postmain">';
    echo "<div class='photo1'>";
    echo "<img src='../uploads/" . htmlspecialchars($row['head_image_url']) . "'>";
    echo "</div>";
    echo "<p>" . nl2br(htmlspecialchars($row['head_content'])) . "</p>";
    echo "</div>";
    echo "<form action='' method='POST'><input type='hidden' name='id' value='" . $row['id'] . "'><button type='submit'class='delete-btn' name='delete_head_news'>Fshi</button></form>";
    echo "</section>";
}

?>




<!---Pjesa  e formes se shtimit te lajmeve tek slideri -->
<section class="add-news-section">
    <h2>Shto një Lajm të Ri</h2>
    <form action="Lajmet.php" method="POST" class="add-news-form" enctype="multipart/form-data">
    <label for="image" class="fotoimg">Zgjidhni një Foto:</label>
    <input type="file" id="image" name="image" required>
    
    <label for="title">Titulli:</label>
    <input type="text" id="title" name="title" placeholder="Titulli i lajmit..." required>
    
    <label for="content">Përmbajtja:</label>
    <textarea id="content" name="content" placeholder="Shkruani përmbajtjen e lajmit..." required></textarea>
    
    <button type="submit">Shto Lajmin</button>
</form>

</section>
<!---Pjesa  e sliderit te lajmeve -->
<section class="slider">
    <div class="titulli">
    <h2 class="Headline">Lajmet </h2>
    <hr class="hr1">
    </div>
    <button class="button pre-btn"><img src="../img/post/img prev1.png " alt="Prev"></button>
    <div class="slider-container">
    
     
    <?php
  $news = $newsManager->getNews();
  $headNews = $newsManager->getHeadNews();
  foreach ($news as $row) {
      echo "<div class='post-card'>";
      echo "<img src='../uploads/" . htmlspecialchars($row['image_url']) . "' class='product-thumb' alt='" . htmlspecialchars($row['title']) . "'>";
      echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
      echo "<p>" . htmlspecialchars($row['content']) . "</p>";
      echo "<form action='' method='POST'><input type='hidden' name='id' value='" . $row['id'] . "'><button type='submit' class='delete-btn' name='delete_news' >Fshi</button></form>";
      echo "</div>";
  }
?>

    </div>
    </div>
    <button class="button nxt-btn"><img src="../img/post/imgnext.png" alt="Next"></button>
</section>
<!--Pjesa e javascript per toggle bar-->
<script>
  const toggleButton = document.getElementsByClassName('toggle-button')[0]
const navbarLinks = document.getElementsByClassName('navbar-links')[0]

toggleButton.addEventListener('click', () => {
  navbarLinks.classList.toggle('active')
})


</script>
</main>
<hr>
<footer>
  <h4>copyrights &#169 all rights reserved from UBT</h4>
</footer>
<script src="../js/Lajmet.js"></script>
</body>
</html>