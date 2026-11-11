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

                        <div class="bg-white rounded-[24px] p-4 shadow-sm border border-earthOrange/10 hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col group relative">
                            
                            <!-- Ảnh Card -->
                            <div class="aspect-[4/3] bg-customBeige/40 rounded-[16px] overflow-hidden mb-4 relative img-zoom-hover">
                                <?php if (!empty($p['image'])): ?>
                                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-4xl bg-orange-50">💐</div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Nội dung Card -->
                            <div class="flex-grow flex flex-col px-1">
                                <!-- Tên sản phẩm và Trạng thái tồn kho động -->
                                <div class="flex items-start justify-between gap-2 mb-1.5">
                                    <a href="/product/detail/<?= htmlspecialchars($p['slug'] ?? $p['id']) ?>" class="font-bold text-warmBrown hover:text-earthOrange transition text-base line-clamp-1" title="<?= htmlspecialchars($p['name']) ?>">
                                        <?= htmlspecialchars($p['name']) ?>
                                    </a>
                                    <?php 
                                        $stock = isset($p['stock_quantity']) ? (int)$p['stock_quantity'] : 1;
                                    ?>
                                    <?php if ($stock > 0): ?>
                                        <span class="bg-emerald-50 text-emerald-600 text-[11px] font-semibold px-2.5 py-0.5 rounded-full shrink-0">Còn hàng</span>
                                    <?php else: ?>
                                        <span class="bg-red-50 text-red-500 text-[11px] font-semibold px-2.5 py-0.5 rounded-full shrink-0">Hết hàng</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Đánh giá sao động từ Database -->
                                <div class="flex items-center gap-1.5 mb-3">
                                    <?php 
                                        $avgRating = isset($p['avg_rating']) ? round($p['avg_rating']) : 5;
                                        $totalReviews = isset($p['total_reviews']) ? (int)$p['total_reviews'] : 0;
                                    ?>
                                    <div class="text-amber-400 text-xs tracking-tight">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?= $i <= $avgRating ? '★' : '☆' ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="text-warmGray text-xs">(<?= $totalReviews ?> đánh giá)</span>
                                </div>
                                
                                <!-- Hiển thị khoảng giá linh hoạt (Min - Max) -->
                                <div class="text-earthOrange font-bold text-lg mb-4">
                                    <?php 
                                        $minPrice = $p['min_price'] ?? 0;
                                        $maxPrice = $p['max_price'] ?? $minPrice;
                                        
                                        if ($minPrice == $maxPrice || empty($maxPrice) || $maxPrice == 0) {
                                            echo number_format($minPrice, 0, ',', '.') . ' đ';
                                        } else {
                                            echo number_format($minPrice, 0, ',', '.') . ' đ – ' . number_format($maxPrice, 0, ',', '.') . ' đ';
                                        }
                                    ?>
                                </div>
                                
                                <!-- CTA Xem Chi Tiết -->
                                <a href="/product/detail/<?= htmlspecialchars($p['slug'] ?? $p['id']) ?>" class="mt-auto block w-full text-center bg-white border border-earthOrange text-earthOrange hover:bg-earthOrange hover:text-white py-3 rounded-full text-sm font-semibold transition shadow-sm">
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