<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Giỏ hàng - hoa&em') ?></title>
    
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
    <style> body { color: #382A32; font-family: 'Be Vietnam Pro', sans-serif; background-color: #FDF7F2; } </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-earthOrange selection:text-white">

    <!-- Header đơn giản -->
    <header class="w-full bg-white/90 backdrop-blur-md border-b border-customBeige py-4 px-6 md:px-10 flex justify-between items-center sticky top-0 z-30 shadow-sm">
        <a href="/" class="flex items-center gap-3 group cursor-pointer text-decoration-none">
            <span class="text-3xl transition group-hover:scale-110">🌸</span>
            <div>
                <span class="font-serif text-2xl font-bold text-warmBrown tracking-tight group-hover:text-earthOrange transition">hoa&amp;em</span>
                <span class="block text-[10px] font-bold text-earthOrange uppercase tracking-widest">Tiệm Hoa Tươi</span>
            </div>
        </a>
        <a href="/products" class="text-xs font-bold text-warmBrown hover:text-earthOrange transition flex items-center gap-1">← Tiếp tục mua sắm</a>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <h1 class="font-serif text-3xl font-bold text-warmBrown mb-8">Giỏ hàng của bạn</h1>

        <?php if (empty($cart)): ?>
            <!-- Trạng thái giỏ hàng trống -->
            <div class="bg-white rounded-[2.5rem] p-12 text-center border border-customBeige shadow-sm max-w-2xl mx-auto space-y-6">
                <span class="text-6xl">🛒</span>
                <h2 class="font-serif text-2xl font-bold text-warmBrown">Giỏ hàng đang trống</h2>
                <p class="text-warmGray text-sm">Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các tuyệt tác hoa tươi của tiệm nhé!</p>
                <!-- Đã sửa nút khám phá chuyển hướng sang /products -->
                <a href="/products" class="inline-block px-8 py-3.5 bg-earthOrange hover:bg-earthHover text-white rounded-2xl font-bold text-sm transition shadow-md shadow-earthOrange/20">
                    Khám phá sản phẩm ngay 🌸
                </a>
            </div>
        <?php else: ?>
            <!-- Trạng thái giỏ hàng có sản phẩm -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Danh sách sản phẩm trong giỏ -->
                <div class="lg:col-span-2 space-y-4">
                    <?php foreach ($cart as $key => $item): ?>
                        <div class="bg-white rounded-3xl p-5 border border-customBeige shadow-xs flex flex-col sm:flex-row items-center gap-5">
                            <!-- Ảnh sản phẩm -->
                            <div class="w-24 h-24 rounded-2xl overflow-hidden bg-customBeige/30 border border-customBeige flex-shrink-0">
                                <img src="<?= htmlspecialchars($item['image'] ?? '/assets/img/default.jpg') ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-full object-cover">
                            </div>

                            <!-- Thông tin sản phẩm & Phân loại -->
                            <div class="flex-grow text-center sm:text-left">
                                <h3 class="font-serif font-bold text-lg text-warmBrown"><?= htmlspecialchars($item['name']) ?></h3>
                                
                                <!-- Hiển thị phân loại Size - Kiểu chậu/Màu sắc -->
                                <div class="inline-block bg-customBeige/30 px-3 py-1 rounded-xl text-xs font-semibold text-earthOrange my-1.5 border border-customBeige/50">
                                    Phân loại: <?= htmlspecialchars($item['size']) ?><?php if (!empty($item['color']) && $item['color'] !== 'Mặc định'): ?> - <?= htmlspecialchars($item['color']) ?><?php endif; ?>
                                </div>

                                <div class="text-xs text-warmGray">Đơn giá: <b class="text-textMain"><?= number_format($item['price'], 0, ',', '.') ?> đ</b></div>
                            </div>

                            <!-- Tăng giảm số lượng -->
                            <div class="flex items-center gap-3">
                                <form action="/cart/update" method="POST" class="flex items-center bg-customBeige/20 border border-customBeige rounded-xl overflow-hidden">
                                    <input type="hidden" name="cart_key" value="<?= $key ?>">
                                    <button type="submit" name="action" value="decrease" class="w-8 h-9 text-warmBrown font-bold hover:bg-customBeige transition">-</button>
                                    <input type="text" value="<?= $item['quantity'] ?>" readonly class="w-10 text-center text-xs font-bold text-textMain bg-transparent">
                                    <button type="submit" name="action" value="increase" class="w-8 h-9 text-warmBrown font-bold hover:bg-customBeige transition">+</button>
                                </form>
                            </div>

                            <!-- Thành tiền & Nút xóa -->
                            <div class="text-right flex sm:flex-col justify-between items-center sm:items-end w-full sm:w-auto border-t sm:border-t-0 pt-3 sm:pt-0 border-customBeige">
                                <span class="font-bold text-earthOrange text-base"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</span>
                                <a href="/cart/remove/<?= $key ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')" class="text-xs text-red-500 hover:text-red-700 font-semibold mt-1">Xóa</a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Nút Tiếp tục mua sắm ở dưới danh sách -->
                    <div class="pt-2">
                        <a href="/products" class="inline-flex items-center gap-2 px-6 py-3 bg-customBeige/40 hover:bg-customBeige text-warmBrown rounded-2xl text-xs font-bold transition border border-customBeige">
                            <span>←</span> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>

                <!-- Tổng tiền & Mã giảm giá -->
                <div class="bg-white rounded-3xl p-6 border border-customBeige shadow-sm space-y-6 sticky top-24">
                    <h2 class="font-serif text-xl font-bold text-warmBrown border-b border-customBeige pb-3">Tóm tắt đơn hàng</h2>

                    <!-- Form nhập mã giảm giá -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-warmGray uppercase tracking-wider">Mã giảm giá</label>
                        <?php if (isset($_SESSION['voucher'])): ?>
                            <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-2xl text-xs">
                                <div>
                                    <span class="font-bold text-green-700">Mã: <?= htmlspecialchars($_SESSION['voucher']['code']) ?></span>
                                    <span class="block text-[10px] text-green-600">Đã áp dụng thành công</span>
                                </div>
                                <a href="/cart/remove-voucher" class="text-red-500 font-bold hover:underline">Hủy</a>
                            </div>
                        <?php else: ?>
                            <form action="/cart/apply-voucher" method="POST" class="flex gap-2">
                                <input type="text" name="voucher_code" placeholder="Nhập mã voucher..." required class="w-full px-4 py-2.5 bg-customBeige/20 border border-customBeige rounded-xl text-xs font-medium text-textMain focus:outline-none focus:ring-1 focus:ring-earthOrange">
                                <button type="submit" class="px-4 py-2.5 bg-warmBrown hover:bg-earthOrange text-white rounded-xl text-xs font-bold transition flex-shrink-0">Áp dụng</button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <!-- Chi tiết thanh toán -->
                    <div class="space-y-3 text-sm border-t border-customBeige pt-4">
                        <div class="flex justify-between text-warmGray">
                            <span>Tạm tính:</span>
                            <span class="font-bold text-textMain"><?= number_format($subTotal, 0, ',', '.') ?> đ</span>
                        </div>
                        <?php if ($discountTotal > 0): ?>
                            <div class="flex justify-between text-green-600 font-medium">
                                <span>Giảm giá:</span>
                                <span>-<?= number_format($discountTotal, 0, ',', '.') ?> đ</span>
                            </div>
                        <?php endif; ?>
                        <div class="flex justify-between text-base font-bold text-warmBrown border-t border-customBeige pt-3">
                            <span>Tổng cộng:</span>
                            <span class="text-earthOrange text-xl"><?= number_format($finalTotal, 0, ',', '.') ?> đ</span>
                        </div>
                    </div>

                    <!-- Nút thanh toán -->
                    <a href="/cart/checkout" class="w-full py-4 bg-earthOrange hover:bg-earthHover text-white rounded-2xl font-bold text-sm transition shadow-lg shadow-earthOrange/20 flex items-center justify-center gap-2 text-center block">
                        <span>Tiến hành thanh toán ➔</span>
                    </a>
                </div>

            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center text-warmGray/70 text-xs font-semibold z-10 border-t border-customBeige bg-white/50 mt-12">
        &copy; <?= date('Y') ?> hoa&amp;em. Tất cả quyền được bảo lưu.
    </footer>
</body>
</html>