<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        .checkout-container { max-width: 600px; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fdfdfd; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-order { background: #27ae60; color: white; padding: 12px 20px; border: none; width: 100%; font-size: 16px; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <div class="checkout-container">
        <a href="/cart" style="text-decoration: none; color: #3498db;">&larr; Quay lại giỏ hàng</a>
        <h2 style="color: #2c3e50; text-align: center;">Thông Tin Thanh Toán</h2>

        <form method="POST" action="/checkout/process">
            <div class="form-group">
                <label>Họ và tên người nhận:</label>
                <input type="text" name="fullname" required value="<?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '' ?>">
            </div>

            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" name="phone" required placeholder="Nhập số điện thoại liên hệ">
            </div>

            <div class="form-group">
                <label>Địa chỉ nhận hàng chi tiết:</label>
                <textarea name="address" rows="3" required placeholder="Số nhà, đường, phường/xã, quận/huyện..."></textarea>
            </div>

            <div class="form-group">
                <label>Hình thức thanh toán:</label>
                <select name="payment_method">
                    <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                    <option value="BankTransfer">Chuyển khoản ngân hàng (VietQR)</option>
                    <option value="Momo">Ví điện tử MoMo</option>
                </select>
            </div>

            <button type="submit" class="btn-order">Xác Nhận Đặt Hàng</button>
        </form>
    </div>
</body>
</html>