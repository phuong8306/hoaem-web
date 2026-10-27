<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        .invoice-box { max-width: 700px; margin: 30px auto; padding: 25px; border: 1px solid #ddd; border-radius: 8px; background: #fff; text-align: left; }
        .invoice-header { display: flex; justify-content: space-between; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; font-size: 14px; }
        th { background-color: #f8f9fa; }
        .badge { padding: 5px 10px; border-radius: 4px; color: white; background: #f39c12; font-size: 13px; }
        .info-group { margin-bottom: 10px; font-size: 14px; color: #555; }
    </style>
</head>
<body style="font-family: sans-serif; padding: 20px; background: #fdfdfd;">
    
    <div style="max-width: 700px; margin: 0 auto;">
        <a href="/account/orders" style="text-decoration: none; color: #3498db; font-weight: bold;">&larr; Quay lại danh sách đơn hàng</a>
    </div>

    <div class="invoice-box">
        <div class="invoice-header">
            <div>
                <h2 style="color: #2c3e50; margin: 0;">Đơn Hàng #<?= $order['id'] ?></h2>
                <p style="color: #7f8c8d; margin: 5px 0 0 0; font-size: 13px;">Ngày đặt: <?= $order['created_at'] ?></p>
            </div>
            <div>
                <span class="badge"><?= htmlspecialchars($order['status']) ?></span>
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <h4 style="color: #2c3e50; margin-bottom: 8px;">Thông tin nhận hàng:</h4>
            <div class="info-group"><strong>Họ tên người nhận:</strong> <?= htmlspecialchars($order['fullname']) ?></div>
            <div class="info-group"><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></div>
            <div class="info-group"><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['address']) ?></div>
            <div class="info-group"><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></div>
        </div>

        <h4 style="color: #2c3e50; margin-bottom: 8px;">Sản phẩm đã đặt:</h4>
        <?php if (!empty($items)): ?>
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
                    <?php 
                    $calculatedTotal = 0;
                    foreach ($items as $item): 
                        $subTotal = $item['price'] * $item['quantity'];
                        $calculatedTotal += $subTotal;
                    ?>
                    <tr>
                        <td style="text-align: left; font-weight: bold;">
                            <?= htmlspecialchars($item['product_name']) ?>
                        </td>
                        <td><?= htmlspecialchars($item['color']) ?> - Size <?= htmlspecialchars($item['size']) ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                        <td><?= $item['quantity'] ?></td>
                        <td style="color: #e74c3c; font-weight: bold;"><?= number_format($subTotal, 0, ',', '.') ?> đ</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="text-align: right; margin-top: 20px;">
                <h3 style="color: #2c3e50; margin: 0;">Tổng thanh toán: <span style="color: #e74c3c;"><?= number_format($order['total_price'], 0, ',', '.') ?> đ</span></h3>
            </div>
        <?php else: ?>
            <p style="color: #7f8c8d;">Không có sản phẩm nào trong đơn hàng này.</p>
        <?php endif; ?>
    </div>

</body>
</html>