<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; font-size: 14px; }
        th { background-color: #2c3e50; color: white; }
        .badge { padding: 5px 10px; border-radius: 4px; color: white; background: #e67e22; }
        .select-status { padding: 6px; border-radius: 4px; border: 1px solid #ccc; }
        .btn-save { background: #27ae60; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif;">
    <a href="/" style="text-decoration: none; color: #3498db;">&larr; Về trang chủ cửa hàng</a>
    <h2 style="color: #2c3e50;">Quản Lý Đơn Hàng (Admin OMS)</h2>

    <?php if (!empty($orders)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Người nhận</th>
                    <th>Số điện thoại</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái hiện tại</th>
                    <th>Thay đổi trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $ord): ?>
                <tr>
                    <td><strong>#<?= $ord['id'] ?></strong></td>
                    <td><?= htmlspecialchars($ord['username'] ?? 'Khách vãng lai') ?></td>
                    <td><?= htmlspecialchars($ord['fullname']) ?></td>
                    <td><?= htmlspecialchars($ord['phone']) ?></td>
                    <td style="color: #e74c3c; font-weight: bold;"><?= number_format($ord['total_price'], 0, ',', '.') ?> đ</td>
                    <td><?= htmlspecialchars($ord['payment_method']) ?></td>
                    <td><span class="badge"><?= htmlspecialchars($ord['status']) ?></span></td>
                    <td>
                        <form method="POST" action="/admin/updateStatus" style="display: flex; gap: 5px; justify-content: center;">
                            <input type="hidden" name="order_id" value="<?= $ord['id'] ?>">
                            <select name="status" class="select-status">
                                <option value="Chờ xác nhận" <?= $ord['status'] == 'Chờ xác nhận' ? 'selected' : '' ?>>Chờ xác nhận</option>
                                <option value="Đang đóng gói" <?= $ord['status'] == 'Đang đóng gói' ? 'selected' : '' ?>>Đang đóng gói</option>
                                <option value="Đang giao" <?= $ord['status'] == 'Đang giao' ? 'selected' : '' ?>>Đang giao</option>
                                <option value="Đã giao" <?= $ord['status'] == 'Đã giao' ? 'selected' : '' ?>>Đã giao</option>
                                <option value="Đã hủy" <?= $ord['status'] == 'Đã hủy' ? 'selected' : '' ?>>Đã hủy</option>
                            </select>
                            <button type="submit" class="btn-save">Lưu</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #7f8c8d; margin-top: 20px;">Chưa có đơn hàng nào trong hệ thống.</p>
    <?php endif; ?>
</body>
</html>