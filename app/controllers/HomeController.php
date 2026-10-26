<?php
require_once __DIR__ . '/../models/ProductModel.php';

class HomeController {
    public function index() {
        $productModel = new ProductModel();
        $categories = $productModel->getCategories();

        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

        if ($categoryId) {
            $products = $productModel->getProductsByCategoryId($categoryId);
            // Lấy tên danh mục đang chọn để hiển thị tiêu đề
            $selectedCatName = '';
            foreach ($categories as $c) {
                if ($c['id'] == $categoryId) {
                    $selectedCatName = $c['name'];
                    break;
                }
            }
            $message = 'Danh mục: ' . $selectedCatName;
        } else {
            $products = $productModel->getAllProductsForHome();
            $message = 'Danh sách sản phẩm hoa tươi nổi bật';
        }

        View::render('home/index', [
            'title' => 'Trang chủ - Cửa hàng Hoa Tươi',
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $categoryId,
            'message' => $message
        ]);
    }
}