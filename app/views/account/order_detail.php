<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        th { background-color: #f8f9fa; }
        .info-box { background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif;">
    <a href="/account/orders" style="text-decoration: none; color: #3498db;">&larr; Quay lại danh sách đơn hàng</a>
    
    <h2 style="color: #2c3e50;">Chi Tiết Đơn Hàng #<?= $order['id'] ?></h2>

    <div class="info-box">
        <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
        <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['address']) ?></p>
        <p><strong>Trạng thái:</strong> <span style="color: #e67e22; font-weight: bold;"><?= htmlspecialchars($order['status']) ?></span></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Phân loại</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): 
                $subtotal = $item['price'] * $item['quantity'];
            ?>
            <tr>
                <td style="text-align: left;"><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= htmlspecialchars($item['color']) ?> - Size <?= htmlspecialchars($item['size']) ?></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                <td><?= $item['quantity'] ?></td>
                <td style="color: #e74c3c; font-weight: bold;"><?= number_format($subtotal, 0, ',', '.') ?> đ</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3 style="text-align: right; margin-top: 20px;">Tổng thanh toán: <span style="color: #e74c3c;"><?= number_format($order['total_price'], 0, ',', '.') ?> đ</span></h3>
</body>
</html>