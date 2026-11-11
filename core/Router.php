<?php
class Router {
    public function dispatch() {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Trang test kết nối nhanh
        if ($requestUri === '/test_conn.php') {
            $this->handleTestConnection();
            return;
        }

        // Xác định đường dẫn thư mục app
        $appPath = __DIR__ . '/../app/';
        if (!is_dir($appPath)) {
            $appPath = __DIR__ . '/app/';
        }

        // Bảo vệ khu vực quản trị Admin
        if (strpos($requestUri, '/admin') === 0) {
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
                echo "<script>alert('Bạn không có quyền truy cập khu vực quản trị!'); window.location.href='/auth/login';</script>";
                exit();
            }
        }

        if ($requestUri !== '/' && str_ends_with($requestUri, '/')) {
            $requestUri = rtrim($requestUri, '/');
        }

        // --- ĐIỀU HƯỚNG ROUTING ---
        if ($requestUri === '' || $requestUri === '/') {
            require_once $appPath . 'controllers/HomeController.php';
            (new HomeController())->index();
        }
        elseif ($requestUri === '/products') {
            require_once $appPath . 'controllers/HomeController.php';
            (new HomeController())->products();
        }
        elseif ($requestUri === '/about') {
            require_once $appPath . 'controllers/HomeController.php';
            (new HomeController())->about();
        }
        elseif ($requestUri === '/contact') {
            require_once $appPath . 'controllers/HomeController.php';
            (new HomeController())->contact();
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
        // Giỏ hàng & Thanh toán & Voucher
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
        elseif (preg_match('#^/cart/remove/([a-zA-Z0-9_-]+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/CartController.php';
            (new CartController())->remove($matches[1]);
        }
        elseif ($requestUri === '/cart/clear') {
            require_once $appPath . 'controllers/CartController.php';
            (new CartController())->clear();
        }
        elseif ($requestUri === '/cart/applyVoucher' || $requestUri === '/cart/apply-voucher') {
            require_once $appPath . 'controllers/CartController.php';
            (new CartController())->applyVoucher();
        }
        elseif ($requestUri === '/cart/removeVoucher' || $requestUri === '/cart/remove-voucher') {
            require_once $appPath . 'controllers/CartController.php';
            (new CartController())->removeVoucher();
        }
        elseif ($requestUri === '/cart/checkout') {
            require_once $appPath . 'controllers/CartController.php';
            (new CartController())->checkout();
        }
        elseif ($requestUri === '/cart/processCheckout' || $requestUri === '/cart/process-checkout') {
            require_once $appPath . 'controllers/CartController.php';
            (new CartController())->processCheckout();
        }
        // Tài khoản khách hàng & Trang cá nhân
        elseif ($requestUri === '/account') {
            require_once $appPath . 'controllers/AccountController.php';
            (new AccountController())->profile();
        }
        elseif ($requestUri === '/account/updateProfile') {
            require_once $appPath . 'controllers/AccountController.php';
            (new AccountController())->updateProfile();
        }
        elseif ($requestUri === '/account/orders') {
            require_once $appPath . 'controllers/AccountController.php';
            (new AccountController())->orders();
        }
        elseif (preg_match('#^/account/orderDetail/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AccountController.php';
            (new AccountController())->orderDetail($matches[1]);
        }
        elseif ($requestUri === '/account/addAddress') {
            require_once $appPath . 'controllers/AccountController.php';
            (new AccountController())->addAddress();
        }
        elseif (preg_match('#^/account/editAddress/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AccountController.php';
            (new AccountController())->editAddress($matches[1]);
        }
        elseif ($requestUri === '/account/updateAddress') {
            require_once $appPath . 'controllers/AccountController.php';
            (new AccountController())->updateAddress();
        }
        elseif (preg_match('#^/account/deleteAddress/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AccountController.php';
            (new AccountController())->deleteAddress($matches[1]);
        }
        // Quản trị Admin
        elseif ($requestUri === '/admin' || $requestUri === '/admin/dashboard') {
            require_once $appPath . 'controllers/AdminController.php';
            $adminCtrl = new AdminController();
            if (method_exists($adminCtrl, 'dashboard')) {
                $adminCtrl->dashboard();
            } elseif (method_exists($adminCtrl, 'index')) {
                $adminCtrl->index();
            } else {
                $adminCtrl->orders();
            }
        }
        elseif ($requestUri === '/admin/orders') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->orders();
        }
        elseif ($requestUri === '/admin/updateStatus') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->updateStatus();
        }
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
        elseif (preg_match('#^/admin/editProduct/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->editProduct($matches[1]);
        }
        elseif (preg_match('#^/admin/updateProduct/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->updateProduct($matches[1]);
        }
        elseif (preg_match('#^/admin/deleteProduct/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->deleteProduct($matches[1]);
        }
        elseif ($requestUri === '/admin/inventory') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->inventory();
        }
        elseif ($requestUri === '/admin/updateStock') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->updateStock();
        }
        elseif ($requestUri === '/admin/analytics') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->analytics();
        }
        elseif ($requestUri === '/admin/customers') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->customers();
        }
        elseif ($requestUri === '/admin/reviews') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->reviews();
        }
        elseif (preg_match('#^/admin/deleteReview/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->deleteReview($matches[1]);
        }
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
        elseif ($requestUri === '/admin/categories') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->categories();
        }
        elseif ($requestUri === '/admin/categoryAdd' || $requestUri === '/admin/category/add') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->categoryAdd();
        }
        elseif ($requestUri === '/admin/storeCategory' || $requestUri === '/admin/category/store') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->storeCategory();
        }
        elseif (preg_match('#^/admin/editCategory/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->editCategory($matches[1]);
        }
        elseif (preg_match('#^/admin/updateCategory/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->updateCategory($matches[1]);
        }
        elseif (preg_match('#^/admin/deleteCategory/(\d+)$#', $requestUri, $matches) || preg_match('#^/admin/category/delete/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->deleteCategory($matches[1]);
        }

        // --- BỔ SUNG ROUTE API CHO THUỘC TÍNH ĐỘNG ---
        elseif (preg_match('#^/admin/getCategoryAttributes/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->getCategoryAttributes($matches[1]);
        }
        elseif (preg_match('#^/admin/saveCategoryAttributes/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->saveCategoryAttributes($matches[1]);
        }

        elseif ($requestUri === '/admin/messages') {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->messages();
        }
        elseif (preg_match('#^/admin/deleteMessage/(\d+)$#', $requestUri, $matches)) {
            require_once $appPath . 'controllers/AdminController.php';
            (new AdminController())->deleteMessage($matches[1]);
        }
        
        // Lỗi 404
        else {
            http_response_code(404);
            echo "<h2 style='text-align:center; margin-top:50px; color:#e74c3c;'>404 - Không tìm thấy trang yêu cầu!</h2>";
            echo "<p style='text-align:center;'><a href='/'>Quay về trang chủ</a></p>";
        }
    }

    private function handleTestConnection() {
        $host = 'hoaem-db';
        $port = '3306';
        $dbname = 'hoavaem';
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
}