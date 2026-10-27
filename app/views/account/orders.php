<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; font-size: 14px; }
        th { background-color: #f8f9fa; }
        .badge { padding: 6px 12px; border-radius: 4px; color: white; background: #f39c12; font-size: 14px; }
        .btn-view { background: #3498db; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif;">
    <a href="/" style="text-decoration: none; color: #3498db;">&larr; Về trang chủ cửa hàng</a>
    <h2 style="color: #2c3e50;">Lịch Sử Đơn Hàng Của Bạn</h2>

    <?php if (!empty($orders)): ?>
        <table>
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Hình thức thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $ord): ?>
                <tr>
                    <td><strong>#<?= $ord['id'] ?></strong></td>
                    <td><?= htmlspecialchars($ord['created_at']) ?></td>
                    <td style="color: #e74c3c; font-weight: bold;"><?= number_format($ord['total_price'], 0, ',', '.') ?> đ</td>
                    <td><?= htmlspecialchars($ord['payment_method']) ?></td>
                    <td><span class="badge"><?= htmlspecialchars($ord['status']) ?></span></td>
                    <td>
                        <a href="/account/orderDetail/<?= $ord['id'] ?>" class="btn-view">Xem chi tiết</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #7f8c8d; margin-top: 20px;">Bạn chưa có đơn hàng nào.</p>
    <?php endif; ?>
</body>
</html>