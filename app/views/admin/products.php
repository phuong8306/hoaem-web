<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; font-size: 14px; }
        th { background-color: #2c3e50; color: white; }
        .badge-active { background: #27ae60; color: white; padding: 4px 8px; border-radius: 4px; }
        .badge-hidden { background: #e74c3c; color: white; padding: 4px 8px; border-radius: 4px; }
        .btn-delete { background: #e74c3c; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; }
        .nav-admin { margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .nav-admin div a { margin-right: 15px; text-decoration: none; font-weight: bold; color: #3498db; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif;">
    <a href="/" style="text-decoration: none; color: #3498db;">&larr; Về trang chủ cửa hàng</a>
    <h2 style="color: #2c3e50;">Quản Lý Sản Phẩm (Catalog Management)</h2>

    <!-- ĐOẠN MÃ BỔ SUNG NẰM Ở ĐÂY (Ngay trên bảng hiển thị) -->
    <div class="nav-admin">
        <div>
            <a href="/admin/orders">&larr; Quản lý Đơn hàng</a>
            <a href="/admin/products" style="color: #2c3e50;">Quản lý Sản phẩm</a>
        </div>
        <a href="/admin/createProduct" style="background: #27ae60; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none;">+ Thêm sản phẩm mới</a>
    </div>

    <?php if (!empty($products)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><strong>#<?= $p['id'] ?></strong></td>
                    <td style="text-align: left;"><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['category_name'] ?? 'Chưa phân loại') ?></td>
                    <td>
                        <?php if ($p['status'] == 'active'): ?>
                            <span class="badge-active">Đang hiển thị</span>
                        <?php else: ?>
                            <span class="badge-hidden">Đang ẩn</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/admin/deleteProduct/<?= $p['id'] ?>" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #7f8c8d; margin-top: 20px;">Chưa có sản phẩm nào trong hệ thống.</p>
    <?php endif; ?>
</body>
</html>