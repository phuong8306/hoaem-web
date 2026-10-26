<?php
require_once '../app/models/OrderModel.php';
require_once '../app/models/ProductModel.php';
require_once '../app/models/UserModel.php';

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
}