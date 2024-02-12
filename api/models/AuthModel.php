<?php

class AuthModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE deleted_at is null AND email = :email");
        $this->db->bind(":email", $email);
        return $this->db->single();
    }

    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE deleted_at is null AND id = :id");
        $this->db->bind(":id", $id);
        return $this->db->single();
    }
}