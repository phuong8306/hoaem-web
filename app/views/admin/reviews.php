<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; font-size: 14px; }
        th { background-color: #2c3e50; color: white; }
        .nav-admin { margin-bottom: 20px; }
        .menu-links a { margin-right: 15px; text-decoration: none; font-weight: bold; color: #3498db; }
        .menu-links a.active { color: #2c3e50; border-bottom: 2px solid #2c3e50; padding-bottom: 3px; }
        .btn-delete { background: #e74c3c; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; }
        .rating-star { color: #f39c12; font-weight: bold; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif; background: #f8f9fa;">
    <a href="/" style="text-decoration: none; color: #3498db;">&larr; Về trang chủ cửa hàng</a>
    <h2 style="color: #2c3e50;">Quản Lý Đánh Giá Sản Phẩm (Review Moderation)</h2>

    <div class="nav-admin menu-links">
        <a href="/admin/orders">Quản lý Đơn hàng</a>
        <a href="/admin/products">Quản lý Sản phẩm</a>
        <a href="/admin/inventory">Quản lý Tồn kho</a>
        <a href="/admin/analytics">Báo cáo & Phân tích</a>
        <a href="/admin/customers">Quản lý Khách hàng</a>
        <a href="/admin/reviews" class="active">Quản lý Đánh giá</a>
        <a href="/admin/vouchers">Quản lý Voucher</a>
    </div>

    <?php if (!empty($reviews)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Khách hàng</th>
                    <th>Số sao</th>
                    <th>Nội dung nhận xét</th>
                    <th>Thời gian</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $rev): ?>
                <tr>
                    <td><strong>#<?= $rev['id'] ?></strong></td>
                    <td style="text-align: left; font-weight: bold;"><?= htmlspecialchars($rev['product_name']) ?></td>
                    <td><?= htmlspecialchars($rev['username']) ?></td>
                    <td>
                        <span class="rating-star">
                            <?php for($i = 0; $i < $rev['rating']; $i++) echo '⭐'; ?>
                        </span>
                    </td>
                    <td style="text-align: left; max-width: 300px;"><?= htmlspecialchars($rev['comment']) ?></td>
                    <td><?= $rev['created_at'] ?></td>
                    <td>
                        <a href="/admin/deleteReview/<?= $rev['id'] ?>" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #7f8c8d; margin-top: 20px;">Chưa có đánh giá nào trong hệ thống.</p>
    <?php endif; ?>
</body>
</html>