<?php
$product = isset($product) ? $product : [];
$variants = isset($variants) ? $variants : [];
$attributes = isset($attributes) ? $attributes : [];
$reviews = isset($reviews) ? $reviews : [];

// Lấy mảng tất cả giá của các phiên bản
$prices = !empty($variants) ? array_column($variants, 'price') : [];
$minPrice = !empty($prices) ? min($prices) : ($product['price'] ?? 0);
$maxPrice = !empty($prices) ? max($prices) : $minPrice;

$hasRealVariants = (!empty($variants) && count($variants) > 1);
$singleVariantId = !empty($variants[0]['id']) ? $variants[0]['id'] : '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($product['name'] ?? 'Chi tiết sản phẩm') ?> - hoa&amp;em</title>
    
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
        /* Style Highlight khi phiên bản được chọn */
        .variant-radio:checked + .variant-card {
            border-color: #C96F4E !important;
            background-color: #F3E7D9 !important;
            box-shadow: 0 4px 14px rgba(201, 111, 78, 0.18);
        }
        .variant-radio:checked + .variant-card .variant-title {
            color: #8B5E3C !important;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-earthOrange selection:text-white relative overflow-x-hidden">

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full relative z-10">
        
        <!-- Breadcrumb & Quay lại -->
        <div class="mb-6 flex items-center justify-between">
            <a href="/" class="inline-flex items-center gap-1.5 text-sm font-semibold text-warmGray hover:text-earthOrange transition">
                <span>←</span> Quay lại trang chủ
            </a>
            <span class="text-xs font-semibold text-warmGray">Mã SP: #<?= $product['id'] ?? 'N/A' ?></span>
        </div>

        <!-- BLOCK CHÍNH -->
        <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] p-6 sm:p-10 shadow-sm border border-customBeige mb-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Cột Trái: HÌNH ẢNH SẢN PHẨM -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="w-full aspect-square sm:h-[430px] rounded-[2rem] bg-customBeige/30 overflow-hidden flex items-center justify-center relative border border-customBeige shadow-sm group">
                        <img id="main-product-image" 
                             src="<?= htmlspecialchars($product['image'] ?? '') ?>" 
                             data-default-image="<?= htmlspecialchars($product['image'] ?? '') ?>" 
                             alt="<?= htmlspecialchars($product['name'] ?? 'Hoa') ?>" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        
                        <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-earthOrange text-xs font-bold px-3.5 py-1.5 rounded-full shadow-sm">
                            Được quan tâm nhiều nhất
                        </span>
                    </div>

                    <!-- Hàng Thumbnail (Hỗ trợ Toggle Bấm lại để bỏ chọn) -->
                    <div class="flex items-center gap-3 overflow-x-auto pt-1 pb-1">
                        <?php if (!empty($product['image'])): ?>
                            <button type="button" 
                                    data-img-src="<?= htmlspecialchars($product['image']) ?>"
                                    onclick="onThumbnailClick('<?= htmlspecialchars($product['image']) ?>', this)" 
                                    class="thumb-btn border-2 border-transparent hover:border-earthOrange/50 rounded-2xl overflow-hidden w-16 h-16 shrink-0 transition hover:scale-105">
                                <img src="<?= htmlspecialchars($product['image']) ?>" class="w-full h-full object-cover">
                            </button>
                        <?php endif; ?>
                        
                        <?php 
                            $addedImages = [$product['image'] ?? ''];
                            if (!empty($variants)): 
                                foreach ($variants as $v): 
                                    if (!empty($v['image']) && !in_array($v['image'], $addedImages)):
                                        $addedImages[] = $v['image'];
                        ?>
                            <button type="button" 
                                    data-img-src="<?= htmlspecialchars($v['image']) ?>"
                                    onclick="onThumbnailClick('<?= htmlspecialchars($v['image']) ?>', this)" 
                                    class="thumb-btn border-2 border-transparent hover:border-earthOrange/50 rounded-2xl overflow-hidden w-16 h-16 shrink-0 transition hover:scale-105">
                                <img src="<?= htmlspecialchars($v['image']) ?>" class="w-full h-full object-cover">
                            </button>
                        <?php 
                                    endif;
                                endforeach; 
                            endif; 
                        ?>
                    </div>
                </div>

                <!-- Cột Phải: Thông tin & Đặt hàng -->
                <div class="lg:col-span-7 flex flex-col justify-center space-y-6 pt-2">
                    <div>
                        <span class="text-earthOrange font-semibold text-xs tracking-wider uppercase">Tuyệt tác hoa tươi</span>
                        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-warmBrown mt-1">
                            <?= htmlspecialchars($product['name'] ?? 'Tên sản phẩm') ?>
                        </h1>
                        <span class="block text-xs text-earthOrange mt-2 tracking-widest">✦ ── ✦ ── ✦</span>
                    </div>

                    <!-- GIÁ HIỂN THỊ ĐỘNG -->
                    <?php 
                        $defaultPriceText = ($minPrice != $maxPrice) 
                            ? number_format($minPrice, 0, ',', '.') . 'đ – ' . number_format($maxPrice, 0, ',', '.') . 'đ'
                            : number_format($minPrice, 0, ',', '.') . 'đ';
                    ?>
                    <div class="flex items-baseline">
                        <span id="product-price" 
                              data-default-price="<?= htmlspecialchars($defaultPriceText) ?>" 
                              class="text-earthOrange font-bold text-3xl sm:text-4xl">
                            <?= $defaultPriceText ?>
                        </span>
                    </div>

                    <form action="/cart/add" method="POST" class="space-y-6 pt-1" onsubmit="return validateForm()">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id'] ?? '') ?>">

                        <!-- DANH SÁCH PHIÊN BẢN -->
                        <?php if ($hasRealVariants): ?>
                            <div>
                                <label class="block text-xs font-bold text-warmGray uppercase tracking-wider mb-2.5">
                                    Chọn phân loại sản phẩm: <span class="text-[10px] text-warmGray/70 font-normal lowercase">(bấm lần nữa để bỏ chọn)</span>
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="variant-list">
                                    <?php foreach ($variants as $idx => $v): ?>
                                        <?php 
                                            $sizeName = trim($v['size'] ?? 'Tiêu chuẩn');
                                            $colorRaw = trim($v['color'] ?? '');
                                            $cleanColor = preg_replace('/^[^\:]+:\s*/', '', $colorRaw);
                                            
                                            $displayName = $sizeName;
                                            if (!empty($cleanColor) && strtolower($cleanColor) !== 'mặc định' && strtolower($cleanColor) !== 'default') {
                                                $displayName .= " • " . $cleanColor;
                                            }

                                            $variantPrice = $v['price'] ?? $minPrice;
                                            $stock = isset($v['stock_quantity']) ? (int)$v['stock_quantity'] : 0;
                                            $variantImage = !empty($v['image']) ? $v['image'] : ($product['image'] ?? '');
                                            $isOutOfStock = ($stock <= 0);
                                        ?>
                                        <div>
                                            <input type="radio" 
                                                   name="variant_id" 
                                                   id="variant_<?= $v['id'] ?>" 
                                                   value="<?= $v['id'] ?>" 
                                                   data-price="<?= $variantPrice ?>" 
                                                   data-stock="<?= $stock ?>" 
                                                   data-image="<?= htmlspecialchars($variantImage) ?>"
                                                   class="variant-radio hidden"
                                                   <?= $isOutOfStock ? 'disabled' : '' ?>
                                                   onclick="toggleVariant(this)">
                                            
                                            <label for="variant_<?= $v['id'] ?>" class="variant-card block border-2 border-customBeige bg-white hover:border-earthOrange/40 rounded-2xl p-3.5 cursor-pointer transition relative <?= $isOutOfStock ? 'opacity-40 cursor-not-allowed bg-gray-100' : '' ?>">
                                                <div class="font-bold text-xs text-textMain variant-title transition-colors"><?= htmlspecialchars($displayName) ?></div>
                                                <div class="flex justify-between items-center mt-2">
                                                    <span class="text-xs font-bold text-earthOrange"><?= number_format($variantPrice, 0, ',', '.') ?>đ</span>
                                                    
                                                    <!-- HIỂN THỊ TỒN KHO THÔNG MINH -->
                                                    <?php if ($isOutOfStock): ?>
                                                        <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-md">Hết hàng</span>
                                                    <?php elseif ($stock <= 5): ?>
                                                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">Sắp hết (Còn <?= $stock ?>)</span>
                                                    <?php else: ?>
                                                        <span class="text-[10px] font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Còn <?= $stock ?> sp</span>
                                                    <?php endif; ?>
                                                </div>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="variant_id" id="single-variant-id" value="<?= $singleVariantId ?>" data-stock="<?= (int)($variants[0]['stock_quantity'] ?? 0) ?>">
                        <?php endif; ?>

                        <!-- CHỌN SỐ LƯỢNG -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-xs font-bold text-warmGray uppercase tracking-wider">Số lượng:</label>
                            </div>
                            <div class="flex items-center w-36 bg-customBeige/20 rounded-2xl border border-customBeige overflow-hidden">
                                <button type="button" onclick="adjustQuantity(-1)" class="w-12 py-3 text-warmBrown font-bold hover:bg-customBeige/50 transition">-</button>
                                <input type="number" name="quantity" id="quantity-input" value="1" min="1" 
                                       class="w-12 py-3 bg-transparent text-sm font-semibold text-textMain text-center focus:outline-none">
                                <button type="button" onclick="adjustQuantity(1)" class="w-12 py-3 text-warmBrown font-bold hover:bg-customBeige/50 transition">+</button>
                            </div>
                            <span id="stock-warning" class="text-xs text-red-500 mt-1.5 font-medium block hidden">Số lượng vượt quá tồn kho cho phép!</span>
                        </div>

                        <!-- NÚT MUA HÀNG -->
                        <button type="submit" id="btn-add-cart" class="w-full bg-earthOrange hover:bg-earthHover text-white py-4 rounded-2xl font-bold text-base transition shadow-md shadow-earthOrange/20 flex items-center justify-center gap-2">
                            <span>🛒</span> Thêm vào giỏ hàng
                        </button>
                    </form>

                </div>

            </div>
        </div>

        <!-- BLOCK MÔ TẢ & CHI TIẾT SẢN PHẨM -->
        <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] p-6 sm:p-10 shadow-sm border border-customBeige mb-10">
            <h2 class="font-serif text-2xl font-bold text-warmBrown mb-6 border-b border-customBeige pb-4 flex items-center gap-2">
                <span>📖</span> Thông tin &amp; Hướng dẫn sản phẩm
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Mô tả chi tiết & Ý nghĩa -->
                <div class="lg:col-span-7 space-y-4 text-warmGray text-sm leading-relaxed">
                    <h3 class="font-serif text-lg font-bold text-warmBrown">Mô tả sản phẩm</h3>
                    <div class="bg-customBeige/10 p-5 rounded-2xl border border-customBeige/60">
                        <?= nl2br(htmlspecialchars($product['description'] ?? 'Mô tả chi tiết sản phẩm đang được cập nhật...')) ?>
                    </div>

                    <div class="pt-2">
                        <h4 class="font-bold text-warmBrown text-xs uppercase tracking-wider mb-2">🌸 Dịp tặng phù hợp:</h4>
                        <p class="text-xs text-warmGray">Thích hợp làm quà tặng Sinh nhật, Lễ kỷ niệm, Ngày Valentine (14/2), Ngày Phụ nữ (8/3 - 20/10) hoặc đơn giản là món quà bất ngờ trao gửi yêu thương.</p>
                    </div>
                </div>

                <!-- Thuộc tính động & Bảo quản -->
                <div class="lg:col-span-5 space-y-6">
                    <?php if (!empty($attributes)): ?>
                        <div>
                            <h3 class="font-serif text-base font-bold text-warmBrown mb-3">Thông số hoa tươi</h3>
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <?php foreach ($attributes as $attr): ?>
                                    <div class="p-3 bg-customBeige/15 rounded-xl border border-customBeige/60">
                                        <span class="text-warmGray block font-medium"><?= htmlspecialchars($attr['attribute_name']) ?></span>
                                        <span class="font-bold text-textMain mt-0.5 block"><?= htmlspecialchars($attr['attribute_value']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="p-5 bg-amber-50/60 rounded-2xl border border-amber-100 text-xs text-warmBrown space-y-2">
                        <h4 class="font-bold uppercase tracking-wider flex items-center gap-1.5 text-amber-800">
                            <span>💡</span> Mẹo bảo quản hoa tươi lâu:
                        </h4>
                        <ul class="list-disc list-inside space-y-1 text-warmGray">
                            <li>Cắt xéo gốc hoa 45 độ trước khi cắm vào bình.</li>
                            <li>Thay nước sạch cho hoa mỗi ngày 1 lần.</li>
                            <li>Đặt hoa ở nơi mát mẻ, tránh ánh nắng trực tiếp &amp; gió quạt mạnh.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- ĐÁNH GIÁ SẢN PHẨM -->
        <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] p-6 sm:p-10 shadow-sm border border-customBeige">
            <h2 class="font-serif text-2xl font-bold text-warmBrown mb-6 border-b border-customBeige pb-4 flex items-center gap-2">
                <span>💬</span> Đánh Giá Từ Khách Hàng
            </h2>
            
            <?php if (!empty($reviews)): ?>
                <div class="space-y-4">
                    <?php foreach ($reviews as $rev): ?>
                        <div class="p-4 bg-customBeige/10 rounded-2xl border border-customBeige/50 space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-sm text-warmBrown"><?= htmlspecialchars($rev['user_name'] ?? 'Khách hàng') ?></span>
                                <span class="text-xs text-warmGray"><?= htmlspecialchars($rev['created_at'] ?? '') ?></span>
                            </div>
                            <div class="text-earthOrange text-sm">
                                <?= str_repeat('★', intval($rev['rating'] ?? 5)) ?>
                            </div>
                            <p class="text-sm text-textMain"><?= htmlspecialchars($rev['comment'] ?? '') ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    <span class="text-4xl mb-2 opacity-50">💐</span>
                    <p class="text-warmGray text-sm">Chưa có đánh giá nào cho sản phẩm này.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="w-full py-6 text-center text-warmGray/70 text-xs font-semibold z-10 border-t border-customBeige bg-white/50">
        &copy; <?= date('Y') ?> hoa&amp;em. Tất cả quyền được bảo lưu.
    </footer>

    <!-- JAVASCRIPT ĐỒNG BỘ 2 CHIỀU ĐÃ SỬA LOGIC TOGGLE THUMBNAIL -->
    <script>
        const quantityInput = document.getElementById('quantity-input');
        const priceDisplay = document.getElementById('product-price');
        const stockWarning = document.getElementById('stock-warning');
        const mainProductImage = document.getElementById('main-product-image');
        const btnAddCart = document.getElementById('btn-add-cart');

        let lastCheckedRadio = null;

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount);
        }

        // BẤM VÀO THUMBNAIL (BẤM LẦN 1 -> CHỌN, BẤM LẦN 2 -> BỎ CHỌN VỀ BAN ĐẦU)
        function onThumbnailClick(src, btnTarget) {
            if (!src) return;

            // Tìm phiên bản khớp với ảnh này
            const radios = document.querySelectorAll('input[name="variant_id"]');
            let matchedRadio = null;

            radios.forEach(radio => {
                const variantImg = radio.getAttribute('data-image');
                if (variantImg && variantImg.trim() === src.trim() && !radio.disabled) {
                    if (!matchedRadio) matchedRadio = radio;
                }
            });

            // Nếu thumbnail này đang active/chọn rồi mà bấm lại lần nữa -> BỎ CHỌN
            if (btnTarget && btnTarget.classList.contains('border-earthOrange')) {
                if (lastCheckedRadio) {
                    lastCheckedRadio.checked = false;
                    lastCheckedRadio = null;
                }
                resetToDefaultState();
                return;
            }

            // Chọn phiên bản khớp với thumbnail
            if (matchedRadio) {
                matchedRadio.checked = true;
                lastCheckedRadio = matchedRadio;
                applyVariantState(matchedRadio);
            } else {
                if (lastCheckedRadio) {
                    lastCheckedRadio.checked = false;
                    lastCheckedRadio = null;
                }
                resetToDefaultState();
                changeMainImage(src, btnTarget);
            }
        }

        // Đổi ảnh chính & viền cam Thumbnail
        function changeMainImage(src, btnTarget) {
            if (!src || !mainProductImage) return;
            mainProductImage.src = src;

            const allThumbs = document.querySelectorAll('.thumb-btn');
            allThumbs.forEach(b => {
                b.classList.remove('border-earthOrange');
                b.classList.add('border-transparent');
            });

            if (btnTarget) {
                btnTarget.classList.remove('border-transparent');
                btnTarget.classList.add('border-earthOrange');
            } else {
                let found = false;
                allThumbs.forEach(b => {
                    const thumbSrc = b.getAttribute('data-img-src');
                    if (thumbSrc && thumbSrc.trim() === src.trim()) {
                        b.classList.remove('border-transparent');
                        b.classList.add('border-earthOrange');
                        found = true;
                    }
                });
            }
        }

        function getSelectedVariant() {
            return document.querySelector('input[name="variant_id"]:checked') || document.getElementById('single-variant-id');
        }

        function getMaxStock() {
            const selected = getSelectedVariant();
            if (selected) {
                return parseInt(selected.getAttribute('data-stock')) || 0;
            }
            return 999;
        }

        // Toggle khi click trực tiếp nút phiên bản
        function toggleVariant(radio) {
            if (lastCheckedRadio === radio) {
                radio.checked = false;
                lastCheckedRadio = null;
                resetToDefaultState();
            } else {
                lastCheckedRadio = radio;
                applyVariantState(radio);
            }
        }

        // Cập nhật giao diện theo phiên bản đang chọn
        function applyVariantState(radio) {
            const maxStock = parseInt(radio.getAttribute('data-stock')) || 0;
            const price = parseFloat(radio.getAttribute('data-price')) || 0;
            const variantImageUrl = radio.getAttribute('data-image');

            if (priceDisplay) {
                priceDisplay.textContent = formatCurrency(price) + 'đ';
            }

            if (variantImageUrl && variantImageUrl.trim() !== "") {
                changeMainImage(variantImageUrl, null);
            }

            if (quantityInput) {
                quantityInput.max = maxStock;
                if (maxStock <= 0) {
                    quantityInput.value = 0;
                    quantityInput.disabled = true;
                    if (btnAddCart) {
                        btnAddCart.disabled = true;
                        btnAddCart.className = "w-full bg-gray-300 text-gray-500 py-4 rounded-2xl font-bold text-base cursor-not-allowed";
                        btnAddCart.innerText = "Hết hàng";
                    }
                } else {
                    quantityInput.disabled = false;
                    if (parseInt(quantityInput.value) <= 0 || parseInt(quantityInput.value) > maxStock) {
                        quantityInput.value = 1;
                    }
                    if (btnAddCart) {
                        btnAddCart.disabled = false;
                        btnAddCart.className = "w-full bg-earthOrange hover:bg-earthHover text-white py-4 rounded-2xl font-bold text-base transition shadow-md shadow-earthOrange/20 flex items-center justify-center gap-2";
                        btnAddCart.innerHTML = "<span>🛒</span> Thêm vào giỏ hàng";
                    }
                }
            }

            if (stockWarning) stockWarning.classList.add('hidden');
        }

        // Reset về ban đầu khi bỏ chọn
        function resetToDefaultState() {
            if (priceDisplay) {
                priceDisplay.textContent = priceDisplay.getAttribute('data-default-price');
            }

            const defaultImg = mainProductImage ? mainProductImage.getAttribute('data-default-image') : '';
            if (defaultImg) {
                mainProductImage.src = defaultImg;
            }

            // Xóa viền cam khỏi tất cả thumbnail
            document.querySelectorAll('.thumb-btn').forEach(b => {
                b.classList.remove('border-earthOrange');
                b.classList.add('border-transparent');
            });

            if (quantityInput) {
                quantityInput.disabled = false;
                quantityInput.max = 999;
                if (parseInt(quantityInput.value) <= 0) {
                    quantityInput.value = 1;
                }
            }

            if (btnAddCart) {
                btnAddCart.disabled = false;
                btnAddCart.className = "w-full bg-earthOrange hover:bg-earthHover text-white py-4 rounded-2xl font-bold text-base transition shadow-md shadow-earthOrange/20 flex items-center justify-center gap-2";
                btnAddCart.innerHTML = "<span>🛒</span> Thêm vào giỏ hàng";
            }

            if (stockWarning) stockWarning.classList.add('hidden');
        }

        function adjustQuantity(amount) {
            if (!quantityInput || quantityInput.disabled) return;
            let currentVal = parseInt(quantityInput.value) || 1;
            let newVal = currentVal + amount;
            let maxStock = getMaxStock();

            if (newVal < 1) newVal = 1;
            if (newVal > maxStock) {
                newVal = maxStock;
                if(stockWarning) stockWarning.classList.remove('hidden');
            } else {
                if(stockWarning) stockWarning.classList.add('hidden');
            }

            quantityInput.value = newVal;
        }

        function validateForm() {
            const hasVariants = document.querySelectorAll('input[name="variant_id"][type="radio"]').length > 0;
            if (hasVariants) {
                const selected = getSelectedVariant();
                if (!selected) {
                    alert("Vui lòng chọn phân loại sản phẩm trước khi thêm vào giỏ hàng!");
                    return false;
                }
                const stock = parseInt(selected.getAttribute('data-stock')) || 0;
                if (stock <= 0) {
                    alert("Rất tiếc, phiên bản này đã hết hàng!");
                    return false;
                }
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (quantityInput) {
                quantityInput.addEventListener('input', function() {
                    let val = parseInt(this.value) || 1;
                    let maxStock = getMaxStock();
                    if (val > maxStock) {
                        this.value = maxStock;
                        if(stockWarning) stockWarning.classList.remove('hidden');
                    } else {
                        if(stockWarning) stockWarning.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>