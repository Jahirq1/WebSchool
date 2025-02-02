<?php
class Subject {
    private $conn;
    private $user_id;

   
    public function __construct($conn, $user_id) {
        $this->conn = $conn;
        $this->user_id = $user_id;
    }

    public function getTotalSubjects() {
        $query_count = "
            SELECT COUNT(*) AS total_subjects
            FROM student_subjects ss
            WHERE ss.student_id = (SELECT id FROM studenti WHERE user_id = ?)";
        
        $stmt_count = $this->conn->prepare($query_count);
        $stmt_count->bind_param("i", $this->user_id);
        $stmt_count->execute();
        $result_count = $stmt_count->get_result();
        $row_count = $result_count->fetch_assoc();
        
        return $row_count['total_subjects'];
    }

 
    public function getSubjects() {
        $query = "
            SELECT 
                s.name AS subject_name,
                u.username AS professor_name,
                ss.registration_date
            FROM 
                student_subjects ss
            INNER JOIN 
                subjects s ON ss.subject_id = s.id
            INNER JOIN 
                users u ON s.professor_id = u.id
            WHERE 
                ss.student_id = (
                    SELECT id FROM studenti WHERE user_id = ?
                )
            ORDER BY ss.registration_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
