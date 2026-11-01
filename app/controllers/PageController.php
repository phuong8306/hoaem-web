public function products() {
    require_once __DIR__ . '/../models/ProductModel.php';
    require_once __DIR__ . '/../models/OccasionModel.php'; // 👈 Gọi model Occasion
    
    $productModel = new ProductModel();
    $occasionModel = new OccasionModel(); // 👈 Khởi tạo object
    
    $categories = $productModel->getCategories();
    $occasions = $occasionModel->getAllOccasions(); // 👈 Lấy dữ liệu 3 thẻ quà tặng

    $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : null;
    $occasionSlug = isset($_GET['occasion']) ? trim($_GET['occasion']) : null;

    if ($categoryId) {
        $products = $productModel->getProductsByCategoryId($categoryId);
        $message = 'Danh mục sản phẩm';
    } elseif ($keyword) {
        $products = $productModel->searchProducts($keyword);
        $message = 'Kết quả tìm kiếm cho: "' . htmlspecialchars($keyword) . '"';
    } else {
        $products = $productModel->getAllProductsForHome();
        $message = 'Danh sách sản phẩm hoa tươi nổi bật';
    }

    // Truyền đầy đủ biến $occasions sang View list.php
    View::render('product/list', [
        'title' => 'Sản Phẩm - HoaEm Boutique',
        'categories' => $categories,
        'products' => $products,
        'selectedCategory' => $categoryId,
        'message' => $message,
        'occasions' => $occasions // 👈 Truyền biến này sang để hiện 3 thẻ quà tặng
    ]);
}