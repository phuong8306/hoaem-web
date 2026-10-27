<?php
require_once __DIR__ . '/../models/OrderModel.php';

class CartController {
    // Hiển thị trang thanh toán
    public function checkout() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "<script>alert('Giỏ hàng của bạn đang trống!'); window.location.href='/';</script>";
            exit();
        }

        View::render('cart/checkout', [
            'title' => 'Thanh toán đơn hàng'
        ]);
    }

    // Xử lý lưu đơn hàng vào CSDL
    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "<script>alert('Giỏ hàng trống!'); window.location.href='/';</script>";
                exit();
            }

            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Cho phép khách vãng lai hoặc bắt buộc đăng nhập tùy ý
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $paymentMethod = trim($_POST['payment_method']);

            // Tính lại tổng tiền
            $subTotal = 0;
            foreach ($_SESSION['cart'] as $item) {
                $subTotal += $item['price'] * $item['quantity'];
            }

            $discountTotal = 0;
            if (isset($_SESSION['voucher'])) {
                if ($_SESSION['voucher']['discount_percent'] > 0) {
                    $discountTotal = ($subTotal * $_SESSION['voucher']['discount_percent']) / 100;
                } else {
                    $discountTotal = $_SESSION['voucher']['discount_amount'];
                }
                if ($discountTotal > $subTotal) $discountTotal = $subTotal;
            }

            $finalTotal = $subTotal - $discountTotal;

            $orderModel = new OrderModel();
            $orderId = $orderModel->createOrder($userId, $fullname, $phone, $address, $paymentMethod, $finalTotal, $_SESSION['cart']);

            if ($orderId) {
                // Xóa giỏ hàng và voucher sau khi đặt hàng thành công
                unset($_SESSION['cart']);
                unset($_SESSION['voucher']);

                echo "<script>alert('Đặt hàng thành công! Mã đơn hàng của bạn là #" . $orderId . "'); window.location.href='/account/orders';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra hoặc sản phẩm không đủ tồn kho, vui lòng thử lại!'); history.back();</script>";
            }
        }
    }
}