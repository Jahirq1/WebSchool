<?php 
include('db.php');

if (isset($_POST['offset'])) {
    $offset = intval($_POST['offset']); 
    $limit = 3;

    $sql = "SELECT * FROM eventet ORDER BY id DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);
    
    // Ekzekuto pyetjen
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $output = ''; 
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output .= '<div class="post">';
                $output .= '<div class="photo"><img src="../sektor1/uploads/' . htmlspecialchars($row['image'])  . '"></div>';
                $output .= '<div class="tekst">';
                $output .= '<div class="titulli"><h3>' . htmlspecialchars($row['title']) . '</h3><hr class="hr"></div>';
                $output .= '<div class="paragrafi"><p>' . htmlspecialchars($row['content']) . '</p></div>';
                $output .= '<div class="data"><p><strong>Data e postimit te eventit:</strong> ' . htmlspecialchars($row['date']) . '</p></div>';
                $output .= '</div>';
                $output .=  '</div>'; 
              
            }
            echo $output; 
        } else {
           
            echo 'no_more_events';
        }
    } else {
        echo "Gabim gjatë ekzekutimit të SQL: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>