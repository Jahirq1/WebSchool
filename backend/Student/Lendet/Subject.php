<?php


class Subject {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

   
    public function getSubjectsByStudent($student_id) {
        $sql = "SELECT subjects.id, subjects.name, users.username AS professor 
                FROM subjects
                JOIN users ON subjects.professor_id = users.id
                JOIN student_subjects ON student_subjects.subject_id = subjects.id
                WHERE student_subjects.student_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        return $stmt->get_result();
    }

 
    public function checkSubjectExists($subject_id) {
        $sql = "SELECT id FROM subjects WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}


?>