<?php
$products = isset($products) ? $products : [];
$categories = isset($categories) ? $categories : [];
$selectedCategory = isset($selectedCategory) ? $selectedCategory : null;
$message = isset($message) ? $message : 'Danh sách sản phẩm hoa tươi nổi bật';
$occasions = isset($occasions) ? $occasions : [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sản Phẩm - HoaEm Boutique</title>
    
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

    <!-- BẮT ĐẦU PHẦN BODY TRANG SẢN PHẨM -->
    <main class="flex-grow w-full relative z-10 product-body-wrapper pb-16">
        
        <style>
            .product-body-wrapper .reveal-up {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.8s ease-out, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .product-body-wrapper .reveal-up.active {
                opacity: 1;
                transform: translateY(0);
            }
            .product-body-wrapper .img-zoom-hover img {
                transition: transform 0.7s ease;
            }
            .product-body-wrapper .img-zoom-hover:hover img {
                transform: scale(1.08);
            }
            .product-body-wrapper .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .product-body-wrapper .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
            
            <!-- SECTION A: GỢI Ý QUÀ TẶNG -->
            <section class="reveal-up">
                <div class="text-center mb-8">
                    <span class="text-earthOrange font-semibold text-[10px] sm:text-xs tracking-widest uppercase">GỢI Ý QUÀ TẶNG</span>
                    <h2 class="font-serif text-3xl font-bold text-warmBrown mt-1">Hoa cho mọi dịp</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php 
                    $fallbackImages = [
                        '/assets/img/tonvinhphaidep.jpg',
                        '/assets/img/kiniemtinhyeu.jpg',
                        '/assets/img/hoasinhnhat.jpg'
                    ];
                    $i = 0;
                    if (!empty($occasions)): 
                        $featuredOccasions = array_slice($occasions, 0, 3);
                        foreach ($featuredOccasions as $occ): 
                            $bgImg = !empty($occ['image']) ? $occ['image'] : ($fallbackImages[$i % count($fallbackImages)]);
                    ?>
                        <a href="/products?occasion=<?= htmlspecialchars($occ['slug']) ?>" class="group relative h-[220px] lg:h-[250px] rounded-[24px] overflow-hidden shadow-sm block img-zoom-hover border border-earthOrange/10">
                            <img src="<?= htmlspecialchars($bgImg) ?>" alt="<?= htmlspecialchars($occ['name']) ?>" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-warmBrown/95 via-warmBrown/30 to-transparent transition-opacity duration-300 group-hover:opacity-90"></div>
                            
                            <div class="absolute top-4 left-4 w-10 h-10 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center text-lg shadow-sm">
                                <?= htmlspecialchars($occ['icon'] ?? '🌸') ?>
                            </div>
                            
                            <div class="absolute bottom-4 left-4 right-4 text-white flex justify-between items-end gap-2">
                                <div class="flex-1">
                                    <h3 class="font-serif text-lg lg:text-xl font-bold drop-shadow-md leading-tight"><?= htmlspecialchars($occ['name']) ?></h3>
                                    <p class="text-[11px] lg:text-xs mt-1 text-white/90 line-clamp-1 drop-shadow-sm"><?= htmlspecialchars($occ['description']) ?></p>
                                </div>
                                <span class="w-8 h-8 bg-white/20 backdrop-blur-md text-white rounded-full flex items-center justify-center group-hover:bg-earthOrange transition shadow-sm shrink-0">&rarr;</span>
                            </div>
                        </a>
                    <?php 
                        $i++;
                        endforeach; 
                    endif; 
                    ?>
                </div>
            </section>

            <!-- SECTION B & C: TÌM KIẾM & BỘ LỌC -->
            <section class="space-y-6 reveal-up" style="transition-delay: 150ms;">
                <div class="max-w-2xl mx-auto">
                    <form action="/products" method="GET" class="flex bg-white rounded-full shadow-sm border border-earthOrange/20 overflow-hidden p-1.5 focus-within:ring-2 focus-within:ring-earthOrange/30 transition">
                        <?php if(!empty($selectedCategory)): ?>
                            <input type="hidden" name="category_id" value="<?= htmlspecialchars($selectedCategory) ?>">
                        <?php endif; ?>
                        
                        <div class="flex items-center pl-4 text-warmGray">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Tìm kiếm bó hoa yêu thích..." class="w-full px-4 py-2.5 outline-none text-textMain text-sm bg-transparent">
                        <button type="submit" class="bg-earthOrange hover:bg-earthHover text-white px-6 sm:px-8 py-2.5 rounded-full text-sm font-semibold transition whitespace-nowrap shadow-sm">
                            Tìm kiếm
                        </button>
                    </form>
                </div>

                <div class="w-full overflow-x-auto hide-scrollbar pb-2">
                    <div class="flex flex-nowrap md:flex-wrap items-center justify-start md:justify-center gap-2.5 min-w-max md:min-w-0 px-1">
                        <a href="/products" class="px-5 py-2.5 rounded-full text-sm font-semibold transition whitespace-nowrap shadow-sm <?= empty($selectedCategory) ? 'bg-earthOrange text-white' : 'bg-white text-warmBrown border border-earthOrange/20 hover:border-earthOrange hover:text-earthOrange' ?>">
                            Tất cả
                        </a>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <?php $isActive = (isset($selectedCategory) && $selectedCategory == $cat['id']); ?>
                                <a href="/products?category_id=<?= $cat['id'] ?>" class="px-5 py-2.5 rounded-full text-sm font-semibold transition whitespace-nowrap shadow-sm <?= $isActive ? 'bg-earthOrange text-white' : 'bg-white text-warmBrown border border-earthOrange/20 hover:border-earthOrange hover:text-earthOrange' ?>">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- SECTION D, E & F: DANH SÁCH SẢN PHẨM -->
            <section class="reveal-up" style="transition-delay: 250ms;">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end border-b border-earthOrange/15 pb-4 mb-6 gap-4">
                    <div>
                        <span class="text-earthOrange font-semibold text-[10px] tracking-widest uppercase">✦ BỘ SƯU TẬP ĐỘC QUYỀN</span>
                        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-warmBrown mt-1">
                            <?= htmlspecialchars($message ?? 'Danh sách sản phẩm hoa tươi') ?>
                        </h1>
                    </div>
                    <?php if (isset($products)): ?>
                        <div class="text-xs font-medium text-warmGray whitespace-nowrap bg-white/60 px-3 py-1.5 rounded-full border border-earthOrange/10">
                            Hiển thị <strong><?= count($products) ?></strong> sản phẩm
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Lưới Sản Phẩm -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 xl:gap-8 pb-10">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $p): ?>
                        
                        <?php
                            // LOGIC THỜI GIAN THỰC: Kiểm tra sản phẩm tạo trong vòng 2 ngày (<= 2 ngày)
                            $isNew = false;
                            if (!empty($p['created_at'])) {
                                $createdAt = strtotime($p['created_at']);
                                $now = time();
                                $diffDays = ($now - $createdAt) / 86400; // Đổi giây sang ngày
                                if ($diffDays <= 2) {
                                    $isNew = true;
                                }
                            }
                        ?>

                        <div class="bg-white rounded-[24px] p-4 shadow-sm border border-earthOrange/10 hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col group relative">
                            
                            <!-- Ảnh Card -->
                            <div class="aspect-[4/3] bg-customBeige/40 rounded-[16px] overflow-hidden mb-4 relative img-zoom-hover">
                                <?php if (!empty($p['image'])): ?>
                                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-4xl bg-orange-50">💐</div>
                                <?php endif; ?>
                                
                                <!-- NHÃN ĐỘNG: Chỉ hiện "Mới" khi trong vòng 2 ngày, ngoài ra không hiện gì -->
                                <?php if ($isNew): ?>
                                    <span class="absolute top-2 left-2 bg-earthOrange/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm backdrop-blur-sm">
                                        Mới
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Nội dung Card -->
                            <div class="flex-grow flex flex-col px-1">
                                <a href="/product/detail/<?= htmlspecialchars($p['slug'] ?? $p['id']) ?>" class="font-medium text-textMain hover:text-earthOrange transition text-sm mb-1 line-clamp-2 min-h-[40px]" title="<?= htmlspecialchars($p['name']) ?>">
                                    <?= htmlspecialchars($p['name']) ?>
                                </a>
                                
                                <div class="flex items-center gap-2 mt-auto mb-4">
                                    <div class="text-earthOrange font-bold text-base">
                                        <?= number_format($p['min_price'] ?? $p['price'] ?? 0, 0, ',', '.') ?> đ
                                    </div>
                                    <?php if (!empty($p['old_price']) && $p['old_price'] > ($p['min_price'] ?? $p['price'] ?? 0)): ?>
                                        <div class="text-[11px] text-warmGray line-through">
                                            <?= number_format($p['old_price'], 0, ',', '.') ?> đ
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- CTA Xem Chi Tiết -->
                                <a href="/product/detail/<?= htmlspecialchars($p['slug'] ?? $p['id']) ?>" class="block w-full text-center bg-white border border-earthOrange text-earthOrange hover:bg-earthOrange hover:text-white py-2.5 rounded-full text-xs font-semibold transition">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-full flex flex-col items-center justify-center py-16 bg-white/60 rounded-[30px] border border-earthOrange/10 shadow-sm text-center">
                            <span class="text-5xl mb-4 opacity-50">🥀</span>
                            <h3 class="font-serif text-xl font-bold text-warmBrown mb-2">Không tìm thấy sản phẩm nào</h3>
                            <p class="text-sm text-warmGray max-w-md">Chúng mình chưa có mẫu hoa nào khớp với tìm kiếm của bạn. Hãy thử chọn một danh mục khác hoặc dùng từ khóa chung chung hơn nhé.</p>
                            <a href="/products" class="mt-6 px-6 py-2.5 bg-earthOrange text-white text-sm font-semibold rounded-full hover:bg-earthHover transition shadow-sm">
                                Quay lại tất cả sản phẩm
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            </section>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });
                
                document.querySelectorAll('.product-body-wrapper .reveal-up').forEach(el => observer.observe(el));
            });
        </script>
    </main>
    <!-- KẾT THÚC PHẦN BODY TRANG SẢN PHẨM -->

    <footer class="bg-white border-t border-customBeige py-6 text-center text-warmGray text-xs mt-auto">
        &copy; <?= date('Y') ?> HoaEm Boutique. All rights reserved.
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>