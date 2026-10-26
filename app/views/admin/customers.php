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
        .badge-vip { background: #f39c12; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif; background: #f8f9fa;">
    <a href="/" style="text-decoration: none; color: #3498db;">&larr; Về trang chủ cửa hàng</a>
    <h2 style="color: #2c3e50;">Quản Trị Khách Hàng (CRM Cơ Bản)</h2>

    <div class="nav-admin menu-links">
        <a href="/admin/orders">Quản lý Đơn hàng</a>
        <a href="/admin/products">Quản lý Sản phẩm</a>
        <a href="/admin/inventory">Quản lý Tồn kho</a>
        <a href="/admin/analytics">Báo cáo & Phân tích</a>
        <a href="/admin/customers" class="active">Quản lý Khách hàng</a>
        <a href="/admin/reviews">Quản lý Đánh giá</a>
    </div>

    <?php if (!empty($customers)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Ngày đăng ký</th>
                    <th>Tổng đơn hàng</th>
                    <th>Tổng chi tiêu (LTV)</th>
                    <th>Phân hạng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $c): ?>
                <tr>
                    <td><strong>#<?= $c['id'] ?></strong></td>
                    <td style="font-weight: bold; color: #2c3e50;"><?= htmlspecialchars($c['username']) ?></td>
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= $c['created_at'] ?></td>
                    <td><?= $c['total_orders'] ?> đơn</td>
                    <td style="color: #e74c3c; font-weight: bold;"><?= number_format($c['total_spent'], 0, ',', '.') ?> đ</td>
                    <td>
                        <?php if ($c['total_spent'] >= 2000000): ?>
                            <span class="badge-vip">VIP</span>
                        <?php else: ?>
                            <span style="color: #7f8c8d;">Thân thiết</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #7f8c8d; margin-top: 20px;">Chưa có khách hàng đăng ký nào trong hệ thống.</p>
    <?php endif; ?>
</body>
</html>