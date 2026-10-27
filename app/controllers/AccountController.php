<?php
require_once '../app/models/OrderModel.php';

class AccountController {
    // Middleware kiểm tra đăng nhập cho tất cả các trang cá nhân
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Vui lòng đăng nhập để xem thông tin tài khoản!'); window.location.href='/auth/login';</script>";
            exit();
        }
    }

    // Hiển thị lịch sử đơn hàng của người dùng đang đăng nhập
    public function orders() {
        $userId = $_SESSION['user_id'];
        $orderModel = new OrderModel();
        $orders = $orderModel->getOrdersByUserId($userId);

        View::render('account/orders', [
            'title' => 'Lịch sử đơn hàng của bạn',
            'orders' => $orders
        ]);
    }

    // Hiển thị chi tiết một đơn hàng cụ thể
    public function orderDetail($orderId = null) {
        if (!$orderId) {
            header('Location: /account/orders');
            exit();
        }

        $orderModel = new OrderModel();
        $userId = $_SESSION['user_id'];

        // Lấy thông tin đơn hàng và kiểm tra xem có đúng của người dùng này không (hoặc admin)
        $orders = $orderModel->getOrdersByUserId($userId);
        $currentOrder = null;
        foreach ($orders as $ord) {
            if ($ord['id'] == $orderId) {
                $currentOrder = $ord;
                break;
            }
        }

        // Nếu không tìm thấy đơn hàng thuộc về user này
        if (!$currentOrder) {
            echo "<script>alert('Không tìm thấy đơn hàng hoặc bạn không có quyền xem!'); window.location.href='/account/orders';</script>";
            exit();
        }

        // Lấy danh sách sản phẩm trong đơn hàng
        $items = $orderModel->getOrderItems($orderId);

        View::render('account/order_detail', [
            'title' => 'Chi tiết đơn hàng #' . $orderId,
            'order' => $currentOrder,
            'items' => $items
        ]);
    }
}