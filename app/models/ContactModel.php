<?php
class ContactModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->pdo;
    }

    // Lấy tất cả tin nhắn mới nhất
    public function getAllMessages() {
        $stmt = $this->db->query("SELECT * FROM contacts ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xóa tin nhắn theo ID
    public function deleteMessage($id) {
        $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    // Lưu tin nhắn khi khách gửi từ trang Contact
    public function saveMessage($name, $email, $phone, $message) {
        $stmt = $this->db->prepare("INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $phone, $message]);
    }
}