<?php
class UserModel extends Database {
    public function register($name, $password, $email) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, password, email, role) VALUES (?, ?, ?, 'customer')");
        return $stmt->execute([$name, $hashedPassword, $email]);
    }

    // Hỗ trợ tìm kiếm theo tên (cột 'name' trong DB) hoặc email
    public function getUserByName($name) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE name = ? OR email = ?");
        $stmt->execute([$name, $name]);
        return $stmt->fetch();
    }

    // Tạo hàm alias (tên dự phòng) getUserByUsername để AuthController gọi không bị lỗi Undefined method
    public function getUserByUsername($name) {
        return $this->getUserByName($name);
    }

    public function getAllUsersWithOrderCount() {
        try {
            // Đếm số lượng đơn hàng của mỗi user (bỏ qua cột total_price để tránh lỗi không khớp tên cột)
            $sql = "SELECT u.id, u.name, u.email, u.created_at, 
                           COUNT(o.id) as order_count 
                    FROM users u 
                    LEFT JOIN orders o ON u.id = o.user_id 
                    GROUP BY u.id, u.name, u.email, u.created_at 
                    ORDER BY u.id DESC";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Nếu bảng users chưa có cột created_at, dùng câu lệnh dự phòng này:
            $sqlFallback = "SELECT u.id, u.name, u.email, NOW() as created_at, 
                                   COUNT(o.id) as order_count 
                            FROM users u 
                            LEFT JOIN orders o ON u.id = o.user_id 
                            GROUP BY u.id, u.name, u.email 
                            ORDER BY u.id DESC";
            $stmtFallback = $this->pdo->query($sqlFallback);
            return $stmtFallback->fetchAll();
        }
    }
}