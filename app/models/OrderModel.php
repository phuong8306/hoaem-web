<?php
class OrderModel extends Database {
    public function createOrder($userId, $data, $cartItems) {
        try {
            $this->pdo->beginTransaction();

            // 1. Lưu thông tin đơn hàng chính
            $sqlOrder = "INSERT INTO orders (user_id, fullname, phone, address, total_price, payment_method) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sqlOrder);
            $stmt->execute([
                $userId,
                $data['fullname'],
                $data['phone'],
                $data['address'],
                $data['total_price'],
                $data['payment_method']
            ]);
            
            $orderId = $this->pdo->lastInsertId();

            // 2. Lưu chi tiết sản phẩm và trừ tồn kho
            foreach ($cartItems as $item) {
                $sqlItem = "INSERT INTO order_items (order_id, variant_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmtItem = $this->pdo->prepare($sqlItem);
                $stmtItem->execute([
                    $orderId,
                    $item['variant_id'],
                    $item['quantity'],
                    $item['price']
                ]);

                // Trừ kho biến thể sản phẩm
                $sqlStock = "UPDATE product_variants SET stock_quantity = stock_quantity - ? WHERE id = ?";
                $stmtStock = $this->pdo->prepare($sqlStock);
                $stmtStock->execute([$item['quantity'], $item['variant_id']]);
            }

            $this->pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
    // Lấy danh sách đơn hàng của khách hàng theo ID
    public function getOrdersByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // Lấy chi tiết các sản phẩm trong một đơn hàng cụ thể
    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, v.size, v.color, p.name AS product_name, p.slug 
                FROM order_items oi 
                JOIN product_variants v ON oi.variant_id = v.id 
                JOIN products p ON v.product_id = p.id 
                WHERE oi.order_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
}