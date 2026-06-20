<?php
// src/Repository/UserRepository.php
require_once __DIR__ . '/../../config/database.php';

class UserRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // 🚀 صلحنا البحث هنا باش يقلب بالـ email لي كاين ف الداتا بيز ديالك
    public function findByUsername(string $name) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$name]);
        return $stmt->fetch() ?: null;
    }

    public function findById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getAllUsers() {
        return $this->db->query("SELECT id, email, role FROM users ORDER BY email ASC")->fetchAll();
    }
}