<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Quản trị - Tạo mã giảm giá') ?></title>
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
<body class="min-h-screen flex flex-col antialiased selection:bg-earthOrange selection:text-white">

    <!-- Top Navigation Bar -->
    <header class="w-full bg-white/90 backdrop-blur-md border-b border-customBeige py-4 px-6 md:px-10 flex justify-between items-center sticky top-0 z-30 shadow-sm">
        <a href="/" class="flex items-center gap-3 group cursor-pointer text-decoration-none">
            <span class="text-3xl transition group-hover:scale-110">🌸</span>
            <div>
                <span class="font-serif text-2xl font-bold text-warmBrown tracking-tight group-hover:text-earthOrange transition">hoa&amp;em</span>
                <span class="block text-[10px] font-bold text-earthOrange uppercase tracking-widest">Admin Dashboard</span>
            </div>
        </a>
        <div class="flex items-center gap-4">
            <span class="text-xs font-semibold text-warmGray hidden md:inline">Xin chào, <b class="text-textMain"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></b></span>
            <a href="/auth/logout" class="px-4 py-2 bg-customBeige/40 hover:bg-red-50 hover:text-red-600 text-warmBrown rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-customBeige"><span>Đăng xuất</span> ➜</a>
        </div>
    </header>

    <!-- Sub Navbar -->
    <div class="bg-white/80 backdrop-blur-sm border-b border-customBeige px-6 md:px-10 py-3.5 shadow-xs">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center gap-2.5 text-xs sm:text-sm font-medium">
            <a href="/admin/orders" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200">Quản lý Đơn hàng</a>
            <a href="/admin/products" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200">Quản lý Sản phẩm</a>
            <a href="/admin/inventory" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200">Quản lý Tồn kho</a>
            <a href="/admin/analytics" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200">Báo cáo &amp; Phân tích</a>
            <a href="/admin/customers" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200">Quản lý Khách hàng</a>
            <a href="/admin/reviews" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200">Quản lý Đánh giá</a>
            <a href="/admin/vouchers" class="px-4 py-2 rounded-xl bg-earthOrange text-white shadow-sm shadow-earthOrange/25 transition duration-200 font-semibold">Quản lý Voucher</a>
        </div>
    </div>

    <!-- Main Form Container -->
    <main class="flex-grow max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl font-bold text-warmBrown">Thêm mã giảm giá mới</h1>
                <p class="text-xs text-warmGray mt-1">Thiết lập mã ưu đãi và mức giảm cho các đơn hàng của khách hàng.</p>
            </div>
            <a href="/admin/vouchers" class="px-4 py-2 bg-customBeige/40 hover:bg-customBeige text-warmBrown rounded-xl text-xs font-bold transition border border-customBeige">← Quay lại danh sách</a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-customBeige p-8">
            <form action="/admin/storeVoucher" method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Mã Voucher (Code)</label>
                    <input type="text" name="code" required placeholder="Ví dụ: HOAEM83, VALENTINE..." class="w-full px-5 py-3.5 bg-customBeige/20 border border-customBeige rounded-2xl text-sm font-medium text-textMain uppercase font-mono focus:outline-none focus:ring-2 focus:ring-earthOrange/40 transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Phần trăm giảm (%)</label>
                        <input type="number" name="discount_percent" min="0" max="100" placeholder="Ví dụ: 10" class="w-full px-5 py-3.5 bg-customBeige/20 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-2 focus:ring-earthOrange/40 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Giá trị đơn tối thiểu (VNĐ)</label>
                        <input type="number" name="min_order_value" min="0" placeholder="Ví dụ: 200000" class="w-full px-5 py-3.5 bg-customBeige/20 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-2 focus:ring-earthOrange/40 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Ngày hết hạn</label>
                    <input type="date" name="expiry_date" class="w-full px-5 py-3.5 bg-customBeige/20 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-2 focus:ring-earthOrange/40 transition">
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-customBeige">
                    <a href="/admin/vouchers" class="px-6 py-3 bg-customBeige/40 hover:bg-customBeige text-warmBrown rounded-2xl text-sm font-bold transition">Hủy bỏ</a>
                    <button type="submit" class="px-8 py-3 bg-earthOrange hover:bg-earthHover text-white rounded-2xl text-sm font-bold transition shadow-md shadow-earthOrange/20">Lưu mã giảm giá</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="w-full py-6 text-center text-warmGray/70 text-xs font-semibold">&copy; <?= date('Y') ?> hoa&amp;em boutique. Hệ thống quản trị nội bộ.</footer>
</body>
</html>