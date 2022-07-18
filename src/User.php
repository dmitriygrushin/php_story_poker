<?php

class User {
    private $username;
    private $room_id;
    private $conn;
    private $points;
    
    public function __construct($username, $room_id, $conn) {
        $this->username = $username;
        $this->room_id = $room_id;
        $this->conn = $conn;
        $this->points = 0;
    }

    public function getUsername() { return $this->username; }
    public function getRoomId() { return $this->room_id; }
    public function getConn() { return $this->conn; }
    public function getPoints() { return $this->points; }

    public function setPoints($points) { $this->points = $points; }
}