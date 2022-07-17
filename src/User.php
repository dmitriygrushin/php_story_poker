<?php

class User {
    private $username;
    private $room_id;
    private $conn;
    
    public function __construct($username, $room_id, $conn) {
        $this->username = $username;
        $this->room_id = $room_id;
        $this->conn = $conn;
    }

    public function getUsername() { return $this->username; }
    public function getRoomId() { return $this->room_id; }
    public function getConn() { return $this->conn; }
}