<?php
class Student
{
    private $student_id;
    private $conn;

    public function __construct($conn, $student_id)
    {
        $this->conn = $conn;
        $this->student_id = $student_id;
    }

  
    public function checkAndRegisterStudent()
    {
        $sql_check_student = "SELECT id FROM studenti WHERE user_id = ?";
        $stmt_check_student = $this->conn->prepare($sql_check_student);
        $stmt_check_student->bind_param("i", $this->student_id);
        $stmt_check_student->execute();
        $result_check_student = $stmt_check_student->get_result();

        if ($result_check_student->num_rows == 0) {
          
            $sql_register_student = "INSERT INTO studenti (user_id) VALUES (?)";
            $stmt_register_student = $this->conn->prepare($sql_register_student);
            $stmt_register_student->bind_param("i", $this->student_id);
            $stmt_register_student->execute();

            return $this->conn->insert_id;
        }

        return $result_check_student->fetch_assoc()['id'];
    }

 
    public function getActiveSubjects($items_per_page, $offset)
    {
        $sql_active_subjects = "
            SELECT subjects.id, subjects.name, users.username AS professor, subjects.password 
            FROM subjects
            JOIN users ON subjects.professor_id = users.id
            LEFT JOIN student_subjects 
                ON student_subjects.subject_id = subjects.id 
                AND student_subjects.student_id = ?
            WHERE student_subjects.subject_id IS NULL
            LIMIT ? OFFSET ?
        ";
    
        $stmt_active_subjects = $this->conn->prepare($sql_active_subjects);
        $stmt_active_subjects->bind_param("iii", $this->student_id, $items_per_page, $offset);
        $stmt_active_subjects->execute();
        
        return $stmt_active_subjects->get_result();
    }
    
    public function getRegisteredSubjects()
    {
        $sql_registered_subjects = "
            SELECT s.id, s.name, u.username AS professor
            FROM subjects s
            INNER JOIN student_subjects ss ON s.id = ss.subject_id
            INNER JOIN users u ON s.professor_id = u.id
            INNER JOIN studenti st ON ss.student_id = st.id
            WHERE st.user_id = ?";
            
        $stmt_registered_subjects = $this->conn->prepare($sql_registered_subjects);
        $stmt_registered_subjects->bind_param("i", $this->student_id); 
        $stmt_registered_subjects->execute();
        return $stmt_registered_subjects->get_result();
    }
    
   
    public function checkSubjectExists($subject_id)
    {
       
        $sql_check_subject = "
        SELECT ss.subject_id 
        FROM student_subjects ss
        JOIN studenti s ON ss.student_id = s.id
        JOIN users u ON u.id = s.user_id  -- përdor 'id' për të lidhur përdoruesin
        WHERE u.id = ? AND ss.subject_id = ?"; 
    
        $stmt_check_subject = $this->conn->prepare($sql_check_subject);
        $stmt_check_subject->bind_param("ii", $this->student_id, $subject_id); 
        $stmt_check_subject->execute();
        $result_check_subject = $stmt_check_subject->get_result();
        
        return $result_check_subject->num_rows > 0; 
    }
    



    public function checkPassword($subject_id, $password)
    {
        $sql_check_password = "SELECT password FROM subjects WHERE id = ?";
        $stmt_check_password = $this->conn->prepare($sql_check_password);
        $stmt_check_password->bind_param("i", $subject_id);
        $stmt_check_password->execute();
        $result = $stmt_check_password->get_result();
        $subject = $result->fetch_assoc();
    
        if ($subject && password_verify($password, $subject['password'])) {
            return true;
        }
        return false;
    }
    

  public function registerSubject($subject_id) {

    $student_check_sql = "SELECT id FROM studenti WHERE user_id = ?";
    $stmt_check_student = $this->conn->prepare($student_check_sql);
    $stmt_check_student->bind_param("i", $this->student_id);
    $stmt_check_student->execute();
    $result_check_student = $stmt_check_student->get_result();

    if ($result_check_student->num_rows == 0) {
        
        $sql_register_student = "INSERT INTO studenti (user_id) VALUES (?)";
        $stmt_register_student = $this->conn->prepare($sql_register_student);
        $stmt_register_student->bind_param("i", $this->student_id);
        $stmt_register_student->execute();

        
        $this->student_id = $this->conn->insert_id; 
        echo "Studenti është regjistruar me sukses! ";
    } else {
       
        $this->student_id = $result_check_student->fetch_assoc()['id'];
        echo "Studenti ekziston! ";
    }

  
    $subject_check_sql = "SELECT id FROM subjects WHERE id = ?";
    $subject_check_stmt = $this->conn->prepare($subject_check_sql);
    $subject_check_stmt->bind_param("i", $subject_id);
    $subject_check_stmt->execute();
    $subject_check_result = $subject_check_stmt->get_result();

    if ($subject_check_result->num_rows == 0) {
        echo "Gabim: Lënda nuk ekziston!";
        return;
    }

    
    $sql_register = "INSERT INTO student_subjects (student_id, subject_id) VALUES (?, ?)";
    $stmt_register = $this->conn->prepare($sql_register);
    $stmt_register->bind_param("ii", $this->student_id, $subject_id);
    $stmt_register->execute();

    echo "Lënda është regjistruar me sukses!";
}

}

?>
