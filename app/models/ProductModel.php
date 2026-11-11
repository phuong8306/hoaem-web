<?php
class ProductModel extends Database {

    public function getAllProductsForHome() {
        $sql = "SELECT p.id, p.name, p.slug, p.image, p.description, 
                       MIN(v.price) AS min_price, 
                       MAX(v.price) AS max_price, 
                       SUM(v.stock_quantity) AS stock_quantity, 
                       c.name AS category_name,
                       COALESCE(AVG(r.rating), 5) AS avg_rating,
                       COUNT(r.id) AS total_reviews
                FROM products p 
                LEFT JOIN product_variants v ON p.id = v.product_id 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN reviews r ON p.id = r.product_id
                WHERE p.status = 'active'
                GROUP BY p.id, p.name, p.slug, p.image, p.description, c.name
                ORDER BY p.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $stmt = $this->pdo->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Bổ sung hàm lấy sản phẩm theo danh mục để fix lỗi HomeController dòng 57
    public function getProductsByCategoryId($categoryId) {
        $sql = "SELECT p.id, p.name, p.slug, p.image, p.description, 
                       MIN(v.price) AS min_price, 
                       MAX(v.price) AS max_price, 
                       SUM(v.stock_quantity) AS stock_quantity, 
                       c.name AS category_name,
                       COALESCE(AVG(r.rating), 5) AS avg_rating,
                       COUNT(r.id) AS total_reviews
                FROM products p 
                LEFT JOIN product_variants v ON p.id = v.product_id 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN reviews r ON p.id = r.product_id
                WHERE p.status = 'active' AND p.category_id = ?
                GROUP BY p.id, p.name, p.slug, p.image, p.description, c.name
                ORDER BY p.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveProducts() {
        $sql = "SELECT p.id, p.name, p.slug, v.price, v.stock_quantity 
                FROM products p 
                LEFT JOIN product_variants v ON p.id = v.product_id AND v.is_default = 1
                WHERE p.status = 'active'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPaginatedProducts($limit, $offset, $categoryId = null) {
        if ($categoryId) {
            $sql = "SELECT p.id, p.name, p.slug, p.image, p.description, 
                            MIN(v.price) AS min_price, 
                            MAX(v.price) AS max_price, 
                            SUM(v.stock_quantity) AS stock_quantity, 
                            c.name AS category_name,
                            COALESCE(AVG(r.rating), 5) AS avg_rating,
                            COUNT(r.id) AS total_reviews
                    FROM products p 
                    LEFT JOIN product_variants v ON p.id = v.product_id 
                    LEFT JOIN categories c ON p.category_id = c.id
                    LEFT JOIN reviews r ON p.id = r.product_id
                    WHERE p.status = 'active' AND p.category_id = ?
                    GROUP BY p.id, p.name, p.slug, p.image, p.description, c.name
                    LIMIT ? OFFSET ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $sql = "SELECT p.id, p.name, p.slug, p.image, p.description, 
                            MIN(v.price) AS min_price, 
                            MAX(v.price) AS max_price, 
                            SUM(v.stock_quantity) AS stock_quantity, 
                            c.name AS category_name,
                            COALESCE(AVG(r.rating), 5) AS avg_rating,
                            COUNT(r.id) AS total_reviews
                    FROM products p 
                    LEFT JOIN product_variants v ON p.id = v.product_id 
                    LEFT JOIN categories c ON p.category_id = c.id
                    LEFT JOIN reviews r ON p.id = r.product_id
                    WHERE p.status = 'active'
                    GROUP BY p.id, p.name, p.slug, p.image, p.description, c.name
                    LIMIT ? OFFSET ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalActiveProducts($categoryId = null) {
        if ($categoryId) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE status = 'active' AND category_id = ?");
            $stmt->execute([$categoryId]);
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM products WHERE status = 'active'");
        }
        return $stmt->fetchColumn();
    }

    public function getProductBySlug($slug) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE slug = ? AND status = 'active'");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function getProductById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tự động lấy ảnh chính làm fallback từ DB nếu variant chưa có ảnh riêng
    public function getVariantsByProductId($productId) {
        $stmt = $this->pdo->prepare("
            SELECT v.*, 
                   COALESCE(NULLIF(v.image, ''), p.image) AS image 
            FROM product_variants v 
            JOIN products p ON v.product_id = p.id 
            WHERE v.product_id = ?
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVariantDetails($variantId) {
        $sql = "SELECT v.*, p.name AS product_name, p.slug 
                FROM product_variants v 
                JOIN products p ON v.product_id = p.id 
                WHERE v.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$variantId]);
        return $stmt->fetch();
    }

    public function searchProducts($keyword) {
        $sql = "SELECT p.id, p.name, p.slug, p.image, p.description, 
                       MIN(v.price) AS min_price, 
                       MAX(v.price) AS max_price, 
                       SUM(v.stock_quantity) AS stock_quantity, 
                       c.name AS category_name,
                       COALESCE(AVG(r.rating), 5) AS avg_rating,
                       COUNT(r.id) AS total_reviews
                FROM products p 
                LEFT JOIN product_variants v ON p.id = v.product_id 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN reviews r ON p.id = r.product_id
                WHERE p.status = 'active' AND p.name LIKE ?
                GROUP BY p.id, p.name, p.slug, p.image, p.description, c.name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProductsForAdmin() {
        $sql = "SELECT p.*, c.name AS category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteProduct($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function addProduct($categoryId, $name, $slug, $description, $price, $stock, $size, $color, $sku, $imagePath) {
        try {
            $this->pdo->beginTransaction();
            
            $stmt = $this->pdo->prepare("INSERT INTO products (category_id, name, slug, description, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$categoryId, $name, $slug, $description, $imagePath]);
            
            $productId = $this->pdo->lastInsertId();

            $stmtVar = $this->pdo->prepare("INSERT INTO product_variants (product_id, sku, size, color, price, stock_quantity, is_default, image) VALUES (?, ?, ?, ?, ?, ?, 1, ?)");
            $stmtVar->execute([$productId, $sku, $size, $color, $price, $stock, $imagePath]);
            
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "<pre style='background: black; color: #00ff00; padding: 15px; font-size: 16px;'>";
            print_r($e->getMessage());
            echo "</pre>";
            exit;
        }
    }

    public function getAllVariantsForInventory() {
        $sql = "SELECT v.*, p.name AS product_name 
                FROM product_variants v 
                JOIN products p ON v.product_id = p.id 
                ORDER BY v.stock_quantity ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStock($variantId, $newStock) {
        $stmt = $this->pdo->prepare("UPDATE product_variants SET stock_quantity = ? WHERE id = ?");
        return $stmt->execute([$newStock, $variantId]);
    }
}