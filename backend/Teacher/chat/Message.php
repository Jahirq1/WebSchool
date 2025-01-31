<?php
class Message {
    private $conn;
    private $sender_id;
    private $receiver_id;
    private $message;
    private $photoPath;

    public function __construct($conn, $sender_id, $receiver_id, $message, $photoPath = null) {
        $this->conn = $conn;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->message = $message;
        $this->photoPath = $photoPath;
    }

    public function sendMessage() {
        if ($this->photoPath) {
            $query = "INSERT INTO mesazhet (sender_id, receiver_id, message, message_image) 
                      VALUES ('$this->sender_id', '$this->receiver_id', '$this->message', '$this->photoPath')";
        } else {
            $query = "INSERT INTO mesazhet (sender_id, receiver_id, message) 
                      VALUES ('$this->sender_id', '$this->receiver_id', '$this->message')";
        }

        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function getMessages() {
        $sqlMessages = "SELECT * FROM mesazhet WHERE (sender_id = '$this->sender_id' AND receiver_id = '$this->receiver_id') 
                        OR (sender_id = '$this->receiver_id' AND receiver_id = '$this->sender_id') 
                        ORDER BY timestamp ASC";
        return mysqli_query($this->conn, $sqlMessages);
    }
}








?>