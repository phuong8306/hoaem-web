<?php
require_once '../app/models/OrderModel.php';
require_once '../app/models/ProductModel.php';
require_once '../app/models/UserModel.php';
require_once '../app/models/ReviewModel.php';
require_once '../app/models/VoucherModel.php';

class AdminController {
    // Middleware kiểm tra quyền truy cập Admin
    public function __construct() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "<script>alert('Truy cập bị từ chối! Bạn không có quyền quản trị.'); window.location.href='/';</script>";
        exit();
    }
}

    public function orders() {
        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrders();

        View::render('admin/orders', [
            'title' => 'Quản trị - Danh sách đơn hàng',
            'orders' => $orders
        ]);
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = (int)$_POST['order_id'];
            $status = trim($_POST['status']);

            $orderModel = new OrderModel();
            if ($orderModel->updateOrderStatus($orderId, $status)) {
                echo "<script>alert('Cập nhật trạng thái thành công!'); window.location.href='/admin/orders';</script>";
            } else {
                echo "<script>alert('Lỗi cập nhật!'); history.back();</script>";
            }
        }
    }

    public function products() {
        $productModel = new ProductModel();
        $products = $productModel->getAllProductsForAdmin();

        View::render('admin/products', [
            'title' => 'Quản trị - Danh sách sản phẩm',
            'products' => $products
        ]);
    }

    public function deleteProduct($id) {
        if ($id) {
            $productModel = new ProductModel();
            if ($productModel->deleteProduct($id)) {
                echo "<script>alert('Xóa sản phẩm thành công!'); window.location.href='/admin/products';</script>";
            } else {
                echo "<script>alert('Không thể xóa sản phẩm này!'); history.back();</script>";
            }
        }
    }

    public function createProduct() {
        $stmt = (new Database())->pdo->query("SELECT * FROM categories");
        $categories = $stmt->fetchAll();

        View::render('admin/product_add', [
            'title' => 'Thêm sản phẩm mới',
            'categories' => $categories
        ]);
    }

    public function storeProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $slug = strtolower(trim($_POST['slug']));
            $category_id = $_POST['category_id'];
            $description = trim($_POST['description']);
            $price = (float)$_POST['price'];
            $stock = (int)$_POST['stock'];
            $size = trim($_POST['size']);
            $color = trim($_POST['color']);
            $sku = trim($_POST['sku']);

            $productModel = new ProductModel();
            if ($productModel->addProduct($category_id, $name, $slug, $description, $price, $stock, $size, $color, $sku)) {
                echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href='/admin/products';</script>";
            } else {
                echo "<script>alert('Lỗi: SKU hoặc đường dẫn Slug có thể bị trùng!'); history.back();</script>";
            }
        }
    }

    public function inventory() {
        $productModel = new ProductModel();
        $variants = $productModel->getAllVariantsForInventory();

        View::render('admin/inventory', [
            'title' => 'Quản trị - Quản lý Tồn kho',
            'variants' => $variants
        ]);
    }

    public function updateStock() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variantId = (int)$_POST['variant_id'];
            $stock = (int)$_POST['stock_quantity'];

            $productModel = new ProductModel();
            if ($productModel->updateStock($variantId, $stock)) {
                echo "<script>alert('Cập nhật tồn kho thành công!'); window.location.href='/admin/inventory';</script>";
            } else {
                echo "<script>alert('Lỗi cập nhật tồn kho!'); history.back();</script>";
            }
        }
    }

    public function analytics() {
        $orderModel = new OrderModel();
        $summary = $orderModel->getAnalyticsSummary();
        $topProducts = $orderModel->getTopSellingProducts();

        View::render('admin/analytics', [
            'title' => 'Quản trị - Báo cáo & Phân tích',
            'summary' => $summary,
            'topProducts' => $topProducts
        ]);
    }

    public function customers() {
        $userModel = new UserModel();
        $customers = $userModel->getAllUsersWithOrderCount();

        View::render('admin/customers', [
            'title' => 'Quản trị - Quản lý Khách hàng',
            'customers' => $customers
        ]);
    }

    public function reviews() {
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->getAllReviewsForAdmin();

        View::render('admin/reviews', [
            'title' => 'Quản trị - Quản lý Đánh giá',
            'reviews' => $reviews
        ]);
    }

    public function deleteReview($id) {
        if ($id) {
            $reviewModel = new ReviewModel();
            if ($reviewModel->deleteReview($id)) {
                echo "<script>alert('Xóa đánh giá thành công!'); window.location.href='/admin/reviews';</script>";
            } else {
                echo "<script>alert('Không thể xóa đánh giá này!'); history.back();</script>";
            }
        }
    }

    // --- QUẢN LÝ MÃ GIẢM GIÁ (VOUCHERS) ---

    public function vouchers() {
        $voucherModel = new VoucherModel();
        $vouchers = $voucherModel->getAllVouchers();

        View::render('admin/vouchers', [
            'title' => 'Quản trị - Quản lý Mã giảm giá',
            'vouchers' => $vouchers
        ]);
    }

    public function createVoucher() {
        View::render('admin/voucher_add', [
            'title' => 'Thêm mã giảm giá mới'
        ]);
    }

    public function storeVoucher() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = strtoupper(trim($_POST['code']));
            $discountPercent = (int)$_POST['discount_percent'];
            $discountAmount = (float)$_POST['discount_amount'];
            $minOrderValue = (float)$_POST['min_order_value'];
            $expiryDate = $_POST['expiry_date'];

            $voucherModel = new VoucherModel();
            if ($voucherModel->addVoucher($code, $discountPercent, $discountAmount, $minOrderValue, $expiryDate)) {
                echo "<script>alert('Thêm mã giảm giá thành công!'); window.location.href='/admin/vouchers';</script>";
            } else {
                echo "<script>alert('Lỗi: Mã giảm giá có thể bị trùng!'); history.back();</script>";
            }
        }
    }

    public function deleteVoucher($id) {
        if ($id) {
            $voucherModel = new VoucherModel();
            if ($voucherModel->deleteVoucher($id)) {
                echo "<script>alert('Xóa mã giảm giá thành công!'); window.location.href='/admin/vouchers';</script>";
            } else {
                echo "<script>alert('Không thể xóa mã này!'); history.back();</script>";
            }
        }
    }
}