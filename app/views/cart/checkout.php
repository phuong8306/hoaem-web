<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        .checkout-container { max-width: 600px; margin: 30px auto; padding: 25px; border: 1px solid #ddd; border-radius: 8px; background: #fff; text-align: left; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-order { background: #27ae60; color: white; border: none; padding: 12px 20px; font-size: 16px; width: 100%; cursor: pointer; border-radius: 4px; font-weight: bold; }
        .btn-order:hover { background: #219653; }
    </style>
</head>
<body style="font-family: sans-serif; padding: 20px; background: #fdfdfd;">
    
    <div class="checkout-container">
        <a href="/" style="text-decoration: none; color: #3498db; font-weight: bold;">&larr; Tiếp tục mua sắm</a>
        <h2 style="color: #2c3e50; text-align: center; margin-top: 10px;">Thông Tin Thanh Toán</h2>

        <form method="POST" action="/cart/processCheckout">
            <div class="form-group">
                <label>Họ và tên người nhận:</label>
                <input type="text" name="fullname" required placeholder="Nhập đầy đủ họ tên">
            </div>

            <div class="form-group">
                <label>Số điện thoại liên hệ:</label>
                <input type="text" name="phone" required placeholder="Nhập số điện thoại">
            </div>

            <div class="form-group">
                <label>Địa chỉ giao hàng chi tiết:</label>
                <textarea name="address" rows="3" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện..."></textarea>
            </div>

            <div class="form-group">
                <label>Phương thức thanh toán:</label>
                <select name="payment_method">
                    <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                    <option value="Bank Transfer">Chuyển khoản ngân hàng</option>
                </select>
            </div>

            <button type="submit" class="btn-order">Xác Nhận Đặt Hàng</button>
        </form>
    </div>

</body>
</html>