<?php
class ProductModel extends Database {

    // Lấy danh sách sản phẩm hiển thị trên trang chủ
public function getAllProductsForHome() {
        $sql = "SELECT p.id, p.name, p.slug, p.image, p.description, 
                       COALESCE(v.price, 0) AS min_price, 
                       v.stock_quantity, c.name AS category_name 
                FROM products p 
                LEFT JOIN product_variants v ON p.id = v.product_id AND v.is_default = 1
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.status = 'active'
                ORDER BY p.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy toàn bộ danh mục sản phẩm
    public function getCategories() {
        $stmt = $this->pdo->prepare("SELECT * FROM categories");
        $stmt->execute();
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

    // Lấy sản phẩm có phân trang và hỗ trợ lọc theo danh mục
    public function getPaginatedProducts($limit, $offset, $categoryId = null) {
        if ($categoryId) {
            $sql = "SELECT p.id, p.name, p.slug, v.price, v.stock_quantity 
                    FROM products p 
                    LEFT JOIN product_variants v ON p.id = v.product_id AND v.is_default = 1
                    WHERE p.status = 'active' AND p.category_id = ?
                    LIMIT ? OFFSET ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $sql = "SELECT p.id, p.name, p.slug, v.price, v.stock_quantity 
                    FROM products p 
                    LEFT JOIN product_variants v ON p.id = v.product_id AND v.is_default = 1
                    WHERE p.status = 'active'
                    LIMIT ? OFFSET ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Đếm tổng số sản phẩm active (có tính điều kiện danh mục)
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

    public function getVariantsByProductId($productId) {
        $stmt = $this->pdo->prepare("SELECT * FROM product_variants WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
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
        $sql = "SELECT p.id, p.name, p.slug, v.price, v.stock_quantity 
                FROM products p 
                LEFT JOIN product_variants v ON p.id = v.product_id AND v.is_default = 1
                WHERE p.status = 'active' AND p.name LIKE ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['%' . $keyword . '%']);
        return $stmt->fetchAll();
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

    public function addProduct($categoryId, $name, $slug, $description, $price, $stock, $size, $color, $sku) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO products (category_id, name, slug, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$categoryId, $name, $slug, $description]);
            $productId = $this->pdo->lastInsertId();

            $stmtVar = $this->pdo->prepare("INSERT INTO product_variants (product_id, sku, size, color, price, stock_quantity, is_default) VALUES (?, ?, ?, ?, ?, ?, 1)");
            $stmtVar->execute([$productId, $sku, $size, $color, $price, $stock]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
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