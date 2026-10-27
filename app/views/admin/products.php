<?php
// Giao diện Quản lý sản phẩm - hoa&em boutique
$products = isset($products) ? $products : [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Quản lý Sản phẩm') ?></title>
    
    <!-- Google Fonts: Be Vietnam Pro & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Cấu hình màu sắc thương hiệu HoaEm -->
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
            background-color: #FDF7F2; 
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-earthOrange selection:text-white">

    <!-- Top Navigation Bar -->
    <!-- Top Navigation Bar -->
    <header class="w-full bg-white/90 backdrop-blur-md border-b border-customBeige py-4 px-6 md:px-10 flex justify-between items-center sticky top-0 z-30 shadow-sm">
        <!-- Bấm vào cụm logo này sẽ quay thẳng về trang chủ cửa hàng -->
        <a href="/" class="flex items-center gap-3 group cursor-pointer text-decoration-none">
            <span class="text-3xl transition group-hover:scale-110">🌸</span>
            <div>
                <span class="font-serif text-2xl font-bold text-warmBrown tracking-tight group-hover:text-earthOrange transition">hoa&amp;em</span>
                <span class="block text-[10px] font-bold text-earthOrange uppercase tracking-widest">Admin Dashboard</span>
            </div>
        </a>
        
        <!-- Đã xóa nút chữ "Về trang chủ cửa hàng" ở đây, chỉ giữ lại lời chào và nút đăng xuất -->
        <div class="flex items-center gap-4">
            <span class="text-xs font-semibold text-warmGray hidden md:inline">Xin chào, <b class="text-textMain"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></b></span>
            <a href="/auth/logout" class="px-4 py-2 bg-customBeige/40 hover:bg-red-50 hover:text-red-600 text-warmBrown rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-customBeige">
                <span>Đăng xuất</span> ➜
            </a>
        </div>
    </header>

    <!-- Sub Navbar (Tabs Quản lý) đã được tinh chỉnh mượt mà, sang trọng -->
    <div class="bg-white/80 backdrop-blur-sm border-b border-customBeige px-6 md:px-10 py-3.5 shadow-xs">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center gap-2.5 text-xs sm:text-sm font-medium">
            <a href="/admin/orders" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200 <?= strpos($_SERVER['REQUEST_URI'], '/admin/orders') !== false ? 'bg-earthOrange text-white shadow-sm shadow-earthOrange/25 font-semibold' : '' ?>">Quản lý Đơn hàng</a>
            
            <a href="/admin/products" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200 <?= strpos($_SERVER['REQUEST_URI'], '/admin/products') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/createProduct') !== false ? 'bg-earthOrange text-white shadow-sm shadow-earthOrange/25 font-semibold' : '' ?>">Quản lý Sản phẩm</a>
            
            <a href="/admin/inventory" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200 <?= strpos($_SERVER['REQUEST_URI'], '/admin/inventory') !== false ? 'bg-earthOrange text-white shadow-sm shadow-earthOrange/25 font-semibold' : '' ?>">Quản lý Tồn kho</a>
            
            <a href="/admin/analytics" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200 <?= strpos($_SERVER['REQUEST_URI'], '/admin/analytics') !== false ? 'bg-earthOrange text-white shadow-sm shadow-earthOrange/25 font-semibold' : '' ?>">Báo cáo &amp; Phân tích</a>
            
            <a href="/admin/customers" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200 <?= strpos($_SERVER['REQUEST_URI'], '/admin/customers') !== false ? 'bg-earthOrange text-white shadow-sm shadow-earthOrange/25 font-semibold' : '' ?>">Quản lý Khách hàng</a>
            
            <a href="/admin/reviews" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200 <?= strpos($_SERVER['REQUEST_URI'], '/admin/reviews') !== false ? 'bg-earthOrange text-white shadow-sm shadow-earthOrange/25 font-semibold' : '' ?>">Quản lý Đánh giá</a>
            
            <a href="/admin/vouchers" class="px-4 py-2 rounded-xl text-warmGray hover:bg-earthOrange/10 hover:text-earthOrange transition duration-200 <?= strpos($_SERVER['REQUEST_URI'], '/admin/vouchers') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/createVoucher') !== false ? 'bg-earthOrange text-white shadow-sm shadow-earthOrange/25 font-semibold' : '' ?>">Quản lý Voucher</a>
        </div>
    </div>

    <!-- Main Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Page Header & Action Button -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="font-serif text-3xl font-bold text-warmBrown">Quản lý Sản phẩm</h1>
                <p class="text-xs text-warmGray mt-1">Danh mục sản phẩm, hoa tươi và quà tặng đang trưng bày trên hệ thống cửa hàng.</p>
            </div>
            
            <a href="/admin/createProduct" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-earthOrange hover:bg-earthHover text-white rounded-2xl font-bold text-sm transition shadow-md shadow-earthOrange/20">
                <span>+ Thêm sản phẩm mới</span>
            </a>
        </div>

        <!-- Products Table Card -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-customBeige overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-customBeige/30 border-b border-customBeige text-warmBrown text-xs uppercase tracking-wider font-bold">
                            <th class="py-4 px-6 w-20">ID</th>
                            <th class="py-4 px-6">Tên sản phẩm</th>
                            <th class="py-4 px-6">Danh mục</th>
                            <th class="py-4 px-6">Trạng thái</th>
                            <th class="py-4 px-6 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-customBeige/50 text-sm font-medium">
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="5" class="py-12 text-center text-warmGray">
                                    <div class="text-4xl mb-2">🌷</div>
                                    Chưa có sản phẩm nào trong hệ thống.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $p): ?>
                                <tr class="hover:bg-customBeige/10 transition">
                                    <td class="py-4 px-6 font-bold text-earthOrange">
                                        #<?= $p['id'] ?>
                                    </td>
                                    <td class="py-4 px-6 text-textMain font-semibold flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-customBeige/40 flex items-center justify-center text-lg flex-shrink-0">💐</div>
                                        <span><?= htmlspecialchars($p['name']) ?></span>
                                    </td>
                                    <td class="py-4 px-6 text-warmGray">
                                        <span class="px-3 py-1 bg-customBeige/40 text-warmBrown rounded-full text-xs font-bold">
                                            <?= htmlspecialchars($p['category_name'] ?? 'Chưa phân loại') ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <?php if ($p['status'] == 'active'): ?>
                                            <span class="px-3 py-1 rounded-xl text-xs font-bold border bg-green-50 text-green-700 border-green-200">Đang hiển thị</span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-xl text-xs font-bold border bg-red-50 text-red-700 border-red-200">Đang ẩn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="/admin/deleteProduct/<?= $p['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')" class="inline-flex items-center justify-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-bold transition shadow-xs">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center text-warmGray/70 text-xs font-semibold">
        &copy; <?= date('Y') ?> hoa&amp;em boutique. Hệ thống quản trị nội bộ.
    </footer>

</body>
</html>