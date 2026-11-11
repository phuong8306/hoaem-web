<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Thanh toán đơn hàng - hoa&em') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Be Vietnam Pro"', 'sans-serif'], serif: ['"Playfair Display"', 'serif'] },
                    colors: { earthOrange: '#C96F4E', earthHover: '#b55f3e', warmBrown: '#8B5E3C', customBeige: '#F3E7D9', warmGray: '#686B6B', textMain: '#382A32' }
                }
            }
        }
    </script>
    <style> body { color: #382A32; font-family: 'Be Vietnam Pro', sans-serif; background-color: #FDF7F2; } </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-earthOrange selection:text-white">

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <h1 class="font-serif text-3xl font-bold text-warmBrown mb-8">Thanh toán đơn hàng</h1>

        <form action="/cart/processCheckout" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Cột trái: Thông tin giao hàng -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-customBeige shadow-sm space-y-6">
                <h2 class="font-serif text-xl font-bold text-warmBrown border-b border-customBeige pb-4">Thông Tin Người Nhận</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-warmGray uppercase tracking-wider mb-2">Họ và tên người nhận:</label>
                        <input type="text" name="fullname" value="<?= htmlspecialchars($userData['fullname'] ?? '') ?>" required placeholder="Nhập đầy đủ họ tên" class="w-full px-4 py-3 bg-customBeige/20 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-1 focus:ring-earthOrange">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-warmGray uppercase tracking-wider mb-2">Số điện thoại liên hệ:</label>
                        <input type="text" id="phone-input" name="phone" value="<?= htmlspecialchars($userData['phone'] ?? '') ?>" required placeholder="Nhập số điện thoại" oninput="updateTransferContent(this.value)" class="w-full px-4 py-3 bg-customBeige/20 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-1 focus:ring-earthOrange">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-warmGray uppercase tracking-wider mb-2">Địa chỉ giao hàng (Chọn địa chỉ hoặc nhập mới):</label>
                        
                        <!-- Dropdown danh sách địa chỉ -->
                        <select id="address-select" onchange="handleAddressChange(this.value)" class="w-full px-4 py-3 bg-customBeige/20 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-1 focus:ring-earthOrange mb-3">
                            <?php if (!empty($userAddresses)): ?>
                                <?php foreach ($userAddresses as $addr): ?>
                                    <option value="<?= htmlspecialchars($addr['address_detail'] ?? $addr['address']) ?>">
                                        🏠 <?= htmlspecialchars($addr['address_detail'] ?? $addr['address']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php elseif (!empty($userData['address'])): ?>
                                <option value="<?= htmlspecialchars($userData['address']) ?>">
                                    🏠 <?= htmlspecialchars($userData['address']) ?> (Địa chỉ nhà)
                                </option>
                            <?php else: ?>
                                <option value="Chưa có địa chỉ lưu sẵn">🏠 Địa chỉ nhà mặc định</option>
                            <?php endif; ?>
                            <option value="other">+ Nhập địa chỉ giao hàng khác...</option>
                        </select>

                        <!-- Ô nhập / hiển thị chi tiết địa chỉ -->
                        <textarea name="address" id="address-textarea" rows="3" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." class="w-full px-4 py-3 bg-customBeige/20 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-1 focus:ring-earthOrange"><?= !empty($userAddresses) ? htmlspecialchars($userAddresses[0]['address_detail'] ?? $userAddresses[0]['address']) : htmlspecialchars($userData['address'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-warmGray uppercase tracking-wider mb-2">Phương thức thanh toán:</label>
                        <select name="payment_method" id="payment_method" onchange="toggleBankInfo(this.value)" class="w-full px-4 py-3 bg-customBeige/20 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-1 focus:ring-earthOrange">
                            <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                            <option value="Bank Transfer">Chuyển khoản ngân hàng (QR Code)</option>
                        </select>
                    </div>

                    <!-- Khung hiển thị ảnh QR VietinBank chính chủ -->
                    <div id="bank-transfer-box" class="hidden p-5 bg-customBeige/30 border border-earthOrange/30 rounded-2xl space-y-4 mt-3">
                        <h3 class="font-serif font-bold text-sm text-warmBrown text-center">Quét mã QR để chuyển khoản nhanh</h3>
                        
                        <div class="flex flex-col sm:flex-row items-center gap-6 justify-center">
                            <!-- Ảnh QR VietinBank chuẩn -->
                            <div class="bg-white p-3 rounded-2xl border border-customBeige shadow-xs text-center flex-shrink-0">
                                <img src="/assets/img/QR-code/QR-HuynhNhatPhuong.jpg" alt="Mã QR Chuyển Khoản Huỳnh Nhật Phương" class="w-48 h-auto object-contain mx-auto rounded-lg">
                                <span class="text-[10px] text-warmGray block mt-1.5 font-medium">VietinBank - Chính chủ</span>
                            </div>

                            <div class="text-xs text-textMain space-y-2 text-center sm:text-left">
                                <p><b>Ngân hàng:</b> <span class="text-warmBrown font-bold">VietinBank</span></p>
                                <p><b>Số tài khoản:</b> <span class="text-earthOrange font-bold text-sm">107882569767</span>[cite: 8]</p>
                                <p><b>Chủ tài khoản:</b> <span class="text-earthOrange font-bold">HUỲNH NHẬT PHƯƠNG</span>[cite: 8]</p>
                                <p><b>Số tiền:</b> <span id="qr-amount-text" class="font-bold text-earthOrange text-sm">0 đ</span></p>
                                <p><b>Nội dung CK:</b> <span id="transfer-content-display" class="font-bold bg-customBeige px-2.5 py-1 rounded text-warmBrown border border-customBeige">HOAEM [SĐT]</span></p>
                            </div>
                        </div>
                        <p class="text-[11px] text-red-500 italic text-center">* Hệ thống sẽ tự động xác nhận đơn hàng sau khi tiệm nhận được tiền chuyển khoản.</p>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Tóm tắt đơn hàng -->
            <div class="bg-white rounded-3xl p-6 border border-customBeige shadow-sm space-y-6 sticky top-24">
                <h2 class="font-serif text-xl font-bold text-warmBrown border-b border-customBeige pb-3">Đơn hàng của bạn</h2>

                <!-- Danh sách sản phẩm thu gọn -->
                <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                    <?php 
                    $subTotal = 0;
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])):
                        foreach ($_SESSION['cart'] as $item):
                            $subTotal += $item['price'] * $item['quantity'];
                    ?>
                        <div class="flex items-center justify-between text-xs gap-3 border-b border-customBeige/50 pb-2">
                            <div class="flex items-center gap-2">
                                <img src="<?= htmlspecialchars($item['image'] ?? '/assets/img/default.jpg') ?>" class="w-10 h-10 rounded-xl object-cover border border-customBeige flex-shrink-0">
                                <div>
                                    <span class="font-bold text-warmBrown block line-clamp-1"><?= htmlspecialchars($item['name']) ?></span>
                                    <span class="text-warmGray">SL: <?= $item['quantity'] ?> | <?= htmlspecialchars($item['size']) ?></span>
                                </div>
                            </div>
                            <span class="font-bold text-earthOrange flex-shrink-0"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</span>
                        </div>
                    <?php 
                        endforeach; 
                    endif;
                    
                    // Tính giảm giá voucher nếu có
                    $discountTotal = 0;
                    if (isset($_SESSION['voucher'])) {
                        $v = $_SESSION['voucher'];
                        if ($subTotal >= ($v['min_order_value'] ?? 0)) {
                            if (!empty($v['discount_percent']) && $v['discount_percent'] > 0) {
                                $discountTotal = ($subTotal * $v['discount_percent']) / 100;
                            } else {
                                $discountTotal = $v['discount_amount'] ?? 0;
                            }
                            if ($discountTotal > $subTotal) $discountTotal = $subTotal;
                        }
                    }
                    $finalTotal = $subTotal - $discountTotal;
                    ?>
                </div>

                <!-- Tính tiền chi tiết -->
                <div class="space-y-3 text-sm border-t border-customBeige pt-4">
                    <div class="flex justify-between text-warmGray">
                        <span>Tạm tính:</span>
                        <span class="font-bold text-textMain"><?= number_format($subTotal, 0, ',', '.') ?> đ</span>
                    </div>
                    <?php if ($discountTotal > 0): ?>
                        <div class="flex justify-between text-green-600 font-medium">
                            <span>Giảm giá (<?= htmlspecialchars($_SESSION['voucher']['code']) ?>):</span>
                            <span>-<?= number_format($discountTotal, 0, ',', '.') ?> đ</span>
                        </div>
                    <?php endif; ?>
                    <div class="flex justify-between text-base font-bold text-warmBrown border-t border-customBeige pt-3">
                        <span>Tổng thanh toán:</span>
                        <span class="text-earthOrange text-xl" id="summary-total-text"><?= number_format($finalTotal, 0, ',', '.') ?> đ</span>
                    </div>
                </div>

                <!-- Nút xác nhận đặt hàng -->
                <button type="submit" class="w-full py-4 bg-earthOrange hover:bg-earthHover text-white rounded-2xl font-bold text-sm transition shadow-lg shadow-earthOrange/20 flex items-center justify-center gap-2 text-center cursor-pointer">
                    <span>Xác Nhận Đặt Hàng ➔</span>
                </button>
            </div>

        </form>
    </main>

    <!-- Script xử lý -->
    <script>
    function handleAddressChange(value) {
        const textarea = document.getElementById('address-textarea');
        if (value === 'other') {
            textarea.value = '';
            textarea.placeholder = 'Nhập địa chỉ giao hàng chi tiết mới...';
            textarea.focus();
        } else {
            textarea.value = value;
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        const phoneInput = document.getElementById('phone-input');
        if (phoneInput && phoneInput.value.trim()) {
            updateTransferContent(phoneInput.value.trim());
        }
    });

    function toggleBankInfo(method) {
        const box = document.getElementById('bank-transfer-box');
        if (method === 'Bank Transfer') {
            box.classList.remove('hidden');
            const finalTotal = <?= json_encode($finalTotal ?? 0) ?>;
            document.getElementById('qr-amount-text').innerText = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(finalTotal);
            
            const phoneVal = document.getElementById('phone-input').value.trim();
            updateTransferContent(phoneVal);
        } else {
            box.classList.add('hidden');
        }
    }

    function updateTransferContent(phone) {
        const display = document.getElementById('transfer-content-display');
        if (phone) {
            display.innerText = 'HOAEM ' + phone;
        } else {
            display.innerText = 'HOAEM + SĐT';
        }
    }
    </script>
</body>
</html>