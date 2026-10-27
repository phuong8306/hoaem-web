<?php
require_once '../app/models/ProductModel.php';
require_once '../app/models/ReviewModel.php';

class ProductController {
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

        // Lấy danh sách đánh giá của sản phẩm
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

    // Xử lý lưu đánh giá sản phẩm
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

    // Xử lý tìm kiếm sản phẩm
    public function search() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        $productModel = new ProductModel();
        $categories = $productModel->getCategories();
        $products = $productModel->searchProducts($keyword);

        $data = [
            'title' => 'Tìm kiếm: ' . $keyword,
            'message' => 'Kết quả tìm kiếm cho: "' . htmlspecialchars($keyword) . '"',
            'categories' => $categories,
            'selectedCategory' => null,
            'products' => $products,
            'currentPage' => 1,
            'totalPages' => 1
        ];

        View::render('home/index', $data);
    }
}
