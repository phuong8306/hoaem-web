<?php
class VoucherModel extends Database {
    // Kiểm tra mã giảm giá hợp lệ (còn hạn và đang active)
    public function getVoucherByCode($code) {
        $stmt = $this->pdo->prepare("SELECT * FROM vouchers WHERE code = ? AND status = 1 AND expiry_date >= CURDATE()");
        $stmt->execute([$code]);
        return $stmt->fetch();
    }

    public function getAllVouchers() {
        $stmt = $this->pdo->query("SELECT * FROM vouchers ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function addVoucher($code, $discountPercent, $discountAmount, $minOrderValue, $expiryDate) {
        $stmt = $this->pdo->prepare("INSERT INTO vouchers (code, discount_percent, discount_amount, min_order_value, expiry_date, status) VALUES (?, ?, ?, ?, ?, 1)");
        return $stmt->execute([$code, $discountPercent, $discountAmount, $minOrderValue, $expiryDate]);
    }

    public function deleteVoucher($id) {
        $stmt = $this->pdo->prepare("DELETE FROM vouchers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}