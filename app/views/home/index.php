<?php
$products = isset($products) ? $products : [];
?>

<div class="pb-16">
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
                    </div>
                    
                    <div class="flex-grow flex flex-col px-1">
                        <!-- Tên sản phẩm và Trạng thái tồn kho động -->
                        <div class="flex items-start justify-between gap-2 mb-1.5">
                            <a href="/product/detail/<?= htmlspecialchars($p['slug'] ?? $p['id']) ?>" class="font-bold text-warmBrown hover:text-earthOrange transition text-base line-clamp-1">
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

                        <a href="/product/detail/<?= htmlspecialchars($p['slug'] ?? $p['id']) ?>" class="mt-auto block w-full text-center bg-white border border-earthOrange text-earthOrange hover:bg-earthOrange hover:text-white py-3 rounded-full text-sm font-semibold transition shadow-sm">
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
            
            document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
        });
    </script>
</div>