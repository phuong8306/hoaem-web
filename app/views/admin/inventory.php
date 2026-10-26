<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; font-size: 14px; }
        th { background-color: #2c3e50; color: white; }
        .badge-low { background: #e74c3c; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
        .badge-ok { background: #27ae60; color: white; padding: 4px 8px; border-radius: 4px; }
        .input-stock { width: 80px; padding: 6px; text-align: center; border: 1px solid #ccc; border-radius: 4px; }
        .btn-save { background: #3498db; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px; }
        .nav-admin { margin-bottom: 20px; }
        .menu-links a { margin-right: 15px; text-decoration: none; font-weight: bold; color: #3498db; }
        .menu-links a.active { color: #2c3e50; border-bottom: 2px solid #2c3e50; padding-bottom: 3px; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif;">
    <a href="/" style="text-decoration: none; color: #3498db;">&larr; Về trang chủ cửa hàng</a>
    <h2 style="color: #2c3e50;">Quản Lý Tồn Kho (Inventory Management)</h2>

    <div class="nav-admin menu-links">
        <a href="/admin/orders">Quản lý Đơn hàng</a>
        <a href="/admin/products">Quản lý Sản phẩm</a>
        <a href="/admin/inventory" class="active">Quản lý Tồn kho</a>
    </div>

    <?php if (!empty($variants)): ?>
        <table>
            <thead>
                <tr>
                    <th>Mã SKU</th>
                    <th>Tên sản phẩm</th>
                    <th>Phân loại (Size / Màu)</th>
                    <th>Giá bán</th>
                    <th>Tồn kho hiện tại</th>
                    <th>Trạng thái</th>
                    <th>Cập nhật kho</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($variants as $v): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($v['sku']) ?></strong></td>
                    <td style="text-align: left;"><?= htmlspecialchars($v['product_name']) ?></td>
                    <td><?= htmlspecialchars($v['color']) ?> - Size <?= htmlspecialchars($v['size']) ?></td>
                    <td><?= number_format($v['price'], 0, ',', '.') ?> đ</td>
                    <td>
                        <form method="POST" action="/admin/updateStock" style="display: flex; gap: 5px; justify-content: center; align-items: center;">
                            <input type="hidden" name="variant_id" value="<?= $v['id'] ?>">
                            <input type="number" name="stock_quantity" value="<?= $v['stock_quantity'] ?>" min="0" class="input-stock" required>
                    </td>
                    <td>
                        <?php if ($v['stock_quantity'] <= 5): ?>
                            <span class="badge-low">Sắp hết hàng!</span>
                        <?php else: ?>
                            <span class="badge-ok">Ổn định</span>
                        <?php endif; ?>
                    </td>
                    <td>
                            <button type="submit" class="btn-save">Lưu</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #7f8c8d; margin-top: 20px;">Không có biến thể sản phẩm nào trong hệ thống.</p>
    <?php endif; ?>
</body>
</html>