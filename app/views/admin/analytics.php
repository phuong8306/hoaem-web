<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        .dashboard-grid { display: flex; gap: 20px; margin-top: 20px; }
        .card { flex: 1; background: #fff; border: 1px solid #ddd; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .card h3 { margin: 0; color: #7f8c8d; font-size: 16px; }
        .card p { font-size: 24px; font-weight: bold; color: #2c3e50; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; font-size: 14px; }
        th { background-color: #2c3e50; color: white; }
        .nav-admin { margin-bottom: 20px; }
        .menu-links a { margin-right: 15px; text-decoration: none; font-weight: bold; color: #3498db; }
        .menu-links a.active { color: #2c3e50; border-bottom: 2px solid #2c3e50; padding-bottom: 3px; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif; background: #f8f9fa;">
    <a href="/" style="text-decoration: none; color: #3498db;">&larr; Về trang chủ cửa hàng</a>
    <h2 style="color: #2c3e50;">Báo Cáo & Phân Tích (Analytics & Reporting)</h2>

    <div class="nav-admin menu-links">
        <a href="/admin/orders">Quản lý Đơn hàng</a>
        <a href="/admin/products">Quản lý Sản phẩm</a>
        <a href="/admin/inventory">Quản lý Tồn kho</a>
        <a href="/admin/analytics" class="active">Báo cáo & Phân tích</a>
        <a href="/admin/customers">Quản lý Khách hàng</a>
    </div>

    <div class="dashboard-grid">
        <div class="card">
            <h3>Tổng Doanh Thu</h3>
            <p style="color: #27ae60;"><?= number_format($summary['total_revenue'], 0, ',', '.') ?> đ</p>
        </div>
        <div class="card">
            <h3>Tổng Đơn Hàng Thành Công</h3>
            <p style="color: #3498db;"><?= number_format($summary['total_orders']) ?></p>
        </div>
        <div class="card">
            <h3>Giá Trị Trung Bình / Đơn (AOV)</h3>
            <p style="color: #e67e22;"><?= number_format($summary['aov'], 0, ',', '.') ?> đ</p>
        </div>
    </div>

    <h3 style="color: #2c3e50; margin-top: 40px;">Top Sản Phẩm Bán Chạy Nhất</h3>
    <?php if (!empty($topProducts)): ?>
        <table>
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Tổng số lượng đã bán</th>
                    <th>Doanh thu đóng góp</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topProducts as $tp): ?>
                <tr>
                    <td style="text-align: left; font-weight: bold;"><?= htmlspecialchars($tp['name']) ?></td>
                    <td><?= $tp['total_sold'] ?> sản phẩm</td>
                    <td style="color: #e74c3c; font-weight: bold;"><?= number_format($tp['revenue'], 0, ',', '.') ?> đ</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #7f8c8d; margin-top: 20px;">Chưa có dữ liệu bán hàng để thống kê.</p>
    <?php endif; ?>
</body>
</html>