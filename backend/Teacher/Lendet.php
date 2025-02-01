<?php
class SubjectManager {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    public function checkSubjectExists($subject_name, $professor_id) {
        $sql = "SELECT * FROM subjects WHERE name = ? AND professor_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $subject_name, $professor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function createSubject($subject_name, $password, $professor_id) {
        if ($this->checkSubjectExists($subject_name, $professor_id)) {
            return "Lënda ekziston tashmë!";
        }
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT); 
        $sql = "INSERT INTO subjects (name, password, professor_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $subject_name, $password_hash, $professor_id);
        
        if ($stmt->execute()) {
            return "Lenda u krijua me sukses!";
        } else {
            return "Ndodhi një gabim gjatë krijimit të lëndës!";
        }
    }

    public function getSubjects($professor_id) {
        $sql = "SELECT * FROM subjects WHERE professor_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $professor_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
