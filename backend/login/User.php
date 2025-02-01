<?php
class User {
    private $username;
    private $password;
    private $role;
    private $conn;

    public function __construct($username, $password, $role, $conn) {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->conn = $conn;
    }

    public function checkIfUsernameExists() {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function register() {
        if ($this->checkIfUsernameExists()) {
            $_SESSION['message'] = "ky username ekziston";
            return true;
        } else {
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sss', $this->username, $hashedPassword, $this->role);

            if ($stmt->execute()) {
                $userId = $this->conn->insert_id;

                if ($this->role === 'Arsimtar') {
                    $this->createArsimtar($userId);
                } elseif ($this->role === 'Student') {
                    $this->createStudent($userId);
                } elseif ($this->role === 'Prind') {
                    $this->createPrind($userId);
                }

                $_SESSION['message'] = "Regjistrimi ishte i suksesshëm!";
                return true;  
            } else {
                $_SESSION['message'] = "Ka ndodhur një gabim gjatë regjistrimit!";
                return false;
            }
        }
    }

    private function createArsimtar($userId) {
        $query = "INSERT INTO arsimtar (user_id) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
    }

    private function createStudent($userId) {
        $query = "INSERT INTO studenti (user_id) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
    }

    private function createPrind($userId) {
        $query = "INSERT INTO prind (user_id) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
    }

    public function login() {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $this->username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($this->password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];  
               
                if ($this->role != $user['role']) {
                    return false;  
                }
    
               
                return $user['role']; 
            } else {
                return false; 
            }
        } else {
            return false; 
        }
    }

    
}
?>
