<?php
class FileManager {
    private $uploadDir = '../../uploads/';
    private $maxFileSize = 5000000; 

    public function uploadFile($file) {
        if ($file['error'] == 0) {
            $fileTmp = $file['tmp_name'];
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];

            if ($fileSize <= $this->maxFileSize) {
                $uploadPath = $this->uploadDir . basename($fileName);
                if (move_uploaded_file($fileTmp, $uploadPath)) {
                    return $uploadPath;
                } else {
                    return "Gabim gjatë ngarkimit të file-it!";
                }
            } else {
                return "File-i është shumë i madh!";
            }
        } else {
            return "Gabim gjatë ngarkimit të file-it!";
        }
    }
}
?>
