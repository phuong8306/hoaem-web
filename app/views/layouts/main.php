<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tính tổng số lượng sản phẩm trong giỏ hàng để hiển thị lên Header
$cartCount = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += isset($item['quantity']) ? (int)$item['quantity'] : 0;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'HoaEm - Tiệm Hoa Tươi Trực Tuyến') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Be Vietnam Pro"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        earthOrange: '#C86D53',
                        earthHover: '#A85A43',
                        warmBrown: '#5C4033',
                        customBeige: '#FAF4EF',
                        warmGray: '#8A7A71',
                        textMain: '#3E2F28',
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            color: #3E2F28; 
            font-family: 'Be Vietnam Pro', sans-serif;
            background: url('/assets/img/bg-floral.png') no-repeat top center fixed;
            background-size: cover;
            background-color: #FAF4EF;
        }
        /* Style chung cho hiệu ứng cuộn trang */
        .reveal-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-up.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col selection:bg-earthOrange selection:text-white">

    <!-- HEADER CHUNG TOÀN HỆ THỐNG -->
    <header class="sticky top-0 w-full bg-[#FAF4EF]/95 backdrop-blur-md z-50 border-b border-earthOrange/10 shadow-sm py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 group py-1">
                <img src="/assets/img/products/logo-moi.png" alt="Shop hoa tươi HoaEm" class="h-9 sm:h-10 w-auto object-contain mix-blend-multiply group-hover:scale-105 transition duration-300">
            </a>
            
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-warmBrown">
                <a href="/" class="<?= ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php') ? 'text-earthOrange border-b-2 border-earthOrange pb-1' : 'hover:text-earthOrange transition pb-1' ?>">Trang chủ</a>
                <a href="/products" class="<?= str_contains($_SERVER['REQUEST_URI'], '/products') ? 'text-earthOrange border-b-2 border-earthOrange pb-1' : 'hover:text-earthOrange transition pb-1' ?>">Sản phẩm</a>
                <a href="/about" class="<?= str_contains($_SERVER['REQUEST_URI'], '/about') ? 'text-earthOrange border-b-2 border-earthOrange pb-1' : 'hover:text-earthOrange transition pb-1' ?>">Giới thiệu</a>
                <a href="/contact" class="<?= str_contains($_SERVER['REQUEST_URI'], '/contact') ? 'text-earthOrange border-b-2 border-earthOrange pb-1' : 'hover:text-earthOrange transition pb-1' ?>">Liên hệ</a>
            </nav>

            <div class="flex items-center gap-4">
                <!-- Icon Giỏ hàng kèm badge số lượng động -->
                <a href="/cart" class="text-warmBrown hover:text-earthOrange relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="absolute -top-2 -right-2 bg-earthOrange text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center"><?= $cartCount ?></span>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="flex items-center gap-2">
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="/admin/orders" class="px-4 py-2 bg-earthOrange text-white rounded-full text-xs font-semibold hover:bg-earthHover transition shadow-sm">Trang quản lý</a>
                        <?php else: ?>
                            <a href="/account" class="px-4 py-2 border border-earthOrange text-earthOrange rounded-full text-xs font-semibold hover:bg-earthOrange hover:text-white transition">Tài khoản</a>
                        <?php endif; ?>

                        <a href="/auth/logout" class="px-4 py-2 bg-customBeige border border-earthOrange/20 hover:border-earthOrange text-warmBrown rounded-full text-xs font-semibold transition flex items-center gap-1.5 shadow-sm">
                            <span>Đăng xuất</span>
                            <span class="text-earthOrange font-bold">&rarr;</span>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="hidden sm:flex items-center gap-3 border-l border-earthOrange/20 pl-4">
                        <a href="/auth/login" class="text-warmBrown hover:text-earthOrange text-sm font-semibold transition">Đăng nhập</a>
                        <a href="/auth/register" class="px-5 py-2 bg-[#C86D53] text-white rounded-full text-sm font-semibold hover:bg-earthHover transition shadow-sm">Đăng ký</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- NỘI DUNG ĐƯỢC RENDER TỪ CONTROLLER -->
    <main class="flex-grow w-full">
        <?= $content ?>
    </main>

    <!-- FOOTER CHUNG TOÀN HỆ THỐNG -->
    <footer class="bg-white/90 backdrop-blur-md border-t border-earthOrange/15 relative z-10 mt-auto pt-12 pb-8 text-warmBrown">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pb-10 border-b border-earthOrange/10">
                <div class="space-y-4">
                    <a href="/" class="flex items-center gap-2 group inline-block">
                        <img src="/assets/img/products/logo-moi.png" alt="HoaEm Boutique" class="h-9 w-auto object-contain mix-blend-multiply group-hover:scale-105 transition duration-300">
                    </a>
                    <p class="text-xs text-warmGray leading-relaxed">
                        Tiệm hoa tươi boutique trực tuyến. Mang trọn vẹn yêu thương và hoài niệm qua từng cánh hoa rực rỡ nhất.
                    </p>
                </div>
                <div class="space-y-3">
                    <h4 class="font-serif font-bold text-sm uppercase tracking-wider text-warmBrown">Khám phá</h4>
                    <ul class="space-y-2 text-xs text-warmGray">
                        <li><a href="/products" class="hover:text-earthOrange transition">Tất cả sản phẩm hoa</a></li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <h4 class="font-serif font-bold text-sm uppercase tracking-wider text-warmBrown">Về chúng tôi</h4>
                    <ul class="space-y-2 text-xs text-warmGray">
                        <li><a href="/about" class="hover:text-earthOrange transition">Câu chuyện của chúng mình</a></li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <h4 class="font-serif font-bold text-sm uppercase tracking-wider text-warmBrown">Chính sách</h4>
                    <ul class="space-y-2 text-xs text-warmGray">
                        <li><a href="/contact" class="hover:text-earthOrange transition">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-warmGray">
                <div>
                    &copy; <?= date('Y') ?> HoaEm Boutique. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>