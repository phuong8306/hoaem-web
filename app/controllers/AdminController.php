<?php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ReviewModel.php';
require_once __DIR__ . '/../models/VoucherModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/ContactModel.php';

class AdminController {
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
            $name = trim($_POST['name'] ?? '');
            $categoryId = $_POST['category_id'] ?? null;
            $description = trim($_POST['description'] ?? '');

            if (empty($name) || empty($categoryId)) {
                echo "<script>alert('Vui lòng điền tên sản phẩm và chọn danh mục!'); history.back();</script>";
                exit();
            }

            if (!isset($_POST['variants']) || empty($_POST['variants']) || !is_array($_POST['variants'])) {
                echo "<script>alert('Sản phẩm bắt buộc phải có ít nhất 1 phiên bản!'); history.back();</script>";
                exit();
            }

            // Tạo Slug chuẩn SEO
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
            $slug = trim($slug, '-') . '-' . time();

            // Xử lý Upload Ảnh đại diện chính
            $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assets/img/products/';
                if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $newFileName = 'prod_' . time() . '_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newFileName)) {
                    $imagePath = '/assets/img/products/' . $newFileName;
                }
            } else {
                echo "<script>alert('Ảnh đại diện chung là bắt buộc khi tạo sản phẩm mới!'); history.back();</script>";
                exit();
            }

            $db = (new Database())->pdo;
            try {
                $db->beginTransaction();

                // 1. Lưu Sản phẩm chính
                $stmt = $db->prepare("INSERT INTO products (category_id, name, slug, description, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$categoryId, $name, $slug, $description, $imagePath]);
                $productId = $db->lastInsertId();

                // 2. Lưu các Thuộc tính động chung (để hiển thị ở trang Chi tiết Detail)
                if (isset($_POST['attrs']) && is_array($_POST['attrs'])) {
                    $stmtAttr = $db->prepare("INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES (?, ?, ?)");
                    foreach ($_POST['attrs'] as $aName => $aVal) {
                        $cleanVal = trim($aVal);
                        if ($cleanVal !== '') {
                            $stmtAttr->execute([$productId, $aName, $cleanVal]);
                        }
                    }
                }

                // 3. Lưu Biến thể (Variants) & Kiểm tra trùng lặp linh hoạt
                $combos = [];
                $isFirst = true;
                $stmtVar = $db->prepare("INSERT INTO product_variants (product_id, sku, size, color, price, stock_quantity, is_default, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

                foreach ($_POST['variants'] as $key => $varData) {
                    $vSize = trim($varData['size'] ?? 'Tiêu chuẩn');
                    
                    // Tổng hợp thuộc tính động riêng từng phiên bản (nếu có)
                    $attrParts = [];
                    if (isset($varData['attrs']) && is_array($varData['attrs'])) {
                        foreach ($varData['attrs'] as $aName => $aVal) {
                            $cleanVal = trim($aVal);
                            if ($cleanVal !== '') {
                                $attrParts[] = $aName . ':' . $cleanVal;
                            }
                        }
                    }
                    $vColor = !empty($attrParts) ? implode(' - ', $attrParts) : 'Mặc định';

                    // Xử lý Upload Ảnh riêng cho từng phiên bản
                    $vImagePath = null;
                    $hasUniqueImage = false;
                    if (isset($_FILES['variant_images']['error'][$key]) && $_FILES['variant_images']['error'][$key] === UPLOAD_ERR_OK) {
                        $vDir = __DIR__ . '/../../public/assets/img/variants/';
                        if (!is_dir($vDir)) { mkdir($vDir, 0755, true); }
                        $vExt = strtolower(pathinfo($_FILES['variant_images']['name'][$key], PATHINFO_EXTENSION));
                        $vName = 'var_' . $productId . '_' . time() . '_' . rand(100, 999) . '.' . $vExt;
                        if (move_uploaded_file($_FILES['variant_images']['tmp_name'][$key], $vDir . $vName)) {
                            $vImagePath = '/assets/img/variants/' . $vName;
                            $hasUniqueImage = true;
                        }
                    }

                    // Khóa kiểm tra trùng lặp
                    $comboKey = mb_strtolower($vSize . '_' . $vColor, 'UTF-8');
                    if ($hasUniqueImage) {
                        $comboKey .= '_img_' . $_FILES['variant_images']['name'][$key];
                    }

                    if (in_array($comboKey, $combos)) {
                        throw new Exception('Phát hiện các phiên bản trùng lặp tổ hợp thuộc tính!');
                    }
                    $combos[] = $comboKey;

                    $vPrice = (float)($varData['price'] ?? 0);
                    $vStock = (int)($varData['stock'] ?? 0);
                    if ($vPrice <= 0 || $vStock < 0) {
                        throw new Exception('Giá phiên bản phải lớn hơn 0 và tồn kho không được âm!');
                    }

                    $sku = 'SKU-' . time() . '-' . rand(100, 999);
                    $isDefault = $isFirst ? 1 : 0;

                    $stmtVar->execute([$productId, $sku, $vSize, $vColor, $vPrice, $vStock, $isDefault, $vImagePath]);
                    $isFirst = false;
                }

                $db->commit();
                echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href='/admin/products';</script>";
            } catch (Exception $e) {
                $db->rollBack();
                echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); history.back();</script>";
            }
        }
    }

    public function editProduct($id) {
        $productModel = new ProductModel();
        $product = $productModel->getProductById($id);

        if (!$product) {
            echo "<script>alert('Sản phẩm không tồn tại!'); window.location.href='/admin/products';</script>";
            exit();
        }

        $variants = $productModel->getVariantsByProductId($id);

        $db = (new Database())->pdo;
        $stmtAttr = $db->prepare("SELECT * FROM product_attributes WHERE product_id = ?");
        $stmtAttr->execute([$id]);
        $productAttributes = $stmtAttr->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $db->query("SELECT * FROM categories");
        $categories = $stmt->fetchAll();

        View::render('admin/product_edit', [
            'title' => 'Chỉnh sửa sản phẩm',
            'product' => $product,
            'variants' => $variants,
            'categories' => $categories,
            'productAttributes' => $productAttributes
        ]);
    }

    public function updateProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name'] ?? '');
            $categoryId = $_POST['category_id'] ?? null;
            $description = trim($_POST['description'] ?? '');

            if (!isset($_POST['variants']) || empty($_POST['variants']) || !is_array($_POST['variants'])) {
                echo "<script>alert('Sản phẩm bắt buộc phải có ít nhất 1 phiên bản!'); history.back();</script>";
                exit();
            }

            $productModel = new ProductModel();
            $product = $productModel->getProductById($id);
            $imagePath = $product['image'] ?? '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assets/img/products/';
                if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $newFileName = 'prod_' . time() . '_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newFileName)) {
                    $imagePath = '/assets/img/products/' . $newFileName;
                }
            }

            $db = (new Database())->pdo;
            try {
                $db->beginTransaction();

                // 1. Cập nhật Thông tin chính
                $stmt = $db->prepare("UPDATE products SET category_id = ?, name = ?, description = ?, image = ? WHERE id = ?");
                $stmt->execute([$categoryId, $name, $description, $imagePath, $id]);

                // 2. Cập nhật Thuộc tính động chung
                $db->prepare("DELETE FROM product_attributes WHERE product_id = ?")->execute([$id]);
                if (isset($_POST['attrs']) && is_array($_POST['attrs'])) {
                    $stmtAttr = $db->prepare("INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES (?, ?, ?)");
                    foreach ($_POST['attrs'] as $aName => $aVal) {
                        $cleanVal = trim($aVal);
                        if ($cleanVal !== '') {
                            $stmtAttr->execute([$id, $aName, $cleanVal]);
                        }
                    }
                }

                // 3. Xử lý Cập nhật biến thể
                $combos = [];
                $submittedVarIds = [];
                foreach ($_POST['variants'] as $varId => $varData) {
                    $vSize = trim($varData['size'] ?? 'Tiêu chuẩn');
                    
                    $attrParts = [];
                    if (isset($varData['attrs']) && is_array($varData['attrs'])) {
                        foreach ($varData['attrs'] as $aName => $aVal) {
                            $cleanVal = trim($aVal);
                            if ($cleanVal !== '') {
                                $attrParts[] = $aName . ':' . $cleanVal;
                            }
                        }
                    }
                    $vColor = !empty($attrParts) ? implode(' - ', $attrParts) : 'Mặc định';

                    $vImagePath = null;
                    $hasUniqueImage = false;
                    if (isset($_FILES['variant_images']['error'][$varId]) && $_FILES['variant_images']['error'][$varId] === UPLOAD_ERR_OK) {
                        $vDir = __DIR__ . '/../../public/assets/img/variants/';
                        if (!is_dir($vDir)) { mkdir($vDir, 0755, true); }
                        $vExt = strtolower(pathinfo($_FILES['variant_images']['name'][$varId], PATHINFO_EXTENSION));
                        $vName = 'var_' . $id . '_' . time() . '_' . rand(100, 999) . '.' . $vExt;
                        if (move_uploaded_file($_FILES['variant_images']['tmp_name'][$varId], $vDir . $vName)) {
                            $vImagePath = '/assets/img/variants/' . $vName;
                            $hasUniqueImage = true;
                        }
                    }

                    $comboKey = mb_strtolower($vSize . '_' . $vColor, 'UTF-8');
                    if ($hasUniqueImage) {
                        $comboKey .= '_img_' . $_FILES['variant_images']['name'][$varId];
                    }

                    if (in_array($comboKey, $combos)) {
                        throw new Exception('Phát hiện các phiên bản trùng lặp tổ hợp thuộc tính!');
                    }
                    $combos[] = $comboKey;

                    $vPrice = (float)($varData['price'] ?? 0);
                    $vStock = (int)($varData['stock'] ?? 0);
                    if ($vPrice <= 0 || $vStock < 0) {
                        throw new Exception('Giá phiên bản phải lớn hơn 0 và tồn kho không được âm!');
                    }

                    if (strpos((string)$varId, 'new') !== false) {
                        $sku = 'SKU-' . time() . '-' . rand(100, 999);
                        $stmtNewVar = $db->prepare("INSERT INTO product_variants (product_id, sku, size, color, price, stock_quantity, is_default, image) VALUES (?, ?, ?, ?, ?, ?, 0, ?)");
                        $stmtNewVar->execute([$id, $sku, $vSize, $vColor, $vPrice, $vStock, $vImagePath]);
                        $submittedVarIds[] = $db->lastInsertId();
                    } else {
                        $submittedVarIds[] = (int)$varId;
                        if ($vImagePath) {
                            $stmtVar = $db->prepare("UPDATE product_variants SET price = ?, stock_quantity = ?, size = ?, color = ?, image = ? WHERE id = ? AND product_id = ?");
                            $stmtVar->execute([$vPrice, $vStock, $vSize, $vColor, $vImagePath, $varId, $id]);
                        } else {
                            $stmtVar = $db->prepare("UPDATE product_variants SET price = ?, stock_quantity = ?, size = ?, color = ? WHERE id = ? AND product_id = ?");
                            $stmtVar->execute([$vPrice, $vStock, $vSize, $vColor, $varId, $id]);
                        }
                    }
                }

                if (!empty($submittedVarIds)) {
                    $inClause = implode(',', array_fill(0, count($submittedVarIds), '?'));
                    $stmtDelVar = $db->prepare("DELETE FROM product_variants WHERE product_id = ? AND id NOT IN ($inClause)");
                    $stmtDelVar->execute(array_merge([$id], $submittedVarIds));
                }

                $db->commit();
                echo "<script>alert('Cập nhật sản phẩm thành công!'); window.location.href='/admin/products';</script>";
            } catch (Exception $e) {
                $db->rollBack();
                echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); history.back();</script>";
            }
        }
    }

    public function messages() {
        $contactModel = new ContactModel();
        $messages = $contactModel->getAllMessages();
        View::render('admin/messages', ['title' => 'Quản lý tin nhắn khách hàng', 'messages' => $messages]);
    }

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
        View::render('admin/inventory', ['title' => 'Quản trị - Quản lý Tồn kho', 'variants' => $variants]);
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
        View::render('admin/analytics', ['title' => 'Quản trị - Báo cáo & Phân tích', 'summary' => $summary, 'topProducts' => $topProducts]);
    }

    public function customers() {
        $userModel = new UserModel();
        $customers = $userModel->getAllUsersWithOrderCount();
        View::render('admin/customers', ['title' => 'Quản trị - Khách hàng', 'customers' => $customers]);
    }

    public function reviews() {
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->getAllReviewsForAdmin();
        View::render('admin/reviews', ['title' => 'Quản trị - Đánh giá', 'reviews' => $reviews]);
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

    public function categories() {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        View::render('admin/categories', ['title' => 'Quản trị - Danh mục', 'categories' => $categories]);
    }

    public function categoryAdd() {
        View::render('admin/category_add', ['title' => 'Thêm danh mục mới']);
    }

    public function storeCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $attributes = $_POST['attributes'] ?? [];

            if (empty($name)) {
                echo "<script>alert('Vui lòng nhập tên danh mục!'); history.back();</script>";
                exit();
            }

            $categoryModel = new CategoryModel();
            $result = $categoryModel->createCategoryWithAttributes($name, $attributes);

            if ($result) {
                echo "<script>alert('Thêm danh mục và thuộc tính thành công!'); window.location.href='/admin/categories';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra!'); history.back();</script>";
            }
        }
    }

    public function editCategory($id) {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->getCategoryById($id);

        if (!$category) {
            echo "<script>alert('Danh mục không tồn tại!'); window.location.href='/admin/categories';</script>";
            exit();
        }

        $attributes = $categoryModel->getAttributesByCategoryId($id);

        View::render('admin/category_edit', [
            'title' => 'Chỉnh sửa danh mục',
            'category' => $category,
            'attributes' => $attributes
        ]);
    }

    public function updateCategory($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $attributes = $_POST['attributes'] ?? [];

            if (empty($name)) {
                echo "<script>alert('Tên danh mục không được để trống!'); history.back();</script>";
                exit();
            }

            $categoryModel = new CategoryModel();
            $success = $categoryModel->updateCategoryWithAttributes($id, $name, $attributes);

            if ($success) {
                echo "<script>alert('Cập nhật danh mục thành công!'); window.location.href='/admin/categories';</script>";
            } else {
                echo "<script>alert('Cập nhật thất bại!'); history.back();</script>";
            }
        }
    }

    public function deleteCategory($id) {
        if ($id) {
            $categoryModel = new CategoryModel();
            $productCount = $categoryModel->getProductCountByCategoryId($id);

            if ($productCount > 0) {
                echo "<script>alert('Không thể xóa! Danh mục này hiện đang có " . $productCount . " sản phẩm liên kết.'); window.location.href='/admin/categories';</script>";
                exit();
            }

            if ($categoryModel->deleteCategory($id)) {
                echo "<script>alert('Xóa danh mục thành công!'); window.location.href='/admin/categories';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra khi xóa danh mục!'); window.location.href='/admin/categories';</script>";
            }
        } else {
            header('Location: /admin/categories');
        }
        exit();
    }

    public function getCategoryAttributes($categoryId) {
        header('Content-Type: application/json; charset=utf-8');
        try {
            $categoryModel = new CategoryModel();
            $attributes = $categoryModel->getAttributesByCategoryId($categoryId);
            echo json_encode($attributes ?: []);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit();
    }

    public function saveCategoryAttributes($categoryId) {
        header('Content-Type: application/json; charset=utf-8');
        
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);

        if (!isset($data['attributes']) || !is_array($data['attributes'])) {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
            exit();
        }

        try {
            $categoryModel = new CategoryModel();
            $success = $categoryModel->saveAttributes($categoryId, $data['attributes']);

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Lưu thuộc tính thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi lưu dữ liệu vào CSDL!']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi máy chủ: ' . $e->getMessage()]);
        }
        exit();
    }

    public function vouchers() {
        $voucherModel = new VoucherModel();
        $vouchers = $voucherModel->getAllVouchers();
        View::render('admin/vouchers', ['title' => 'Quản trị - Mã giảm giá', 'vouchers' => $vouchers]);
    }

    public function createVoucher() {
        View::render('admin/voucher_add', ['title' => 'Thêm mã giảm giá mới']);
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