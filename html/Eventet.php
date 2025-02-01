<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" type="x-icon" href="../img/ubt-logo-img1.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventet</title>
    <link rel="stylesheet" href="../css/Eventet.css">
</head>
<body >
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
    <main>
        <hr>
        <div class="span">
        <span class="p-titulli">Eventet</span>
        <input type="search" placeholder="search">
        </div>
        <section class="Eventet">
    <div id="moreEventsContainer"> 
        <?php
        include('conn/db.php');

        $sql = "SELECT * FROM eventet ORDER BY id DESC LIMIT 3";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="post">';
                echo '<div class="photo"><img src="../sektor1/uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '"></div>';
                echo '<div class="tekst">';
                echo '<div class="titulli"><h3>' . htmlspecialchars($row['title']) . '<hr class="hr"></h3></div>';
                echo '<div class="paragrafi"><p>' . htmlspecialchars($row['content']) . '</p></div>';
                echo '<div class="data"><p><strong>Data e eventit:</strong> ' . htmlspecialchars($row['date']) . '</p></div>';
                echo '</div>'; // Klujmi i div-it "tekst"
                echo '</div>';  // Klujmi i div-it "post"
            }
        } else {
            echo "<p>Nuk ka evente për momentin.</p>";
        }

        $conn->close();
        ?>
    </div>

    <button class="Button" id="moreEventsButton">Shiko më shumë</button>
</section>

      
    </main>
   




    <script>
      const toggleButton = document.getElementsByClassName('toggle-button')[0]
    const navbarLinks = document.getElementsByClassName('navbar-links')[0]
    
    toggleButton.addEventListener('click', () => {
      navbarLinks.classList.toggle('active')
    })
  

//==================================Pjesa e buttonit per te shfaqur me shum evente================================================================================
      
    let offset = 3; 

   
    document.getElementById('moreEventsButton').addEventListener('click', function () {
        const button = this;
        button.disabled = true; 
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'conn/load.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
        xhr.onload = function () {
            if (this.status === 200) {
                const response = this.responseText;
                
                if (response === 'no_more_events') {
                    button.style.display = 'none';
                } else {
                    const container = document.getElementById('moreEventsContainer');
                    container.insertAdjacentHTML('beforebegin', response);
                    offset += 3; 
                }
            } else {
                alert('Ka ndodhur një gabim gjatë ngarkimit të eventeve!');
            }
            button.disabled = false; 
        };
    
        xhr.send('offset=' + offset);
    });
    
    
    </script>
    
    <footer >
    <hr>
    <h4>copyrights &#169 all rights reserved from UBT</h4>
    </footer>
  
    <script src="../js/Eventet.js"></script>
</body>
</html>