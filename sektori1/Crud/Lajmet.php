<?php
class Lajmet {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    


    
    public function addNews($image, $title, $content) {
        if ($this->uploadImage($image)) {
            $imageName = basename($image['name']);
            $stmt = $this->conn->prepare("INSERT INTO posts (image_url, title, content) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $imageName, $title, $content);
            return $stmt->execute();
        }
        return false;
    }

 
    public function addHeadNews($headImage, $headTitle, $headContent) {
        if ($this->uploadHeadImage($headImage)) {
            $imageName = basename($headImage['name']);
            $stmt = $this->conn->prepare("INSERT INTO head_news (head_image_url, head_title, head_content) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $imageName, $headTitle, $headContent);
            return $stmt->execute();
        }
        return false;
    }

    
    public function deleteNews($id) {
        $stmt = $this->conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    
    public function deleteHeadNews($id) {
        $stmt = $this->conn->prepare("DELETE FROM head_news WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    
    private function uploadImage($image) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image['type'], $allowedTypes)) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imagePath = $uploadDir . basename($image['name']);
            return move_uploaded_file($image['tmp_name'], $imagePath);
        }
        return false;
    }

 
    private function uploadHeadImage($headImage) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($headImage['type'], $allowedTypes)) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imagePath = $uploadDir . basename($headImage['name']);
            return move_uploaded_file($headImage['tmp_name'], $imagePath);
        }
        return false;
    }

    
    public function getNews() {
        $sql = "SELECT * FROM posts ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
    public function getHeadNews() {
        $sql = "SELECT * FROM head_news ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
