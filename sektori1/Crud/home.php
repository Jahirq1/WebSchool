<?php
class News {
    public static function addNews($db, $image, $title, $content) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image['type'], $allowedTypes)) {
            $imagePath = 'uploads/' . basename($image['name']);

            if (!is_dir('../uploads')) {
                mkdir('../uploads', 0777, true);
            }

            if (move_uploaded_file($image['tmp_name'], '../' . $imagePath)) {
                $stmt = mysqli_prepare($db, "INSERT INTO homeSlider (image_url, title, content) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sss", $image['name'], $title, $content);

                if (mysqli_stmt_execute($stmt)) {
                    return true;
                } else {
                    return false;
                }
            }   
        }
        return false;
    }

    public static function deleteNews($db, $id) {
        if (!empty($id)) {
            $stmt = mysqli_prepare($db, "DELETE FROM homeSlider WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
        }
        return false;
    }

    public static function getAllNews($db) {
        $sql = "SELECT * FROM homeslider ORDER BY id DESC";
        $result = mysqli_query($db, $sql);
    
        $news = [];
        if (!$result) {
            die("Gabim në kërkimin e lajmeve: " . mysqli_error($db)); // Shto një mesazh gabimi për SQL
        }
    
        while ($row = mysqli_fetch_assoc($result)) {
            $news[] = $row;
        }
    
        return $news;
    }
    
}
?>
