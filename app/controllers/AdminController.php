<?php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ReviewModel.php';
require_once __DIR__ . '/../models/VoucherModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/ContactModel.php';

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
            
            // Tự động sinh slug thông minh và chống trùng lặp 100%
            $slug = strtolower(trim($_POST['slug'] ?? ''));
            if (empty($slug)) {
                $slug = mb_strtolower($name, 'UTF-8');
                $slug = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $slug);
                $slug = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $slug);
                $slug = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $slug);
                $slug = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $slug);
                $slug = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $slug);
                $slug = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $slug);
                $slug = preg_replace('/(đ)/', 'd', $slug);
                $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
                $slug = preg_replace('/([\s]+)/', '-', $slug);
                $slug = trim($slug, '-');
                $slug = $slug . '-' . time();
            }

            $category_id = $_POST['category_id'];
            $description = trim($_POST['description'] ?? '');
            $price = (float)$_POST['price'];
            $stock = (int)($_POST['stock'] ?? 10);
            $size = trim($_POST['size'] ?? 'Mặc định');
            $color = trim($_POST['color'] ?? 'Mặc định');
            $sku = trim($_POST['sku'] ?? 'SKU-' . time());

            // --- XỬ LÝ UPLOAD ẢNH TỪ MÁY TÍNH ---
            $imagePath = ''; 
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assets/img/products/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $newFileName = 'prod_' . time() . '_' . uniqid() . '.' . $fileExtension;
                $targetFile = $uploadDir . $newFileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = '/assets/img/products/' . $newFileName;
                }
            }

            $productModel = new ProductModel();
            
            if ($productModel->addProduct($category_id, $name, $slug, $description, $price, $stock, $size, $color, $sku, $imagePath)) {
                echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href='/admin/products';</script>";
            } else {
                echo "<script>alert('Lỗi hệ thống khi lưu vào cơ sở dữ liệu!'); history.back();</script>";
            }
        }
    }
    
    // Hiển thị danh sách tin nhắn khách hàng
    public function messages() {
        $contactModel = new ContactModel();
        $messages = $contactModel->getAllMessages();

        View::render('admin/messages', [
            'title' => 'Quản lý tin nhắn khách hàng - Admin',
            'messages' => $messages
        ]);
    }

    // Xóa tin nhắn
    public function deleteMessage($id) {
        $contactModel = new ContactModel();
        if ($contactModel->deleteMessage($id)) {
            echo "<script>alert('Xóa tin nhắn thành công!'); window.location.href='/admin/messages';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra!'); history.back();</script>";
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

    // --- QUẢN LÝ DANH MỤC (CATEGORIES) ---
    public function categories() {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        View::render('admin/categories', [
            'title' => 'Quản trị - Quản lý Danh mục',
            'categories' => $categories
        ]);
    }

    public function categoryAdd() {
        View::render('admin/category_add', [
            'title' => 'Thêm danh mục mới'
        ]);
    }

    public function storeCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            if (!empty($name)) {
                $categoryModel = new CategoryModel();
                $categoryModel->addCategory($name);
            }
        }
        header('Location: /admin/categories');
        exit;
    }

    public function deleteCategory($id) {
        if ($id) {
            $categoryModel = new CategoryModel();
            $categoryModel->deleteCategory($id);
        }
        header('Location: /admin/categories');
        exit;
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
            $discountPercent = (int)($_POST['discount_percent'] ?? 0);
            $discountAmount = (float)($_POST['discount_amount'] ?? 0);
            $minOrderValue = (float)($_POST['min_order_value'] ?? 0);
            $expiryDate = $_POST['expiry_date'] ?? null;

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