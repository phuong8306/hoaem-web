<?php
// Không dùng require_once rườm rà nữa, mà dùng trực tiếp cơ chế kế thừa từ Database
class OccasionModel extends Database {

    public function getAllOccasions() {
        // Sử dụng luôn $this->pdo sẵn có của class Database cha
        $stmt = $this->pdo->prepare("SELECT * FROM occasions ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOccasion($name, $slug, $description, $icon, $badge) {
        $stmt = $this->pdo->prepare("INSERT INTO occasions (name, slug, description, icon, badge) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $slug, $description, $icon, $badge]);
    }

    public function deleteOccasion($id) {
        $stmt = $this->pdo->prepare("DELETE FROM occasions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}