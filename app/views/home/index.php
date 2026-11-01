<?php
// Đảm bảo các biến dữ liệu tồn tại từ HomeController
$products = isset($products) ? $products : [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HoaEm - Tiệm Hoa Tươi Trực Tuyến</title>
    
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
        /* Chỉ áp dụng hiệu ứng cho riêng khu vực trang chủ */
        .home-main-wrapper .reveal-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .home-main-wrapper .reveal-up.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col selection:bg-earthOrange selection:text-white">

    <!-- HEADER: ĐÃ HOÀN THIỆN NÚT QUẢN TRỊ VÀ NÚT ĐĂNG XUẤT CHUẨN MẪU -->
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
                <a href="/cart" class="text-warmBrown hover:text-earthOrange relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="absolute -top-2 -right-2 bg-earthOrange text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">0</span>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="flex items-center gap-2">
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="/admin" class="px-4 py-2 bg-earthOrange text-white rounded-full text-xs font-semibold hover:bg-earthHover transition shadow-sm">Trang quản lý</a>
                        <?php else: ?>
                            <a href="/account" class="px-4 py-2 border border-earthOrange text-earthOrange rounded-full text-xs font-semibold hover:bg-earthOrange hover:text-white transition">Tài khoản</a>
                        <?php endif; ?>

                        <!-- Nút Đăng xuất chuẩn mẫu thiết kế mới -->
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

    <!-- BẮT ĐẦU: BODY TRANG CHỦ -->
    <main class="flex-grow w-full relative z-10 home-main-wrapper pb-16">
        
        <!-- Khu vực 1: Hero Banner -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16 reveal-up">
            <div class="flex flex-col md:flex-row items-center gap-10 lg:gap-16">
                <div class="w-full md:w-1/2 space-y-6 text-center md:text-left">
                    <span class="inline-flex items-center gap-2 bg-red-50 text-earthOrange text-[10px] sm:text-xs font-bold px-4 py-1.5 rounded-full border border-earthOrange/20 uppercase tracking-widest">
                        ⭐ Tiệm hoa tươi trực tuyến
                    </span>
                    
                    <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-bold text-warmBrown leading-tight">
                        Gửi yêu thương<br>qua từng <span class="italic text-earthOrange font-serif">cánh hoa</span>
                    </h1>
                    
                    <p class="text-warmGray text-sm md:text-base leading-relaxed max-w-lg mx-auto md:mx-0">
                        HoaEm Boutique thay bạn gửi gắm trọn vẹn tâm tư và những hoài niệm đẹp đẽ nhất đến người thương qua từng thiết kế hoa tươi tinh tế.
                    </p>
                    
                    <div class="pt-2">
                        <a href="/products" class="inline-flex items-center justify-center gap-2 bg-earthOrange hover:bg-earthHover text-white px-8 py-3.5 rounded-full font-semibold text-sm transition shadow-lg shadow-earthOrange/30">
                            Khám phá bộ sưu tập &rarr;
                        </a>
                    </div>
                </div>

                <div class="w-full md:w-1/2 relative mt-6 md:mt-0">
                    <div class="rounded-[2.5rem] overflow-hidden shadow-2xl relative border-4 border-white/60 group">
                        <img src="https://images.unsplash.com/photo-1563241527-3004b7be0ffd?q=80&w=1000&auto=format&fit=crop" alt="Hoa tươi HoaEm Boutique" class="w-full h-[380px] md:h-[480px] object-cover group-hover:scale-105 transition duration-700">
                    </div>
                </div>
            </div>
        </section>

        <!-- Khu vực 2: Ba thẻ giá trị thương hiệu -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 reveal-up" style="transition-delay: 150ms;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-[24px] border border-earthOrange/20 shadow-sm flex items-start gap-4 hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-earthOrange/10 text-earthOrange rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-warmBrown text-sm mt-1">Tươi thắm mỗi ngày</h4>
                        <p class="text-xs text-warmGray mt-1.5 leading-relaxed">Luôn chọn những đóa hoa tươi rực rỡ nhất để thắp sáng những ngày bình thường.</p>
                    </div>
                </div>
                
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-[24px] border border-earthOrange/20 shadow-sm flex items-start gap-4 hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-earthOrange/10 text-earthOrange rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-warmBrown text-sm mt-1">Tỉ mỉ từng chi tiết</h4>
                        <p class="text-xs text-warmGray mt-1.5 leading-relaxed">Gửi gắm toàn bộ tâm huyết, sự chân thành qua từng dòng code và nét vẽ.</p>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-[24px] border border-earthOrange/20 shadow-sm flex items-start gap-4 hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-earthOrange/10 text-earthOrange rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-warmBrown text-sm mt-1">Trọn vẹn hoài niệm</h4>
                        <p class="text-xs text-warmGray mt-1.5 leading-relaxed">Mỗi sản phẩm là một câu chuyện, thay bạn trao đi những cảm xúc chân thành nhất.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Khu vực 3: Top 4 Sản phẩm được quan tâm nhiều nhất -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 reveal-up" style="transition-delay: 300ms;">
            <div class="text-center mb-10 border-b border-earthOrange/10 pb-6">
                <span class="text-earthOrange font-semibold text-[10px] tracking-widest uppercase">✦ BỘ SƯU TẬP ✦</span>
                <h2 class="font-serif text-3xl font-bold text-warmBrown mt-2">Những bó hoa được yêu thích</h2>
                <p class="text-xs sm:text-sm text-warmGray mt-2">Gửi trao yêu thương bằng những thiết kế hoa tươi dành riêng cho từng khoảnh khắc.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php if (!empty($products)): ?>
                    <?php 
                    $featuredProducts = array_slice($products, 0, 4); 
                    foreach ($featuredProducts as $p): 
                    ?>
                    <div class="bg-white rounded-[24px] p-4 shadow-sm border border-earthOrange/10 hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col group">
                        <div class="aspect-[4/3] bg-customBeige/50 rounded-[16px] overflow-hidden mb-4 relative">
                            <?php if (!empty($p['image'])): ?>
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-4xl">💐</div>
                            <?php endif; ?>
                            
                            <!-- Nhãn duy nhất: Được quan tâm nhiều nhất -->
                            <span class="absolute top-2 left-2 bg-red-500/90 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-sm backdrop-blur-sm">
                                Được quan tâm nhiều nhất
                            </span>
                        </div>
                        
                        <div class="flex-grow flex flex-col px-1">
                            <a href="/product/detail/<?= htmlspecialchars($p['slug'] ?? $p['id']) ?>" class="font-medium text-textMain hover:text-earthOrange transition text-sm mb-1 line-clamp-2 min-h-[40px]">
                                <?= htmlspecialchars($p['name']) ?>
                            </a>
                            <div class="text-earthOrange font-bold text-base mt-auto mb-3">
                                <?= number_format($p['min_price'] ?? $p['price'] ?? 0, 0, ',', '.') ?> đ
                            </div>
                            <a href="/product/detail/<?= htmlspecialchars($p['slug'] ?? $p['id']) ?>" class="block w-full text-center bg-white border border-earthOrange text-earthOrange hover:bg-earthOrange hover:text-white py-2.5 rounded-full text-xs font-semibold transition">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full text-center py-10 bg-white/60 rounded-3xl border border-earthOrange/10">
                        <p class="text-sm text-warmGray">Hoa đang về tiệm, mời bạn quay lại sau nhé!</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="text-center mt-10">
                <a href="/products" class="inline-flex items-center gap-1 text-sm font-bold text-warmBrown border-b-2 border-earthOrange hover:text-earthOrange transition pb-1">
                    Xem tất cả sản phẩm &rarr;
                </a>
            </div>
        </section>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                
                document.querySelectorAll('.home-main-wrapper .reveal-up').forEach(el => observer.observe(el));
            });
        </script>
    </main>
    <!-- KẾT THÚC: BODY TRANG CHỦ -->

    <!-- FOOTER -->
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