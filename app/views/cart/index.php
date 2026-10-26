<?php
$cartItems = isset($cart) ? $cart : [];
$subtotal = 0;
foreach ($cartItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$discount = isset($_SESSION['voucher']['discount']) ? $_SESSION['voucher']['discount'] : 0;
$total = max(0, $subtotal - $discount);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giỏ hàng của bạn - hoa&amp;em</title>
    
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

    <!-- Header tích hợp Avatar thông minh -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-md z-50 border-b border-customBeige transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 group">
                <span class="text-2xl">🌸</span>
                <span class="font-serif text-2xl font-bold text-warmBrown tracking-tight group-hover:opacity-90 transition">hoa&amp;em</span>
            </a>
            
            <nav class="flex items-center gap-4 sm:gap-6 text-sm sm:text-base font-medium">
                <a href="/" class="text-warmGray hover:text-earthOrange transition flex items-center gap-1">
                    ← Tiếp tục mua sắm
                </a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="flex items-center gap-3 pl-2 border-l border-customBeige">
                        <a href="/account/orders" class="flex items-center gap-2 group">
                            <?php if (!empty($_SESSION['avatar'])): ?>
                                <img src="<?= htmlspecialchars($_SESSION['avatar']) ?>" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-earthOrange/40 group-hover:scale-105 transition">
                            <?php else: ?>
                                <div class="w-9 h-9 rounded-full bg-earthOrange text-white flex items-center justify-center font-bold text-sm shadow-sm group-hover:bg-earthHover transition">
                                    <?= mb_strtoupper(mb_substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <span class="hidden md:inline font-semibold text-warmBrown group-hover:text-earthOrange transition">
                                <?= htmlspecialchars($_SESSION['username'] ?? 'Tài khoản') ?>
                            </span>
                        </a>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="/admin/orders" class="text-amber-600 hover:text-amber-700 transition font-semibold text-xs bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">Quản trị</a>
                        <?php endif; ?>

                        <a href="/auth/logout" class="text-red-500 hover:text-red-600 p-1.5 rounded-full hover:bg-red-50 transition" title="Đăng xuất">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </a>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Nội dung Giỏ hàng -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full relative z-10">
        
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="text-earthOrange font-semibold text-sm tracking-wider uppercase">Túi quà yêu thương</span>
            <h1 class="font-serif text-3xl font-bold text-warmBrown mt-1">Giỏ hàng của bạn</h1>
            <span class="block text-xs text-earthOrange mt-1 tracking-widest">✦ ── ✦ ── ✦</span>
        </div>

        <?php if (!empty($cartItems)): ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <div class="lg:col-span-2 space-y-4">
                    <form action="/cart/update" method="POST">
                        <div class="space-y-4">
                            <?php foreach ($cartItems as $id => $item): ?>
                            <div class="bg-white/95 backdrop-blur-md rounded-[2rem] p-5 shadow-sm border border-customBeige flex flex-col sm:flex-row items-center gap-5">
                                <div class="w-24 h-24 rounded-2xl bg-customBeige/30 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <span class="text-2xl">💐</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex-grow text-center sm:text-left">
                                    <h3 class="font-semibold text-warmBrown text-base line-clamp-1"><?= htmlspecialchars($item['name']) ?></h3>
                                    <div class="text-earthOrange font-bold text-base mt-1">
                                        <?= number_format($item['price'], 0, ',', '.') ?> đ
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="number" name="quantity[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="1" 
                                           class="w-16 text-center py-2 bg-customBeige/20 rounded-xl border border-customBeige font-semibold text-textMain text-sm focus:outline-none focus:border-earthOrange">
                                </div>

                                <div class="text-right font-bold text-warmBrown min-w-[100px]">
                                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ
                                </div>

                                <a href="/cart/remove/<?= $id ?>" class="text-gray-400 hover:text-red-500 transition p-2" title="Xóa sản phẩm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2.002 2.002 0 0116.138 21H7.862a2.002 2.002 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <a href="/cart/clear" class="text-sm font-semibold text-red-500 hover:underline px-2">Xóa tất cả giỏ hàng</a>
                            <button type="submit" class="bg-customBeige/60 hover:bg-customBeige text-warmBrown px-6 py-2.5 rounded-full text-sm font-semibold transition border border-customBeige">
                                Cập nhật giỏ hàng
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white/95 backdrop-blur-md rounded-[2rem] p-6 shadow-sm border border-customBeige space-y-6">
                    <h2 class="font-serif text-xl font-bold text-warmBrown border-b border-customBeige pb-4">Cộng giỏ hàng</h2>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-warmGray">
                            <span>Tạm tính</span>
                            <span class="font-semibold text-textMain"><?= number_format($subtotal, 0, ',', '.') ?> đ</span>
                        </div>
                        <?php if ($discount > 0): ?>
                        <div class="flex justify-between text-earthOrange">
                            <span>Giảm giá (Voucher)</span>
                            <span class="font-semibold">-<?= number_format($discount, 0, ',', '.') ?> đ</span>
                        </div>
                        <?php endif; ?>
                        <div class="flex justify-between text-base font-bold text-warmBrown pt-3 border-t border-customBeige">
                            <span>Tổng cộng</span>
                            <span class="text-earthOrange text-lg"><?= number_format($total, 0, ',', '.') ?> đ</span>
                        </div>
                    </div>

                    <form action="/cart/applyVoucher" method="POST" class="flex gap-2 pt-2">
                        <input type="text" name="voucher_code" placeholder="Mã giảm giá..." 
                               class="flex-grow px-4 py-2.5 bg-customBeige/20 rounded-xl border border-customBeige text-sm font-medium focus:outline-none focus:border-earthOrange">
                        <button type="submit" class="bg-warmBrown hover:bg-earthBrown text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                            Áp dụng
                        </button>
                    </form>

                    <a href="/cart/checkout" class="block w-full text-center bg-earthOrange hover:bg-earthHover text-white py-4 rounded-2xl font-bold text-base transition shadow-md shadow-earthOrange/20">
                        Tiến hành thanh toán
                    </a>
                </div>

            </div>
        <?php else: ?>
            <div class="text-center py-20 bg-white/90 backdrop-blur-md rounded-[2.5rem] border border-customBeige max-w-xl mx-auto shadow-sm">
                <span class="text-5xl mb-3 block">🛒</span>
                <p class="text-lg font-semibold text-warmGray mb-6">Giỏ hàng của bạn đang trống.</p>
                <a href="/" class="bg-earthOrange hover:bg-earthHover text-white px-8 py-3.5 rounded-full font-bold text-sm transition shadow-sm">
                    Khám phá bộ sưu tập hoa
                </a>
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center text-warmGray/70 text-xs font-semibold z-10 border-t border-customBeige bg-white/50">
        &copy; <?= date('Y') ?> hoa&amp;em. Tất cả quyền được bảo lưu.
    </footer>

</body>
</html>