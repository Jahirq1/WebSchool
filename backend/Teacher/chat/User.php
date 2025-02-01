<?php
class User {
    private $conn;
    private $user_id;

    public function __construct($conn, $user_id) {
        $this->conn = $conn;
        $this->user_id = $user_id;
    }

    public function getUsername() {
        $sql = "SELECT username FROM users WHERE id = '$this->user_id'";
        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            $user = mysqli_fetch_assoc($result);
            return $user['username'];
        } else {
            return "Përdoruesi i panjohur";
        }
    }

    public static function checkUserExists($conn, $user_id) {
        $sql = "SELECT id FROM users WHERE id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
}


?>