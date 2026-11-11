<?php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/VoucherModel.php';

class CartController {

    // Hiển thị trang giỏ hàng
    public function index() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        
        $subTotal = 0;
        foreach ($cart as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }

        // Tính toán voucher nếu có
        $discountTotal = 0;
        if (isset($_SESSION['voucher'])) {
            $v = $_SESSION['voucher'];
            if ($subTotal >= ($v['min_order_value'] ?? 0)) {
                if (!empty($v['discount_percent']) && $v['discount_percent'] > 0) {
                    $discountTotal = ($subTotal * $v['discount_percent']) / 100;
                } else {
                    $discountTotal = $v['discount_amount'] ?? 0;
                }
                if ($discountTotal > $subTotal) $discountTotal = $subTotal;
            } else {
                // Nếu giá trị đơn hàng không đủ điều kiện tối thiểu, tự động hủy voucher
                unset($_SESSION['voucher']);
            }
        }

        $finalTotal = $subTotal - $discountTotal;

        View::render('cart/index', [
            'title' => 'Giỏ hàng của bạn - hoa&em',
            'cart' => $cart,
            'subTotal' => $subTotal,
            'discountTotal' => $discountTotal,
            'finalTotal' => $finalTotal
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $variantId = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            if ($productId > 0) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                $cartKey = $productId . '_' . $variantId;

                if (isset($_SESSION['cart'][$cartKey])) {
                    $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
                } else {
                    $productModel = new ProductModel();
                    $product = $productModel->getProductById($productId);
                    $variants = $productModel->getVariantsByProductId($productId);
                    
                    $selectedVariant = null;
                    foreach ($variants as $v) {
                        if ($v['id'] == $variantId) {
                            $selectedVariant = $v;
                            break;
                        }
                    }

                    if (!$selectedVariant && !empty($variants)) {
                        $selectedVariant = $variants[0];
                        $variantId = $selectedVariant['id'];
                    }

                    $price = $selectedVariant ? $selectedVariant['price'] : ($product['price'] ?? 0);
                    $size = $selectedVariant['size'] ?? 'Tiêu chuẩn';
                    $color = $selectedVariant['color'] ?? 'Mặc định';
                    $image = !empty($selectedVariant['image']) ? $selectedVariant['image'] : ($product['image'] ?? '');

                    $_SESSION['cart'][$cartKey] = [
                        'product_id' => $productId,
                        'variant_id' => $variantId,
                        'name' => $product['name'] ?? 'Sản phẩm hoa',
                        'price' => $price,
                        'quantity' => $quantity,
                        'size' => $size,
                        'color' => $color,
                        'image' => $image
                    ];
                }

                echo "<script>alert('Thêm vào giỏ hàng thành công!'); window.location.href='/cart';</script>";
                exit();
            }
        }
        header('Location: /');
        exit();
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartKey = $_POST['cart_key'] ?? '';
            $action = $_POST['action'] ?? '';

            if (isset($_SESSION['cart'][$cartKey])) {
                if ($action === 'increase') {
                    $_SESSION['cart'][$cartKey]['quantity']++;
                } elseif ($action === 'decrease') {
                    $_SESSION['cart'][$cartKey]['quantity']--;
                    if ($_SESSION['cart'][$cartKey]['quantity'] <= 0) {
                        unset($_SESSION['cart'][$cartKey]);
                    }
                } elseif ($action === 'update') {
                    $qty = (int)($_POST['quantity'] ?? 1);
                    if ($qty > 0) {
                        $_SESSION['cart'][$cartKey]['quantity'] = $qty;
                    } else {
                        unset($_SESSION['cart'][$cartKey]);
                    }
                }
            }
        }
        header('Location: /cart');
        exit();
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($cartKey) {
        if (isset($_SESSION['cart'][$cartKey])) {
            unset($_SESSION['cart'][$cartKey]);
        }
        header('Location: /cart');
        exit();
    }

    // Áp dụng mã giảm giá
    public function applyVoucher() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = strtoupper(trim($_POST['voucher_code'] ?? ''));
            
            if (empty($code)) {
                echo "<script>alert('Vui lòng nhập mã giảm giá!'); window.location.href='/cart';</script>";
                exit();
            }

            $voucherModel = new VoucherModel();
            $voucher = $voucherModel->getVoucherByCode($code);

            if (!$voucher) {
                echo "<script>alert('Mã giảm giá không tồn tại hoặc đã hết hạn!'); window.location.href='/cart';</script>";
                exit();
            }

            // Tính tạm tính hiện tại
            $subTotal = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $subTotal += $item['price'] * $item['quantity'];
                }
            }

            if ($subTotal < $voucher['min_order_value']) {
                echo "<script>alert('Đơn hàng chưa đạt giá trị tối thiểu " . number_format($voucher['min_order_value'], 0, ',', '.') . " đ để dùng mã này!'); window.location.href='/cart';</script>";
                exit();
            }

            // Lưu vào session
            $_SESSION['voucher'] = $voucher;
            echo "<script>alert('Áp dụng mã giảm giá thành công!'); window.location.href='/cart';</script>";
            exit();
        }
    }

    // Hủy mã giảm giá
    public function removeVoucher() {
        if (isset($_SESSION['voucher'])) {
            unset($_SESSION['voucher']);
        }
        header('Location: /cart');
        exit();
    }

    // Hiển thị trang thanh toán
    public function checkout() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "<script>alert('Giỏ hàng của bạn đang trống!'); window.location.href='/cart';</script>";
            exit();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userData = [];
        $userAddresses = [];

        try {
            // Khởi tạo kết nối CSDL từ class Database chung của hệ thống
            $db = new Database();
            
            // Lấy thông tin user (fullname, phone, address mặc định...)
            $stmt = $db->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Lấy danh sách địa chỉ của user (nếu có bảng user_addresses)
            $stmtAddr = $db->pdo->prepare("SELECT * FROM user_addresses WHERE user_id = ?");
            $stmtAddr->execute([$userId]);
            $userAddresses = $stmtAddr->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            // Xử lý ngoại lệ nếu bảng phụ chưa tồn tại
        }

        View::render('cart/checkout', [
            'title' => 'Thanh toán đơn hàng - hoa&em',
            'userData' => $userData,
            'userAddresses' => $userAddresses
        ]);
    }

    // Xử lý lưu đơn hàng vào CSDL
    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "<script>alert('Giỏ hàng trống!'); window.location.href='/';</script>";
                exit();
            }

            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $paymentMethod = trim($_POST['payment_method']);

            $subTotal = 0;
            foreach ($_SESSION['cart'] as $item) {
                $subTotal += $item['price'] * $item['quantity'];
            }

            $discountTotal = 0;
            if (isset($_SESSION['voucher'])) {
                $v = $_SESSION['voucher'];
                if ($subTotal >= ($v['min_order_value'] ?? 0)) {
                    if (!empty($v['discount_percent']) && $v['discount_percent'] > 0) {
                        $discountTotal = ($subTotal * $v['discount_percent']) / 100;
                    } else {
                        $discountTotal = $v['discount_amount'] ?? 0;
                    }
                    if ($discountTotal > $subTotal) $discountTotal = $subTotal;
                }
            }

            $finalTotal = $subTotal - $discountTotal;

            $orderModel = new OrderModel();
            $orderId = $orderModel->createOrder($userId, $fullname, $phone, $address, $paymentMethod, $finalTotal, $_SESSION['cart']);

            if ($orderId) {
                unset($_SESSION['cart']);
                unset($_SESSION['voucher']);

                echo "<script>alert('Đặt hàng thành công! Mã đơn hàng của bạn là #" . $orderId . "'); window.location.href='/account/orders';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra hoặc sản phẩm không đủ tồn kho, vui lòng thử lại!'); history.back();</script>";
            }
        }
    }
}