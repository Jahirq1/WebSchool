<?php
class Chat {
    private $conn;
    private $professor_id;
    private $prind_id;

    public function __construct($conn, $professor_id, $prind_id) {
        $this->conn = $conn;
        $this->professor_id = $professor_id;
        $this->prind_id = $prind_id;
    }

    public function getChatMessages() {
        $message = new Message($this->conn, $this->professor_id, $this->prind_id, "");
        return $message->getMessages();
    }

    public function sendChatMessage($message, $photoPath = null) {
        $message = new Message($this->conn, $this->professor_id, $this->prind_id, $message, $photoPath);
        return $message->sendMessage();
    }
}


?>