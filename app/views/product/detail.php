<?php
$product = isset($product) ? $product : [];
$variants = isset($variants) ? $variants : [];
$reviews = isset($reviews) ? $reviews : [];

// Kiểm tra toàn diện mọi tên biến giá cơ bản
$productPrice = 0;
if (!empty($product['price'])) {
    $productPrice = $product['price'];
} elseif (!empty($product['min_price'])) {
    $productPrice = $product['min_price'];
} elseif (!empty($product['gia'])) {
    $productPrice = $product['gia'];
} elseif (!empty($variants[0]['price'])) {
    $productPrice = $variants[0]['price'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($product['name'] ?? 'Chi tiết sản phẩm') ?> - hoa&amp;em</title>
    
    <!-- Google Fonts: Be Vietnam Pro & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Nhúng Tailwind CSS qua CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Cấu hình bảng màu Cam đất ấm áp -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Be Vietnam Pro"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        earthOrange: '#C96F4E', 
                        earthHover: '#b55f3e',  
                        warmBrown: '#8B5E3C',   
                        customBeige: '#F3E7D9', 
                        warmGray: '#686B6B',    
                        textMain: '#382A32',    
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            color: #382A32; 
            font-family: 'Be Vietnam Pro', sans-serif;
            background: url('/assets/img/bg-floral.png') no-repeat center center fixed;
            background-size: cover;
            background-color: #FDF7F2; 
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-earthOrange selection:text-white relative overflow-x-hidden">

    <!-- Header -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-md z-50 border-b border-customBeige/60 transition-all shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-18 flex items-center justify-between">
            
            <!-- Logo tinh gọn, sắc sảo -->
            <a href="/" class="flex items-center gap-2 group py-1">
                <img src="/assets/img/products/logo-moi.png" alt="Shop hoa tươi HoaEm" class="h-9 sm:h-10 w-auto object-contain group-hover:scale-105 transition duration-300">
            </a>
            
            <!-- Menu điều hướng đồng bộ màu ấm áp -->
            <nav class="flex items-center gap-5 sm:gap-7 text-sm sm:text-base font-medium">
                <a href="/cart" class="text-warmBrown hover:text-earthOrange transition flex items-center gap-1.5 py-1">
                    <span class="text-lg">🛒</span> 
                    <span class="hidden sm:inline">Giỏ hàng</span>
                </a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="flex items-center gap-3 pl-3 border-l border-customBeige">
                        <a href="/account/orders" class="flex items-center gap-2 group">
                            <?php if (!empty($_SESSION['avatar'])): ?>
                                <img src="<?= htmlspecialchars($_SESSION['avatar']) ?>" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-earthOrange/40 group-hover:scale-105 transition">
                            <?php else: ?>
                                <div class="w-8 h-8 rounded-full bg-earthOrange text-white flex items-center justify-center font-bold text-xs shadow-sm group-hover:bg-earthHover transition">
                                    <?= mb_strtoupper(mb_substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <span class="hidden md:inline font-semibold text-warmBrown group-hover:text-earthOrange transition">
                                <?= htmlspecialchars($_SESSION['username'] ?? 'Tài khoản') ?>
                            </span>
                        </a>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="/admin/orders" class="text-amber-700 hover:text-amber-800 transition font-semibold text-xs bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">Quản trị</a>
                        <?php endif; ?>

                        <a href="/auth/logout" class="text-red-500 hover:text-red-600 p-1.5 rounded-full hover:bg-red-50 transition" title="Đăng xuất">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="/auth/login" class="text-warmBrown hover:text-earthOrange transition font-medium">Đăng nhập</a>
                    <a href="/auth/register" class="bg-earthOrange hover:bg-earthHover text-white px-5 py-2 rounded-full transition shadow-sm font-semibold text-sm">Đăng ký</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Nội dung Chi tiết sản phẩm -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full relative z-10">
        
        <!-- Nút quay lại -->
        <div class="mb-6">
            <a href="/" class="inline-flex items-center gap-1.5 text-sm font-semibold text-warmGray hover:text-earthOrange transition">
                <span>←</span> Quay lại trang chủ
            </a>
        </div>

        <!-- Khung chi tiết sản phẩm -->
        <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] p-6 sm:p-10 shadow-sm border border-customBeige mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                
                <!-- Hình ảnh sản phẩm -->
                <div class="h-80 sm:h-96 rounded-[2rem] bg-customBeige/30 overflow-hidden flex items-center justify-center relative border border-customBeige">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="flex flex-col items-center justify-center text-warmBrown/70 p-4 text-center">
                            <span class="text-5xl mb-2">💐</span>
                            <span class="text-sm font-semibold">[Hình ảnh hoa tươi]</span>
                        </div>
                    <?php endif; ?>
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-earthOrange text-xs font-bold px-3.5 py-1.5 rounded-full shadow-sm">
                        Đặc quyền
                    </span>
                </div>

                <!-- Thông tin & Tác vụ mua hàng -->
                <div class="flex flex-col justify-center space-y-6">
                    <div>
                        <span class="text-earthOrange font-semibold text-xs tracking-wider uppercase">Tuyệt tác hoa tươi</span>
                        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-warmBrown mt-1">
                            <?= htmlspecialchars($product['name'] ?? 'Tên sản phẩm') ?>
                        </h1>
                        <span class="block text-xs text-earthOrange mt-2 tracking-widest">✦ ── ✦ ── ✦</span>
                    </div>

                    <!-- Hiển thị tổng giá tiền động theo size và số lượng -->
                    <div class="text-earthOrange font-bold text-2xl sm:text-3xl">
                        <span id="product-price" data-base-price="<?= $productPrice ?>">
                            <?= number_format($productPrice, 0, ',', '.') ?>
                        </span> đ
                    </div>

                    <p class="text-warmGray text-sm sm:text-base leading-relaxed">
                        <?= htmlspecialchars($product['description'] ?? 'Mô tả chi tiết sản phẩm đang được cập nhật...') ?>
                    </p>

                    <!-- Form thêm vào giỏ hàng -->
                    <form action="/cart/add" method="POST" class="space-y-5 pt-2">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id'] ?? '') ?>">

                        <!-- Chọn phân loại (Gọn gàng, chỉ hiện tên size) -->
                        <?php if (!empty($variants)): ?>
                        <div>
                            <label class="block text-xs font-bold text-warmGray uppercase tracking-wider mb-2">Chọn phân loại (Size / Màu sắc):</label>
                            <select name="variant_id" id="variant-select" class="w-full px-4 py-3 bg-customBeige/20 rounded-2xl border border-customBeige text-sm font-semibold text-textMain focus:outline-none focus:ring-2 focus:ring-earthOrange/40 focus:border-earthOrange transition">
                                <?php foreach ($variants as $v): ?>
                                    <?php 
                                        $variantName = $v['name'] ?? $v['attribute'] ?? $v['size'] ?? $v['color'] ?? 'Phân loại tiêu chuẩn';
                                        $variantPrice = $v['price'] ?? $productPrice;
                                    ?>
                                    <option value="<?= $v['id'] ?>" data-price="<?= $variantPrice ?>">
                                        <?= htmlspecialchars($variantName) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <!-- Số lượng -->
                        <div>
                            <label class="block text-xs font-bold text-warmGray uppercase tracking-wider mb-2">Số lượng:</label>
                            <input type="number" name="quantity" value="1" min="1" 
                                   class="w-24 px-4 py-3 bg-customBeige/20 rounded-2xl border border-customBeige text-sm font-semibold text-textMain text-center focus:outline-none focus:ring-2 focus:ring-earthOrange/40 focus:border-earthOrange transition">
                        </div>

                        <!-- Nút Thêm vào giỏ hàng -->
                        <button type="submit" class="w-full bg-earthOrange hover:bg-earthHover text-white py-4 rounded-2xl font-bold text-base transition shadow-md shadow-earthOrange/20 flex items-center justify-center gap-2">
                            <span>🛒</span> Thêm vào giỏ hàng
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- Khu vực Đánh giá sản phẩm -->
        <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] p-6 sm:p-10 shadow-sm border border-customBeige">
            <h2 class="font-serif text-2xl font-bold text-warmBrown mb-6 border-b border-customBeige pb-4">Đánh Giá Sản Phẩm</h2>
            
            <?php if (!isset($_SESSION['user_id'])): ?>
                <p class="text-warmGray text-sm mb-6">
                    Vui lòng <a href="/auth/login" class="text-earthOrange font-bold hover:underline">đăng nhập</a> để viết đánh giá.
                </p>
            <?php endif; ?>

            <?php if (!empty($reviews)): ?>
                <div class="space-y-4">
                    <!-- Danh sách đánh giá -->
                </div>
            <?php else: ?>
                <p class="text-warmGray text-sm">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên đánh giá!</p>
            <?php endif; ?>
        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center text-warmGray/70 text-xs font-semibold z-10 border-t border-customBeige bg-white/50">
        &copy; <?= date('Y') ?> hoa&amp;em. Tất cả quyền được bảo lưu.
    </footer>

    <!-- Script tự động cập nhật giá tiền theo Size và Số lượng -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantSelect = document.getElementById('variant-select');
            const priceDisplay = document.getElementById('product-price');
            const quantityInput = document.querySelector('input[name="quantity"]');

            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN').format(amount);
            }

            function updateTotalPrice() {
                if (!priceDisplay) return;
                
                let unitPrice = 0;
                if (variantSelect) {
                    const selectedOption = variantSelect.options[variantSelect.selectedIndex];
                    unitPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                } else {
                    unitPrice = parseFloat(priceDisplay.getAttribute('data-base-price')) || 0;
                }

                const quantity = parseInt(quantityInput ? quantityInput.value : 1) || 1;
                const totalPrice = unitPrice * quantity;
                priceDisplay.textContent = formatCurrency(totalPrice);
            }

            if (variantSelect) {
                variantSelect.addEventListener('change', updateTotalPrice);
            }

            if (quantityInput) {
                quantityInput.addEventListener('input', updateTotalPrice);
                quantityInput.addEventListener('change', updateTotalPrice);
            }

            updateTotalPrice();
        });
    </script>
</body>
</html>