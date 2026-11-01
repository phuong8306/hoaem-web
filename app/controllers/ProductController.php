<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/ReviewModel.php';
require_once __DIR__ . '/../models/OccasionModel.php';

class ProductController {
    
    // Trang danh sách sản phẩm chính (Dùng nếu route /products trỏ vào đây)
    public function index() {
        $productModel = new ProductModel();
        $occasionModel = new OccasionModel();
        
        $categories = $productModel->getCategories();
        $occasions = $occasionModel->getAllOccasions();

        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

        if ($categoryId) {
            $products = $productModel->getProductsByCategoryId($categoryId);
            $message = 'Danh mục sản phẩm';
        } else {
            // Sắp xếp mới nhất đến cũ nhất
            if (method_exists($productModel, 'getAllProductsSortedByNewest')) {
                $products = $productModel->getAllProductsSortedByNewest();
            } else {
                $products = $productModel->getAllProductsForHome();
            }
            $message = 'Danh sách sản phẩm hoa tươi mới nhất';
        }

        $data = [
            'title' => 'Sản Phẩm - HoaEm Boutique',
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $categoryId,
            'message' => $message,
            'occasions' => $occasions
        ];

        View::render('product/list', $data);
    }

    public function detail($slug = null) {
        if (!$slug) {
            echo "Lỗi: Không tìm thấy sản phẩm.";
            return;
        }

        $productModel = new ProductModel();
        $product = $productModel->getProductBySlug($slug);

        if (!$product) {
            echo "Sản phẩm không tồn tại hoặc đã ngừng kinh doanh.";
            return;
        }

        $variants = $productModel->getVariantsByProductId($product['id']);

        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->getReviewsByProductId($product['id']);

        $data = [
            'title' => $product['name'],
            'product' => $product,
            'variants' => $variants,
            'reviews' => $reviews
        ];

        View::render('product/detail', $data);
    }

    public function storeReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id'])) {
                echo "<script>alert('Vui lòng đăng nhập để gửi đánh giá!'); window.location.href='/auth/login';</script>";
                exit();
            }

            $productId = (int)$_POST['product_id'];
            $userId = $_SESSION['user_id'];
            $rating = (int)$_POST['rating'];
            $comment = trim($_POST['comment']);

            if ($rating < 1 || $rating > 5) {
                $rating = 5;
            }

            $reviewModel = new ReviewModel();
            if ($reviewModel->addReview($productId, $userId, $rating, $comment)) {
                echo "<script>alert('Gửi đánh giá thành công!'); history.back();</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!'); history.back();</script>";
            }
        }
    }

    public function search() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        $productModel = new ProductModel();
        $occasionModel = new OccasionModel();
        
        $categories = $productModel->getCategories();
        $occasions = $occasionModel->getAllOccasions();
        $products = $productModel->searchProducts($keyword);

        $data = [
            'title' => 'Tìm kiếm: ' . $keyword,
            'message' => 'Kết quả tìm kiếm cho: "' . htmlspecialchars($keyword) . '"',
            'categories' => $categories,
            'selectedCategory' => null,
            'products' => $products,
            'occasions' => $occasions
        ];

        // ĐÃ SỬA: Render về đúng product/list để giữ giao diện trang sản phẩm chuẩn xác
        View::render('product/list', $data);
    }
}