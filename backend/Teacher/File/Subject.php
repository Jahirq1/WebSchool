<?php
class SubjectMaterialManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function checkSubjectExists($subjectId) {
        $sql = "SELECT id FROM subjects WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subjectId);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }

    public function saveMaterial($subjectId, $fileName, $uploadPath, $fileTitle) {
        $sql = "INSERT INTO subject_materials (subject_id, file_name, file_path, file_title) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $subjectId, $fileName, $uploadPath, $fileTitle);
        
        return $stmt->execute();
    }

    public function getMaterials($subjectId) {
        $sql = "SELECT * FROM subject_materials WHERE subject_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subjectId);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
