<?php
require_once '../app/models/ProductModel.php';

class CartController {
    public function __construct() {
        // Khởi tạo giỏ hàng trong Session nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Hiển thị giao diện giỏ hàng
    public function index() {
        View::render('cart/index', ['title' => 'Giỏ hàng của bạn']);
    }

    // Xử lý thêm sản phẩm vào giỏ
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variantId = (int)$_POST['variant_id'];
            $quantity = (int)$_POST['quantity'];

            $productModel = new ProductModel();
            $variant = $productModel->getVariantDetails($variantId);

            if ($variant) {
                // Nếu phân loại này đã có trong giỏ -> Cộng dồn số lượng
                if (isset($_SESSION['cart'][$variantId])) {
                    $_SESSION['cart'][$variantId]['quantity'] += $quantity;
                } else {
                    // Nếu chưa có -> Thêm mới vào giỏ
                    $_SESSION['cart'][$variantId] = [
                        'variant_id' => $variant['id'],
                        'product_name' => $variant['product_name'],
                        'slug' => $variant['slug'],
                        'size' => $variant['size'],
                        'color' => $variant['color'],
                        'price' => $variant['price'],
                        'quantity' => $quantity
                    ];
                }
            }
            // Chuyển hướng về trang giỏ hàng
            header('Location: /cart');
            exit();
        }
    }

    // Xóa 1 sản phẩm khỏi giỏ
    public function remove($variantId = null) {
        if ($variantId && isset($_SESSION['cart'][$variantId])) {
            unset($_SESSION['cart'][$variantId]);
        }
        header('Location: /cart');
        exit();
    }
}