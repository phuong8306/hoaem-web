<?php

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->pdo;
    }

    // 1. Lấy tất cả danh mục kèm số lượng thuộc tính VÀ số lượng sản phẩm liên kết
    public function getAllCategories() {
        $sql = "SELECT c.*, 
                       COUNT(DISTINCT ca.id) AS total_attributes,
                       COUNT(DISTINCT p.id) AS total_products
                FROM categories c 
                LEFT JOIN category_attributes ca ON c.id = ca.category_id 
                LEFT JOIN products p ON c.id = p.category_id
                GROUP BY c.id 
                ORDER BY c.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy thông tin 1 danh mục theo ID
    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Lấy danh sách các thuộc tính động của 1 danh mục (xử lý Decode JSON options)
    public function getAttributesByCategoryId($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM category_attributes WHERE category_id = ? ORDER BY id ASC");
        $stmt->execute([$categoryId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as &$row) {
            if (!empty($row['options'])) {
                $row['options'] = json_decode($row['options'], true) ?: [];
            } else {
                $row['options'] = [];
            }
        }
        return $results;
    }

    // 4. Lưu / Cập nhật danh sách thuộc tính động (Dành cho AJAX Modal)
    public function saveAttributes($categoryId, $attributes = []) {
        try {
            $this->db->beginTransaction();

            // Xóa toàn bộ thuộc tính cũ của danh mục này để ghi đè danh sách mới
            $stmtDel = $this->db->prepare("DELETE FROM category_attributes WHERE category_id = ?");
            $stmtDel->execute([$categoryId]);

            // Thêm danh sách thuộc tính mới
            if (!empty($attributes) && is_array($attributes)) {
                $sql = "INSERT INTO category_attributes (category_id, attribute_name, data_type, is_required, options) 
                        VALUES (:cat_id, :name, :type, :req, :opts)";
                $stmtIns = $this->db->prepare($sql);

                foreach ($attributes as $attr) {
                    $attrName = trim($attr['name'] ?? '');
                    if (empty($attrName)) continue;

                    $dataType   = $attr['type'] ?? 'string';
                    $isRequired = !empty($attr['is_required']) ? 1 : 0;
                    $options    = (!empty($attr['options']) && is_array($attr['options'])) 
                                  ? json_encode($attr['options'], JSON_UNESCAPED_UNICODE) 
                                  : null;

                    $stmtIns->execute([
                        ':cat_id' => $categoryId,
                        ':name'   => $attrName,
                        ':type'   => $dataType,
                        ':req'    => $isRequired,
                        ':opts'   => $options
                    ]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // 5. Thêm danh mục mới
    public function createCategoryWithAttributes($name, $attributes = []) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->execute([$name]);
            $categoryId = $this->db->lastInsertId();

            if (!empty($attributes)) {
                $this->saveAttributes($categoryId, $attributes);
            }

            $this->db->commit();
            return $categoryId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // 6. Kiểm tra số lượng sản phẩm liên kết trước khi xóa
    public function getProductCountByCategoryId($id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn();
    }

    // 7. Xóa danh mục (An toàn: Kiểm tra nếu có sản phẩm thì từ chối)
    public function deleteCategory($id) {
        if ($this->getProductCountByCategoryId($id) > 0) {
            return false; // Không cho xóa nếu đang chứa sản phẩm
        }

        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}