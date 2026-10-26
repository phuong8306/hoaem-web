<?php
$products = isset($products) ? $products : [];
$categories = isset($categories) ? $categories : [];
$selectedCategory = isset($selectedCategory) ? $selectedCategory : null;
$message = isset($message) ? $message : 'Khám phá thế giới hoa tươi';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'HoaEm - Tiệm Hoa Tươi Trực Tuyến') ?></title>
    
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
<body class="min-h-screen flex flex-col antialiased selection:bg-earthOrange selection:text-white relative overflow-x-hidden">

    <!-- Header chuẩn phong cách Boutique, thon gọn và tinh tế -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-md z-50 border-b border-customBeige/60 transition-all shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-18 flex items-center justify-between">
            
            <!-- Logo tinh gọn, sắc sảo -->
            <a href="/" class="flex items-center gap-2 group py-1">
                <img src="/assets/img/logo-moi.png" alt="Shop hoa tươi HoaEm" class="h-9 sm:h-10 w-auto object-contain group-hover:scale-105 transition duration-300">
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

    <!-- Nội Dung Chính -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 w-full relative z-10">
        
        <!-- Thanh tìm kiếm -->
        <div class="max-w-2xl mx-auto mb-10">
            <form action="/product/search" method="GET" class="flex bg-white rounded-full shadow-sm border border-customBeige overflow-hidden focus-within:ring-2 focus-within:ring-earthOrange/30 focus-within:border-earthOrange transition-all">
                <input type="text" name="keyword" placeholder="Tìm kiếm bó hoa yêu thích..." required 
                       class="w-full px-6 py-4 outline-none text-textMain bg-transparent text-sm sm:text-base placeholder-warmGray/60 font-medium">
                <button type="submit" class="bg-earthOrange hover:bg-earthHover text-white px-8 py-4 text-sm sm:text-base font-semibold transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span class="hidden sm:inline">Tìm kiếm</span>
                </button>
            </form>
        </div>

        <!-- Thanh danh mục -->
        <div class="flex items-center justify-start md:justify-center overflow-x-auto pb-4 mb-12 gap-2 sm:gap-3 no-scrollbar">
            <a href="/" class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all shadow-sm <?= !$selectedCategory ? 'bg-earthOrange text-white shadow-earthOrange/20' : 'bg-white text-warmGray hover:text-earthOrange border border-customBeige' ?>">
                Tất cả
            </a>
            <a href="/?type=bo-hoa" class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all bg-white text-warmGray hover:text-earthOrange border border-customBeige">
                Bó hoa
            </a>
            <a href="/?type=gio-hoa" class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all bg-white text-warmGray hover:text-earthOrange border border-customBeige">
                Giỏ hoa
            </a>
            <a href="/?type=hop-hoa" class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all bg-white text-warmGray hover:text-earthOrange border border-customBeige">
                Hộp hoa
            </a>
            <a href="/?type=hoa-binh" class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all bg-white text-warmGray hover:text-earthOrange border border-customBeige">
                Hoa bình
            </a>
            <a href="/?type=hoa-qua" class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all bg-white text-warmGray hover:text-earthOrange border border-customBeige">
                Hoa kèm quà
            </a>
        </div>

        <!-- Khu vực sản phẩm nổi bật -->
        <div class="mb-14">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 border-b border-customBeige pb-4">
                <div>
                    <span class="text-earthOrange font-semibold text-sm tracking-wider uppercase">Bộ sưu tập độc quyền</span>
                    <h2 class="font-serif text-3xl font-bold text-warmBrown mt-1"><?= htmlspecialchars($message) ?></h2>
                    <span class="block text-xs text-earthOrange mt-1 tracking-widest">✦ ── ✦ ── ✦</span>
                </div>
            </div>

            <?php if (!empty($products)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8">
                    <?php foreach ($products as $p): ?>
                    <div class="bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group border border-customBeige">
                        <div class="h-60 bg-customBeige/30 rounded-[1.5rem] overflow-hidden mb-4 relative flex items-center justify-center">
                            <?php if (!empty($p['image'])): ?>
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex flex-col items-center justify-center text-warmBrown/70 p-4 text-center bg-gradient-to-br from-customBeige/20 to-orange-50">
                                    <span class="text-3xl mb-1">💐</span>
                                    <span class="text-xs font-semibold px-2"><?= htmlspecialchars($p['name']) ?></span>
                                </div>
                            <?php endif; ?>
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-earthOrange text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                Bán chạy
                            </span>
                        </div>
                        
                        <div class="flex-grow flex flex-col px-1">
                            <a href="/product/detail/<?= htmlspecialchars($p['slug']) ?>" class="font-medium text-warmGray hover:text-earthOrange transition line-clamp-2 leading-snug mb-3">
                                <?= htmlspecialchars($p['name']) ?>
                            </a>
                            <div class="text-earthOrange font-bold text-lg mt-auto mb-4">
                                <?= number_format($p['min_price'], 0, ',', '.') ?> đ
                            </div>
                            <a href="/product/detail/<?= htmlspecialchars($p['slug']) ?>" class="block w-full text-center bg-earthOrange hover:bg-warmBrown text-white py-3 rounded-2xl text-sm font-semibold transition shadow-sm">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20 bg-white rounded-[2rem] border border-customBeige">
                    <p class="text-lg font-medium text-warmGray">Hiện chưa có sản phẩm nào trong danh mục này.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Khu vực “Hoa cho mọi dịp” -->
        <div class="mb-12">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-earthOrange font-semibold text-sm tracking-wider uppercase">Gợi ý quà tặng</span>
                <h2 class="font-serif text-3xl font-bold text-warmBrown mt-1">Hoa cho mọi dịp</h2>
                <p class="text-warmGray text-sm mt-2">Gửi gắm thông điệp chân thành nhất đến những người thương yêu trong từng sự kiện đặc biệt.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="/product/search?occasion=sinh-nhat" class="group relative h-64 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-customBeige/30 group-hover:scale-105 transition duration-500 flex items-center justify-center text-5xl">🎂</div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 z-20 text-white">
                        <h3 class="font-serif text-xl font-bold">Hoa sinh nhật</h3>
                        <p class="text-xs text-gray-200 mt-1 opacity-90">Tươi vui, rực rỡ và đong đầy hạnh phúc</p>
                    </div>
                </a>
                <a href="/product/search?occasion=tinh-yeu" class="group relative h-64 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-customBeige/40 group-hover:scale-105 transition duration-500 flex items-center justify-center text-5xl">💖</div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 z-20 text-white">
                        <h3 class="font-serif text-xl font-bold">Kỷ niệm & Tình yêu</h3>
                        <p class="text-xs text-gray-200 mt-1 opacity-90">Lãng mạn, ngọt ngào và sâu lắng</p>
                    </div>
                </a>
                <a href="/product/search?occasion=tang-me" class="group relative h-64 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-customBeige/30 group-hover:scale-105 transition duration-500 flex items-center justify-center text-5xl">💐</div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 z-20 text-white">
                        <h3 class="font-serif text-xl font-bold">Hoa tặng mẹ</h3>
                        <p class="text-xs text-gray-200 mt-1 opacity-90">Tri ân sâu sắc, kính yêu và trọn vẹn</p>
                    </div>
                </a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-customBeige mt-auto relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center text-warmGray text-xs">
            &copy; <?= date('Y') ?> hoa&amp;em. Tất cả quyền được bảo lưu.
        </div>
    </footer>

</body>
</html>