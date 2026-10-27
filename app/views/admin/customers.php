<?php
$customers = isset($customers) ? $customers : [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Quản trị - Quản lý Khách hàng') ?></title>
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
            <a href="/admin/customers" class="px-4 py-2 rounded-xl bg-earthOrange text-white shadow-sm shadow-earthOrange/25 transition duration-200 font-semibold">Quản lý Khách hàng</a>
            <a href="/admin/reviews" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200">Quản lý Đánh giá</a>
            <a href="/admin/vouchers" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200">Quản lý Voucher</a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="font-serif text-3xl font-bold text-warmBrown">Quản lý Khách hàng</h1>
            <p class="text-xs text-warmGray mt-1">Danh sách tài khoản khách hàng và lịch sử mua sắm trên hệ thống.</p>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-customBeige overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-customBeige/30 border-b border-customBeige text-warmBrown text-xs uppercase tracking-wider font-bold">
                            <th class="py-4 px-6 w-20">ID</th>
                            <th class="py-4 px-6">Tên khách hàng</th>
                            <th class="py-4 px-6">Email / Tài khoản</th>
                            <th class="py-4 px-6 text-center">Tổng đơn hàng</th>
                            <th class="py-4 px-6">Ngày tham gia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-customBeige/50 text-sm font-medium">
                        <?php if (empty($customers)): ?>
                            <tr><td colspan="5" class="py-12 text-center text-warmGray">Chưa có khách hàng nào đăng ký.</td></tr>
                        <?php else: ?>
                            <?php foreach ($customers as $c): ?>
                                <tr class="hover:bg-customBeige/10 transition">
                                    <td class="py-4 px-6 font-bold text-earthOrange">#<?= $c['id'] ?></td>
                                    <td class="py-4 px-6 text-textMain font-semibold flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-customBeige/60 text-warmBrown flex items-center justify-center font-bold text-xs"><?= mb_strtoupper(mb_substr($c['name'] ?? 'U', 0, 1)) ?></div>
                                        <span><?= htmlspecialchars($c['name']) ?></span>
                                    </td>
                                    <td class="py-4 px-6 text-warmGray"><?= htmlspecialchars($c['email'] ?? 'Không có') ?></td>
                                    <td class="py-4 px-6 text-center"><span class="px-3 py-1 bg-customBeige/40 text-warmBrown rounded-full text-xs font-bold"><?= (int)($c['order_count'] ?? 0) ?> đơn</span></td>
                                    <td class="py-4 px-6 text-warmGray text-xs"><?= htmlspecialchars($c['created_at'] ?? 'N/A') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="w-full py-6 text-center text-warmGray/70 text-xs font-semibold">&copy; <?= date('Y') ?> hoa&amp;em boutique. Hệ thống quản trị nội bộ.</footer>
</body>
</html>