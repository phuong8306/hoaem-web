<?php
session_start();

// --- 0. TRANG TEST KẾT NỐI NHANH (KHÔNG BỊ LỖI 404) ---
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($requestUri === '/test_conn.php') {
    $host = 'hoaem-db';
    $port = '3306';
    $dbname = 'hoavaem'; // Đổi lại thành hoavaem
    $username = 'root';
    $password = 'root';
    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        die("<h2 style='color:green; text-align:center; margin-top:50px;'>🎉 KẾT NỐI CSDL THÀNH CÔNG RỰC RỠ!</h2><p style='text-align:center;'><a href='/'>Quay về trang chủ</a></p>");
    } catch (Exception $e) {
        die("<h2 style='color:red; text-align:center; margin-top:50px;'>❌ LỖI KẾT NỐI: " . $e->getMessage() . "</h2>");
    }
}

// --- 1. LỚP DATABASE & VIEW KẾT NỐI CHUẨN ---
if (!class_exists('Database')) {
    class Database {
        public $pdo;
        public function __construct() {
            $host = 'hoaem-db';
            $port = '3306';
            $dbname = 'hoavaem';
            $username = 'root';
            $password = 'root';
            
            try {
                $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
                $this->pdo = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("<h3 style='color:red; text-align:center; margin-top:50px;'>Lỗi kết nối CSDL: " . $e->getMessage() . "<br><br>Hãy chắc chắn container đang chạy và tên database là 'flower_shop'!</h3>");
            }
        }
    }
}

if (!class_exists('View')) {
    class View {
        public static function render($viewName, $data = []) {
            extract($data);
            $viewFile = __DIR__ . '/../app/views/' . $viewName . '.php';
            if (!file_exists($viewFile)) {
                $viewFile = __DIR__ . '/app/views/' . $viewName . '.php';
            }
            if (file_exists($viewFile)) {
                require_once $viewFile;
            } else {
                echo "<h3 style='color:red;'>Không tìm thấy tệp giao diện: views/{$viewName}.php</h3>";
            }
        }
    }
}

// --- 2. XÁC ĐỊNH ĐƯỜNG DẪN THƯ MỤC APP ---
$appPath = __DIR__ . '/../app/';
if (!is_dir($appPath)) {
    $appPath = __DIR__ . '/app/';
}

// --- BẢO VỆ KHU VỰC QUẢN TRỊ ADMIN ---
if (strpos($requestUri, '/admin') === 0) {
    // Nếu chưa đăng nhập hoặc tài khoản không phải là admin thì chặn lại
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "<script>alert('Bạn không có quyền truy cập khu vực quản trị!'); window.location.href='/auth/login';</script>";
        exit();
    }
}

// --- 3. ĐIỀU HƯỚNG ROUTING TOÀN DIỆN ---
if ($requestUri !== '/' && str_ends_with($requestUri, '/')) {
    $requestUri = rtrim($requestUri, '/');
}

// Trang chủ
if ($requestUri === '' || $requestUri === '/') {
    require_once $appPath . 'controllers/HomeController.php';
    (new HomeController())->index();
}
// Xác thực tài khoản
elseif ($requestUri === '/auth/login') {
    require_once $appPath . 'controllers/AuthController.php';
    (new AuthController())->login();
}
elseif ($requestUri === '/auth/register') {
    require_once $appPath . 'controllers/AuthController.php';
    (new AuthController())->register();
}
elseif ($requestUri === '/auth/logout') {
    require_once $appPath . 'controllers/AuthController.php';
    (new AuthController())->logout();
}
// Sản phẩm & Tìm kiếm & Đánh giá
elseif ($requestUri === '/product/search') {
    require_once $appPath . 'controllers/ProductController.php';
    (new ProductController())->search();
}
elseif (preg_match('#^/product/detail/(.+)$#', $requestUri, $matches)) {
    require_once $appPath . 'controllers/ProductController.php';
    (new ProductController())->detail($matches[1]);
}
elseif ($requestUri === '/product/storeReview') {
    require_once $appPath . 'controllers/ProductController.php';
    (new ProductController())->storeReview();
}
// Giỏ hàng, Cập nhật, Xóa, Voucher & Thanh toán (Checkout)
elseif ($requestUri === '/cart') {
    require_once $appPath . 'controllers/CartController.php';
    (new CartController())->index();
}
elseif ($requestUri === '/cart/add') {
    require_once $appPath . 'controllers/CartController.php';
    (new CartController())->add();
}
elseif ($requestUri === '/cart/update') {
    require_once $appPath . 'controllers/CartController.php';
    (new CartController())->update();
}
elseif (preg_match('#^/cart/remove/(\d+)$#', $requestUri, $matches)) {
    require_once $appPath . 'controllers/CartController.php';
    (new CartController())->remove($matches[1]);
}
elseif ($requestUri === '/cart/clear') {
    require_once $appPath . 'controllers/CartController.php';
    (new CartController())->clear();
}
elseif ($requestUri === '/cart/applyVoucher') {
    require_once $appPath . 'controllers/CartController.php';
    (new CartController())->applyVoucher();
}
elseif ($requestUri === '/cart/removeVoucher') {
    require_once $appPath . 'controllers/CartController.php';
    (new CartController())->removeVoucher();
}
elseif ($requestUri === '/cart/checkout') {
    require_once $appPath . 'controllers/CartController.php';
    (new CartController())->checkout();
}
elseif ($requestUri === '/cart/processCheckout') {
    require_once $appPath . 'controllers/CartController.php';
    (new CartController())->processCheckout();
}
// Tài khoản khách hàng & Lịch sử đơn hàng
elseif ($requestUri === '/account/orders') {
    require_once $appPath . 'controllers/AccountController.php';
    (new AccountController())->orders();
}
elseif (preg_match('#^/account/orderDetail/(\d+)$#', $requestUri, $matches)) {
    require_once $appPath . 'controllers/AccountController.php';
    (new AccountController())->orderDetail($matches[1]);
}
// Quản trị Admin - Đơn hàng
elseif ($requestUri === '/admin/orders') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->orders();
}
elseif ($requestUri === '/admin/updateStatus') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->updateStatus();
}
// Quản trị Admin - Sản phẩm
elseif ($requestUri === '/admin/products') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->products();
}
elseif ($requestUri === '/admin/createProduct') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->createProduct();
}
elseif ($requestUri === '/admin/storeProduct') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->storeProduct();
}
elseif (preg_match('#^/admin/deleteProduct/(\d+)$#', $requestUri, $matches)) {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->deleteProduct($matches[1]);
}
// Quản trị Admin - Tồn kho
elseif ($requestUri === '/admin/inventory') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->inventory();
}
elseif ($requestUri === '/admin/updateStock') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->updateStock();
}
// Quản trị Admin - Báo cáo & Khách hàng
elseif ($requestUri === '/admin/analytics') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->analytics();
}
elseif ($requestUri === '/admin/customers') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->customers();
}
// Quản trị Admin - Đánh giá
elseif ($requestUri === '/admin/reviews') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->reviews();
}
elseif (preg_match('#^/admin/deleteReview/(\d+)$#', $requestUri, $matches)) {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->deleteReview($matches[1]);
}
// Quản trị Admin - Voucher
elseif ($requestUri === '/admin/vouchers') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->vouchers();
}
elseif ($requestUri === '/admin/createVoucher') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->createVoucher();
}
elseif ($requestUri === '/admin/storeVoucher') {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->storeVoucher();
}
elseif (preg_match('#^/admin/deleteVoucher/(\d+)$#', $requestUri, $matches)) {
    require_once $appPath . 'controllers/AdminController.php';
    (new AdminController())->deleteVoucher($matches[1]);
}
// Lỗi 404
else {
    http_response_code(404);
    echo "<h2 style='text-align:center; margin-top:50px; color:#e74c3c;'>404 - Không tìm thấy trang yêu cầu!</h2>";
    echo "<p style='text-align:center;'><a href='/'>Quay về trang chủ</a></p>";
}