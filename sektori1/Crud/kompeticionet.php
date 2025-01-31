<?php


class kompeticionet {
    private $conn;
    private $table_name = "kompeticionet";

    public $id;
    public $name;
    public $description;
    public $image;

    public function __construct($db) {
        $this->conn = $db;
    }

  
    public function getCompetitions() {
        $sql = "SELECT id, name FROM " . $this->table_name;
        $result = $this->conn->query($sql);

        $competitions = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $competitions[] = $row;
            }
        } else {
            echo "Nuk ka kompeticione në bazën e të dhënave.";
        }

        return $competitions;
    }

  
    public function addCompetition($name, $description, $imagePath = null) {
        $sql = "INSERT INTO " . $this->table_name . " (name, description, image) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $name, $description, $imagePath);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

 
    public function getCompetitionDetails($id) {
        $sql = "SELECT id, name, description, image FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function deleteCompetition($id) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
