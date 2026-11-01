<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/OccasionModel.php';

class HomeController {
    public function index() {
        $productModel = new ProductModel();
        $occasionModel = new OccasionModel();
        
        $categories = $productModel->getCategories();
        $occasions = $occasionModel->getAllOccasions();

        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

        if ($categoryId) {
            $products = $productModel->getProductsByCategoryId($categoryId);
            $selectedCatName = '';
            foreach ($categories as $c) {
                if ($c['id'] == $categoryId) {
                    $selectedCatName = $c['name'];
                    break;
                }
            }
            $message = 'Danh mục: ' . $selectedCatName;
        } else {
            // LẤY 4 SẢN PHẨM ĐƯỢC QUAN TÂM/THÊM VÀO GIỎ HÀNG NHIỀU NHẤT CHO TRANG CHỦ
            if (method_exists($productModel, 'getTopProducts')) {
                $products = $productModel->getTopProducts(4);
            } else {
                $products = $productModel->getAllProductsForHome(); // Fallback nếu chưa có hàm
            }
            $message = 'Sản phẩm được quan tâm nhiều nhất';
        }

        View::render('home/index', [
            'title' => 'HoaEm - Tiệm Hoa Tươi Trực Tuyến',
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $categoryId,
            'message' => $message,
            'occasions' => $occasions
        ]);
    }

    // Trang Sản Phẩm (Nếu route /products đang trỏ về đây)
    public function products() {
        $productModel = new ProductModel();
        $occasionModel = new OccasionModel();
        
        $categories = $productModel->getCategories();
        $occasions = $occasionModel->getAllOccasions();

        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : null;

        if ($categoryId) {
            $products = $productModel->getProductsByCategoryId($categoryId);
            $message = 'Danh mục sản phẩm';
        } elseif ($keyword) {
            $products = $productModel->searchProducts($keyword);
            $message = 'Kết quả tìm kiếm cho: "' . htmlspecialchars($keyword) . '"';
        } else {
            // LẤY TẤT CẢ SẢN PHẨM SẮP XẾP MỚI NHẤT ĐẾN CŨ NHẤT CHO TRANG SẢN PHẨM
            if (method_exists($productModel, 'getAllProductsSortedByNewest')) {
                $products = $productModel->getAllProductsSortedByNewest();
            } else {
                $products = $productModel->getAllProductsForHome();
            }
            $message = 'Danh sách sản phẩm hoa tươi mới nhất';
        }

        View::render('product/list', [
            'title' => 'Sản Phẩm - HoaEm Boutique',
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $categoryId,
            'message' => $message,
            'occasions' => $occasions
        ]);
    }

    // Trang Giới Thiệu
    public function about() {
        View::render('about/index', [
            'title' => 'Giới Thiệu - HoaEm Boutique'
        ]);
    }

    // Trang Liên Hệ
    public function contact() {
        View::render('contact/index', [
            'title' => 'Liên Hệ - HoaEm Boutique'
        ]);
    }
}