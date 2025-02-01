<?php
class Teacher {
    private $conn;
    private $teacher_id;

    public function __construct($teacher_id, $conn) {
        $this->teacher_id = $teacher_id;
        $this->conn = $conn;
    }

    public function getSubjects() {
        $sql = "SELECT * FROM subjects WHERE professor_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->teacher_id);
        $stmt->execute();
        return $stmt->get_result();
    }
public function getStudents() {
    $sql = "SELECT 
                 s.id AS student_id, 
                 u.username AS username, 
                 sub.id AS subject_id, 
                 sub.name AS subject_name
            FROM studenti s
            JOIN users u ON u.id = s.user_id
            JOIN student_subjects ss ON ss.student_id = s.id
            JOIN subjects sub ON sub.id = ss.subject_id
            WHERE sub.professor_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $this->teacher_id);
    $stmt->execute();
    return $stmt->get_result();
}


 


public function saveGrade($student_id, $subject_id, $grade) {
    $sql = "INSERT INTO student_notat (student_id, subject_id, grade, professor_id) 
            VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("iiis", $student_id, $subject_id, $grade, $this->teacher_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


}
?>
