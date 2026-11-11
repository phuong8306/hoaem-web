<?php
class VoucherModel extends Database {
    
    // Kiểm tra mã giảm giá an toàn (bỏ qua điều kiện expiry_date nếu bảng không có cột này)
    public function getVoucherByCode($code) {
        $stmt = $this->pdo->prepare("SELECT * FROM vouchers WHERE code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả danh sách mã giảm giá cho trang quản trị Admin
    public function getAllVouchers() {
        $stmt = $this->pdo->query("SELECT * FROM vouchers ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm mã giảm giá mới (Kiểm tra xem bảng của ní có cột expiry_date không để điều chỉnh tương ứng)
    public function addVoucher($code, $discountPercent, $discountAmount, $minOrderValue, $expiryDate) {
        $stmt = $this->pdo->prepare("INSERT INTO vouchers (code, discount_percent, discount_amount, min_order_value) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$code, $discountPercent, $discountAmount, $minOrderValue]);
    }

    // Xóa mã giảm giá theo ID
    public function deleteVoucher($id) {
        $stmt = $this->pdo->prepare("DELETE FROM vouchers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}