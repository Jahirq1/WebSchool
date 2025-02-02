<?php

class Event {
    private $db;
    private $image;
    private $title;
    private $content;

    
    public function __construct($db) {
        $this->db = $db;
    }

  
    public function setDetails($image, $title, $content) {
        $this->image = $image;
        $this->title = $title;
        $this->content = $content;
    }

  
    public function addEvent() {
       
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
          
            $target_dir = '../uploads/';
            $image_name = basename($_FILES['image']['name']);  
            $target_file = $target_dir . $image_name;
    
         
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    
            if (!in_array($image_file_type, $allowed_extensions)) {
                echo "Gabim: Vetëm imazhet JPG, JPEG, PNG dhe GIF janë të lejueshme.";
                return false;
            }
    
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
             
                $stmt = $this->db->prepare("INSERT INTO eventet (image, title, content, date) VALUES (?, ?, ?, CURRENT_DATE)");
                $stmt->bind_param("sss", $image_name, $this->title, $this->content); 
                return $stmt->execute();
            } else {
                echo "Gabim gjatë ngarkimit të imazhit.";
                return false;
            }
        }
        return false;
    }
    

    public function getEvents() {
        $sql = "SELECT * FROM eventet ORDER BY id DESC"; 
        $result = mysqli_query($this->db, $sql);
    
        return $result;
    }


    public function deleteEvent($id) {
        $stmt = $this->db->prepare("DELETE FROM eventet WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>

