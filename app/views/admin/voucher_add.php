<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        .form-container { max-width: 500px; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fff; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background: #27ae60; color: white; padding: 12px 20px; border: none; width: 100%; font-size: 16px; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body style="padding: 20px; font-family: sans-serif; background: #f8f9fa;">
    <div class="form-container">
        <a href="/admin/vouchers" style="text-decoration: none; color: #3498db;">&larr; Quay lại danh sách voucher</a>
        <h2 style="color: #2c3e50; text-align: center;">Thêm Mã Giảm Giá Mới</h2>

        <form method="POST" action="/admin/storeVoucher">
            <div class="form-group">
                <label>Mã Voucher (VD: TET2026):</label>
                <input type="text" name="code" required placeholder="Nhập mã viết liền không dấu">
            </div>

            <div class="form-group">
                <label>Phần trăm giảm giá (%):</label>
                <input type="number" name="discount_percent" value="0" min="0" max="100" required>
            </div>

            <div class="form-group">
                <label>Hoặc giảm số tiền cố định (VNĐ):</label>
                <input type="number" name="discount_amount" value="0" min="0" required>
            </div>

            <div class="form-group">
                <label>Giá trị đơn hàng tối thiểu áp dụng (VNĐ):</label>
                <input type="number" name="min_order_value" value="0" min="0" required>
            </div>

            <div class="form-group">
                <label>Ngày hết hạn:</label>
                <input type="date" name="expiry_date" required>
            </div>

            <button type="submit" class="btn-submit">Lưu Mã Giảm Giá</button>
        </form>
    </div>
</body>
</html>
