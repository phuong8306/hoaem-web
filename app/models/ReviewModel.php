<?php
class ReviewModel extends Database {
    public function getReviewsByProductId($productId) {
        // Đã đổi 'product_reviews' thành 'reviews' và 'u.username' thành 'u.name' (hoặc giữ nguyên nếu bảng user có username)
        $sql = "SELECT r.*, u.name AS username 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.product_id = ? 
                ORDER BY r.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function addReview($productId, $userId, $rating, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$productId, $userId, $rating, $comment]);
    }

    // --- CÁC HÀM DÀNH CHO ADMIN ---
    
    // Lấy tất cả đánh giá kèm tên sản phẩm và tên người dùng
    public function getAllReviewsForAdmin() {
        $sql = "SELECT r.*, p.name AS product_name, u.name AS username 
                FROM reviews r 
                JOIN products p ON r.product_id = p.id 
                JOIN users u ON r.user_id = u.id 
                ORDER BY r.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Xóa đánh giá theo ID
    public function deleteReview($reviewId) {
        $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE id = ?");
        return $stmt->execute([$reviewId]);
    }
}