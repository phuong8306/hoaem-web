<?php
require_once '../app/models/ProductModel.php';

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

        $data = [
            'title' => $product['name'],
            'product' => $product,
            'variants' => $variants
        ];

        View::render('product/detail', $data);
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
            'totalPages' => 1 // Đảm bảo truyền biến này để tránh lỗi Undefined variable
        ];

        View::render('home/index', $data);
    }
}