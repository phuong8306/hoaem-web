<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        .form-container { max-width: 600px; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fff; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .row { display: flex; gap: 15px; }
        .col { flex: 1; }
        .btn-submit { background: #27ae60; color: white; padding: 12px 20px; border: none; width: 100%; font-size: 16px; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif; background: #f8f9fa;">
    <div class="form-container">
        <a href="/admin/products" style="text-decoration: none; color: #3498db;">&larr; Quay lại danh sách sản phẩm</a>
        <h2 style="color: #2c3e50; text-align: center;">Thêm Sản Phẩm Mới</h2>

        <form method="POST" action="/admin/storeProduct">
            <div class="form-group">
                <label>Tên sản phẩm:</label>
                <input type="text" name="name" required placeholder="Ví dụ: Bó Hoa Hướng Dương Tươi">
            </div>

            <div class="form-group">
                <label>Đường dẫn Slug (Dùng cho URL):</label>
                <input type="text" name="slug" required placeholder="bo-hoa-huong-duong-tuoi">
            </div>

            <div class="form-group">
                <label>Danh mục:</label>
                <select name="category_id" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col form-group">
                    <label>Mã SKU biến thể:</label>
                    <input type="text" name="sku" required placeholder="HD-V1">
                </div>
                <div class="col form-group">
                    <label>Kích thước (Size):</label>
                    <input type="text" name="size" required placeholder="M hoặc L">
                </div>
            </div>

            <div class="row">
                <div class="col form-group">
                    <label>Màu sắc:</label>
                    <input type="text" name="color" required placeholder="Vàng">
                </div>
                <div class="col form-group">
                    <label>Giá bán (VNĐ):</label>
                    <input type="number" name="price" required placeholder="450000">
                </div>
            </div>

            <div class="form-group">
                <label>Số lượng tồn kho ban đầu:</label>
                <input type="number" name="stock" value="10" min="0" required>
            </div>

            <div class="form-group">
                <label>Mô tả chi tiết:</label>
                <textarea name="description" rows="4" placeholder="Nhập mô tả chi tiết về sản phẩm..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Lưu Sản Phẩm</button>
        </form>
    </div>
</body>
</html>