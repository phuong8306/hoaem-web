<?php
class OrderModel extends Database {
    
    // Lấy tất cả danh sách đơn hàng để hiển thị ở trang quản trị Admin
    public function getAllOrders() {
        $sql = "SELECT o.*, u.name as customer_name 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo đơn hàng mới từ giỏ hàng
    public function createOrder($userId, $fullname, $phone, $address, $paymentMethod, $totalPrice, $cartItems) {
        try {
            $this->pdo->beginTransaction();

            // 1. Thêm vào bảng orders
            $sqlOrder = "INSERT INTO orders (user_id, fullname, phone, address, payment_method, total_price, status, created_at) 
                         VALUES (?, ?, ?, ?, ?, ?, 'Chờ xác nhận', NOW())";
            $stmtOrder = $this->pdo->prepare($sqlOrder);
            $stmtOrder->execute([$userId, $fullname, $phone, $address, $paymentMethod, $totalPrice]);
            $orderId = $this->pdo->lastInsertId();

            // 2. Thêm chi tiết đơn hàng vào bảng order_items và trừ tồn kho
            foreach ($cartItems as $item) {
                $variantId = $item['variant_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];

                // Thêm vào order_items
                $sqlItem = "INSERT INTO order_items (order_id, variant_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmtItem = $this->pdo->prepare($sqlItem);
                $stmtItem->execute([$orderId, $variantId, $quantity, $price]);

                // Trừ số lượng tồn kho của biến thể sản phẩm
                $sqlStock = "UPDATE product_variants SET stock_quantity = stock_quantity - ? WHERE id = ? AND stock_quantity >= ?";
                $stmtStock = $this->pdo->prepare($sqlStock);
                $stmtStock->execute([$quantity, $variantId, $quantity]);
            }

            $this->pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function getAnalyticsSummary() {
        try {
            // Tổng doanh thu từ các đơn hàng hoàn thành hoặc đã giao
            $stmt = $this->pdo->query("SELECT SUM(total_price) as total_revenue, COUNT(*) as total_orders FROM orders");
            $data = $stmt->fetch();

            // Tổng số khách hàng
            $stmtUser = $this->pdo->query("SELECT COUNT(*) as total_customers FROM users");
            $userData = $stmtUser->fetch();

            return [
                'total_revenue' => $data['total_revenue'] ?? 0,
                'total_orders' => $data['total_orders'] ?? 0,
                'total_customers' => $userData['total_customers'] ?? 0
            ];
        } catch (PDOException $e) {
            return [
                'total_revenue' => 0,
                'total_orders' => 0,
                'total_customers' => 0
            ];
        }
    }

    // Lấy danh sách sản phẩm bán chạy cho trang analytics
    public function getTopSellingProducts() {
        try {
            $sql = "SELECT p.name, SUM(oi.quantity) as total_sold, SUM(oi.quantity * oi.price) as revenue 
                    FROM order_items oi 
                    JOIN products p ON oi.product_id = p.id 
                    GROUP BY p.id, p.name 
                    ORDER BY total_sold DESC 
                    LIMIT 5";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getOrdersByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, pv.color, pv.size, p.name AS product_name 
                FROM order_items oi 
                JOIN product_variants pv ON oi.variant_id = pv.id 
                JOIN products p ON pv.product_id = p.id 
                WHERE oi.order_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
    // Cập nhật trạng thái đơn hàng cho Admin
    public function updateOrderStatus($orderId, $status) {
        try {
            $stmt = $this->pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
            return $stmt->execute([$status, $orderId]);
        } catch (PDOException $e) {
            return false;
        }
    }
}