<?php
include'conn/db.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../img/ubt-logo-img1.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Lajmett.css">
    <title>Lajmet</title>
  
</head>
<body>
    <!--Pjesa e navbarit-->
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
<?php
include('conn/db.php');

$sql = "SELECT * FROM head_news ORDER BY id DESC"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '  <section class="News">';        
        echo '<div class="photo1">';
        
        $imagePath = '../sektor1/uploads/' . htmlspecialchars($row['head_image_url']); 
        
        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['head_title']) . '">';
        echo '</div>'; 
        
        echo'<div class="posti">';
        echo '<h2>' . htmlspecialchars($row['head_title']) . '</h2>'; 
        echo '<p>' . nl2br(htmlspecialchars($row['head_content'])) . '</p>';
        
       
        
        echo'</div>';
        echo '</section>';
        
    }
} else {
    echo "<p>Nuk ka lajme për momentin.</p>";
}

$conn->close();
?>

<!---Pjesa  e sliderit te lajmeve -->
<section class="slider">
    <div class="titulli">
    <h2 class="Headline">Lajmet </h2>
    <hr class="hr1">
    </div>
    <button class="button pre-btn"><img src="../img/post/img prev1.png " alt="Prev"></button>
    <div class="slider-container">
    <?php
   include ( 'conn/db.php');
$sql = "SELECT * FROM post ORDER BY id DESC"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="post-card">';
        
        $imagePath = '../sektor1/uploads/' . htmlspecialchars($row['image_url']);
        
        echo '<img src="' . $imagePath . '" class="product-thumb" alt="' . htmlspecialchars($row['title']) . '">';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['content']) . '</p>';
  
        
        echo '</div>';
    }
} else {
    echo "<p>Nuk ka lajme për momentin.</p>";
}

$conn->close();
?>
    </div>
    <button class="button nxt-btn"><img src="../img/post/imgnext.png" alt="Next"></button>
</section>
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