<?php
require_once '../app/models/OrderModel.php';

class CheckoutController {
    // Hiển thị form thanh toán
    public function index() {
        if (empty($_SESSION['cart'])) {
            header('Location: /cart');
            exit();
        }
        View::render('checkout/index', ['title' => 'Thanh toán đơn hàng']);
    }

    // Xử lý lưu đơn hàng
    public function process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['cart'])) {
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $payment_method = $_POST['payment_method'];

            // Tính tổng tiền giỏ hàng tạm tính
            $subtotal = 0;
            foreach ($_SESSION['cart'] as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            // Tính tiền giảm giá từ mã Voucher (nếu có)
            $discount = 0;
            if (isset($_SESSION['voucher'])) {
                $v = $_SESSION['voucher'];
                if ($v['discount_percent'] > 0) {
                    $discount = ($subtotal * $v['discount_percent']) / 100;
                } else {
                    $discount = $v['discount_amount'];
                }
            }

            // Tổng thanh toán cuối cùng
            $totalPrice = $subtotal - $discount;
            if ($totalPrice < 0) {
                $totalPrice = 0;
            }

            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            $orderData = [
                'fullname' => $fullname,
                'phone' => $phone,
                'address' => $address,
                'total_price' => $totalPrice,
                'payment_method' => $payment_method
            ];

            $orderModel = new OrderModel();
            $orderId = $orderModel->createOrder($userId, $orderData, $_SESSION['cart']);

            if ($orderId) {
                // Xóa giỏ hàng và hủy mã giảm giá sau khi đặt thành công
                unset($_SESSION['cart']);
                unset($_SESSION['voucher']);
                echo "<script>alert('Đặt hàng thành công! Mã đơn hàng của bạn là: #{$orderId}'); window.location.href='/';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!'); history.back();</script>";
            }
        }
    }
}