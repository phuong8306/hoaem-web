<?php
$summary = isset($summary) ? $summary : [];
$topProducts = isset($topProducts) ? $topProducts : [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Quản trị - Báo cáo & Phân tích') ?></title>
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
    <style>
        body { color: #382A32; font-family: 'Be Vietnam Pro', sans-serif; background-color: #FDF7F2; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .sidebar-transition { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="h-screen flex flex-col antialiased selection:bg-earthOrange selection:text-white overflow-hidden">

    <!-- Top Navigation Bar (Header cố định) -->
    <header class="w-full bg-white border-b border-customBeige py-3 px-4 md:px-6 flex justify-between items-center z-40 shadow-sm shrink-0">
        <div class="flex items-center gap-3">
            <button id="mobile-menu-btn" class="md:hidden p-2 text-warmBrown hover:text-earthOrange hover:bg-customBeige/30 rounded-lg transition" aria-label="Mở menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            
            <a href="/" class="flex items-center gap-2 group cursor-pointer text-decoration-none">
                <span class="text-3xl transition group-hover:scale-110">🌸</span>
                <div>
                    <span class="font-serif text-2xl font-bold text-warmBrown tracking-tight group-hover:text-earthOrange transition">hoa&amp;em</span>
                    <span class="block text-[10px] font-bold text-earthOrange uppercase tracking-widest leading-none mt-0.5">Admin Dashboard</span>
                </div>
            </a>
        </div>
        
        <div class="flex items-center gap-4">
            <span class="text-xs font-semibold text-warmGray hidden md:inline">Xin chào, <b class="text-textMain"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></b></span>
            <a href="/auth/logout" class="px-4 py-2 hover:bg-red-50 hover:text-red-600 text-warmBrown rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-customBeige bg-[#FAF4EF]">
                <span>Đăng xuất</span> <span class="hidden sm:inline">➜</span>
            </a>
        </div>
    </header>

    <!-- Khu vực Body (Chứa Sidebar & Main Content) -->
    <div class="flex flex-1 overflow-hidden relative w-full bg-[#FDF7F2]">
        
        <!-- SIDEBAR DỌC CHUYÊN NGHIỆP CÓ NÚT TOGGLE -->
        <?php $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
        <aside id="sidebar" class="bg-white border-r border-customBeige w-64 flex-shrink-0 sidebar-transition flex flex-col absolute md:relative z-40 h-full -translate-x-full md:translate-x-0 shadow-2xl md:shadow-none">
            
            <!-- Nút Đóng Sidebar trên Mobile (X) -->
            <div class="md:hidden flex justify-end p-3 border-b border-customBeige shrink-0">
                <button id="mobile-close-btn" class="p-1.5 text-warmGray hover:text-earthOrange hover:bg-customBeige/30 rounded-lg transition" aria-label="Đóng menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Nút Thu gọn/Mở rộng sát mép phải (Chỉ hiện trên Desktop) -->
            <button id="edge-toggle-btn" class="hidden md:flex absolute -right-3.5 top-5 bg-white border border-customBeige rounded-full w-7 h-7 items-center justify-center text-warmGray hover:text-earthOrange hover:border-earthOrange shadow-sm transition-colors focus:outline-none z-50" aria-label="Thu gọn menu" title="Thu gọn menu">
                <svg id="edge-toggle-icon" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <!-- Danh sách 9 mục quản lý -->
            <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-1.5 no-scrollbar">
                
                <a href="/admin/orders" title="Quản lý Đơn hàng" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors duration-200 <?= strpos($uri, '/admin/order') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap transition-opacity duration-200">Quản lý Đơn hàng</span>
                </a>
                
                <a href="/admin/products" title="Quản lý Sản phẩm" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors duration-200 <?= strpos($uri, '/admin/product') !== false || strpos($uri, '/admin/createProduct') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap transition-opacity duration-200">Quản lý Sản phẩm</span>
                </a>
                
                <a href="/admin/categories" title="Quản lý Danh mục" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors duration-200 <?= strpos($uri, '/admin/categor') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h5.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H16a2 2 0 012 2v2M4 14a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap transition-opacity duration-200">Quản lý Danh mục</span>
                </a>
                
                <a href="/admin/inventory" title="Quản lý Tồn kho" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors duration-200 <?= strpos($uri, '/admin/inventory') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap transition-opacity duration-200">Quản lý Tồn kho</span>
                </a>
                
                <a href="/admin/analytics" title="Báo cáo & Phân tích" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors duration-200 <?= strpos($uri, '/admin/analytics') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap transition-opacity duration-200">Báo cáo & Phân tích</span>
                </a>
                
                <hr class="border-customBeige my-3">
                
                <a href="/admin/customers" title="Quản lý Khách hàng" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors duration-200 <?= strpos($uri, '/admin/customer') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap transition-opacity duration-200">Quản lý Khách hàng</span>
                </a>
                
                <a href="/admin/messages" title="Quản lý Tin nhắn" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors duration-200 <?= strpos($uri, '/admin/message') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap transition-opacity duration-200">Quản lý Tin nhắn</span>
                </a>
                
                <a href="/admin/reviews" title="Quản lý Đánh giá" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors duration-200 <?= strpos($uri, '/admin/review') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap transition-opacity duration-200">Quản lý Đánh giá</span>
                </a>
                
                <a href="/admin/vouchers" title="Quản lý Voucher" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors duration-200 <?= strpos($uri, '/admin/voucher') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap transition-opacity duration-200">Quản lý Voucher</span>
                </a>
            </nav>
        </aside>

        <!-- Overlay mờ cho Mobile khi mở Sidebar -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden transition-opacity"></div>

        <!-- MAIN CONTENT (Nội dung Báo cáo & Phân tích) -->
        <main class="flex-1 overflow-y-auto w-full p-4 sm:p-6 lg:p-8 transition-all duration-300">
            <div class="mb-6">
                <h1 class="font-serif text-3xl font-bold text-warmBrown">Báo cáo &amp; Phân tích</h1>
                <p class="text-xs text-warmGray mt-1">Tổng quan doanh thu, số liệu kinh doanh và các sản phẩm bán chạy nhất cửa hàng.</p>
            </div>

            <!-- Thẻ thống kê tổng quan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-[2rem] p-6 border border-customBeige shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-earthOrange/10 text-earthOrange flex items-center justify-center text-2xl font-bold">💰</div>
                    <div>
                        <span class="text-xs font-semibold text-warmGray uppercase tracking-wider">Tổng doanh thu</span>
                        <h3 class="text-2xl font-serif font-bold text-warmBrown mt-1"><?= number_format($summary['total_revenue'] ?? 0, 0, ',', '.') ?> đ</h3>
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] p-6 border border-customBeige shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl font-bold">📦</div>
                    <div>
                        <span class="text-xs font-semibold text-warmGray uppercase tracking-wider">Tổng đơn hàng</span>
                        <h3 class="text-2xl font-serif font-bold text-warmBrown mt-1"><?= (int)($summary['total_orders'] ?? 0) ?></h3>
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] p-6 border border-customBeige shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl font-bold">👥</div>
                    <div>
                        <span class="text-xs font-semibold text-warmGray uppercase tracking-wider">Tổng khách hàng</span>
                        <h3 class="text-2xl font-serif font-bold text-warmBrown mt-1"><?= (int)($summary['total_customers'] ?? 0) ?></h3>
                    </div>
                </div>
            </div>

            <!-- Bảng sản phẩm bán chạy -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-customBeige overflow-hidden mb-8">
                <div class="p-6 border-b border-customBeige">
                    <h3 class="font-serif text-lg font-bold text-warmBrown">Top sản phẩm bán chạy</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[600px]">
                        <thead>
                            <tr class="bg-customBeige/30 border-b border-customBeige text-warmBrown text-xs uppercase tracking-wider font-bold">
                                <th class="py-4 px-6">Tên sản phẩm</th>
                                <th class="py-4 px-6 text-center">Đã bán</th>
                                <th class="py-4 px-6 text-right">Doanh thu tạm tính</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-customBeige/50 text-sm font-medium">
                            <?php if (empty($topProducts)): ?>
                                <tr><td colspan="3" class="py-12 text-center text-warmGray">Chưa có dữ liệu bán hàng.</td></tr>
                            <?php else: ?>
                                <?php foreach ($topProducts as $tp): ?>
                                    <tr class="hover:bg-customBeige/10 transition">
                                        <td class="py-4 px-6 font-semibold text-textMain"><?= htmlspecialchars($tp['name']) ?></td>
                                        <td class="py-4 px-6 text-center"><span class="px-3 py-1 bg-customBeige/40 text-warmBrown rounded-full text-xs font-bold"><?= (int)$tp['total_sold'] ?></span></td>
                                        <td class="py-4 px-6 text-right font-bold text-earthOrange"><?= number_format($tp['revenue'] ?? 0, 0, ',', '.') ?> đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <footer class="text-center text-warmGray/70 text-xs font-semibold pb-4">&copy; <?= date('Y') ?> hoa&amp;em boutique. Hệ thống quản trị nội bộ.</footer>
        </main>
    </div>

    <!-- Script xử lý Logic Ẩn/Hiện Sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const edgeBtn = document.getElementById('edge-toggle-btn');
            const edgeIcon = document.getElementById('edge-toggle-icon');
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileCloseBtn = document.getElementById('mobile-close-btn');
            const overlay = document.getElementById('mobile-overlay');
            const texts = document.querySelectorAll('.sidebar-text');

            if(edgeBtn) {
                edgeBtn.addEventListener('click', () => {
                    const isCollapsed = sidebar.classList.contains('w-[76px]');
                    
                    if (isCollapsed) {
                        sidebar.classList.remove('w-[76px]');
                        sidebar.classList.add('w-64');
                        edgeIcon.classList.remove('rotate-180');
                        edgeBtn.setAttribute('aria-label', 'Thu gọn menu');
                        edgeBtn.setAttribute('title', 'Thu gọn menu');
                        
                        texts.forEach(t => {
                            t.classList.remove('hidden');
                            setTimeout(() => t.classList.remove('opacity-0'), 50); 
                        });
                    } else {
                        sidebar.classList.remove('w-64');
                        sidebar.classList.add('w-[76px]');
                        edgeIcon.classList.add('rotate-180');
                        edgeBtn.setAttribute('aria-label', 'Mở rộng menu');
                        edgeBtn.setAttribute('title', 'Mở rộng menu');
                        
                        texts.forEach(t => {
                            t.classList.add('opacity-0');
                            t.classList.add('hidden');
                        });
                    }
                });
            }

            function openMobileMenu() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }
            function closeMobileMenu() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }

            if(mobileBtn) mobileBtn.addEventListener('click', openMobileMenu);
            if(mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeMobileMenu);
            if(overlay) overlay.addEventListener('click', closeMobileMenu);
        });
    </script>
</body>
</html>