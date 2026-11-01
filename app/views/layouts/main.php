<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'hoa&em') ?></title>
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
    <style> 
        body { color: #382A32; font-family: 'Be Vietnam Pro', sans-serif; background-color: #FDF7F2; } 
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-earthOrange selection:text-white">

    <!-- Header chung cho Frontend -->
    <header class="w-full bg-white/90 backdrop-blur-md border-b border-customBeige py-4 px-6 md:px-10 flex justify-between items-center sticky top-0 z-30 shadow-sm">
        <a href="/" class="flex items-center gap-3 group cursor-pointer text-decoration-none">
            <span class="text-3xl transition group-hover:scale-110">🌸</span>
            <div>
                <span class="font-serif text-2xl font-bold text-warmBrown tracking-tight group-hover:text-earthOrange transition">hoa&amp;em</span>
            </div>
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-warmGray">
            <a href="/" class="hover:text-earthOrange transition">Trang chủ</a>
            <a href="/products" class="hover:text-earthOrange transition">Sản phẩm</a>
            <a href="/about" class="hover:text-earthOrange transition">Giới thiệu</a>
            <a href="/contact" class="hover:text-earthOrange transition">Liên hệ</a>
        </nav>

        <div class="flex items-center gap-4">
            <a href="/cart" class="relative p-2 text-warmBrown hover:text-earthOrange transition flex items-center gap-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </a>

            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['username'])): ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/admin/orders" class="px-4 py-2 bg-earthOrange hover:bg-earthHover text-white rounded-xl text-xs font-bold transition shadow-sm">Trang quản lý</a>
                <?php else: ?>
                    <a href="/account" class="px-4 py-2 bg-customBeige/40 hover:bg-customBeige text-warmBrown rounded-xl text-xs font-bold transition border border-customBeige">Tài khoản</a>
                <?php endif; ?>
                <a href="/auth/logout" class="px-4 py-2 bg-customBeige/40 hover:bg-red-50 hover:text-red-600 text-warmBrown rounded-xl text-xs font-bold transition border border-customBeige">Đăng xuất ➜</a>
            <?php else: ?>
                <a href="/auth/login" class="px-4 py-2 bg-earthOrange hover:bg-earthHover text-white rounded-xl text-xs font-bold transition shadow-sm">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="flex-grow w-full">
        <?= $content ?>
    </main>

    <footer class="w-full py-8 bg-white border-t border-customBeige text-center text-warmGray/70 text-xs font-semibold">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; <?= date('Y') ?> hoa&amp;em boutique — Chuyện hoa, chuyện mình.</p>
        </div>
    </footer>
</body>
</html>