<?php
$categories = isset($categories) ? $categories : [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Quản trị - Quản lý Danh mục') ?></title>
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

    <!-- Header cố định -->
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

    <!-- Body Layout -->
    <div class="flex flex-1 overflow-hidden relative w-full bg-[#FDF7F2]">
        
        <!-- Sidebar Đầy Đủ 9 Mục Menu -->
        <?php $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
        <aside id="sidebar" class="bg-white border-r border-customBeige w-64 flex-shrink-0 sidebar-transition flex flex-col absolute md:relative z-40 h-full -translate-x-full md:translate-x-0 shadow-2xl md:shadow-none">
            <div class="md:hidden flex justify-end p-3 border-b border-customBeige shrink-0">
                <button id="mobile-close-btn" class="p-1.5 text-warmGray hover:text-earthOrange hover:bg-customBeige/30 rounded-lg transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <button id="edge-toggle-btn" class="hidden md:flex absolute -right-3.5 top-5 bg-white border border-customBeige rounded-full w-7 h-7 items-center justify-center text-warmGray hover:text-earthOrange shadow-sm transition-colors z-50">
                <svg id="edge-toggle-icon" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-1.5 no-scrollbar">
                <a href="/admin/orders" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?= strpos($uri, '/admin/order') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap">Quản lý Đơn hàng</span>
                </a>
                <a href="/admin/products" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?= strpos($uri, '/admin/product') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap">Quản lý Sản phẩm</span>
                </a>
                <a href="/admin/categories" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?= strpos($uri, '/admin/categor') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h5.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H16a2 2 0 012 2v2M4 14a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap">Quản lý Danh mục</span>
                </a>
                <a href="/admin/inventory" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?= strpos($uri, '/admin/inventory') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap">Quản lý Tồn kho</span>
                </a>
                <a href="/admin/analytics" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?= strpos($uri, '/admin/analytics') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap">Báo cáo & Phân tích</span>
                </a>

                <div class="pt-2 border-t border-customBeige/60"></div>

                <a href="/admin/customers" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?= strpos($uri, '/admin/customer') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap">Quản lý Khách hàng</span>
                </a>
                <a href="/admin/messages" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?= strpos($uri, '/admin/message') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap">Quản lý Tin nhắn</span>
                </a>
                <a href="/admin/reviews" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?= strpos($uri, '/admin/review') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap">Quản lý Đánh giá</span>
                </a>
                <a href="/admin/vouchers" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?= strpos($uri, '/admin/voucher') !== false ? 'bg-earthOrange text-white font-bold shadow-sm' : 'text-warmGray hover:bg-[#FAF4EF] hover:text-earthOrange font-medium' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    <span class="sidebar-text text-[13px] whitespace-nowrap">Quản lý Voucher</span>
                </a>
            </nav>
        </aside>

        <div id="mobile-overlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden"></div>

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto w-full p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="font-serif text-3xl font-bold text-warmBrown">Quản lý Danh mục</h1>
                    <p class="text-xs text-warmGray mt-1">Phân loại hoa tươi, số lượng sản phẩm liên kết và cấu hình các thuộc tính động.</p>
                </div>
                <a href="/admin/categoryAdd" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-earthOrange hover:bg-earthHover text-white rounded-2xl font-bold text-sm transition shadow-md shadow-earthOrange/20 whitespace-nowrap">+ Thêm danh mục mới</a>
            </div>

            <!-- THANH TÌM KIẾM & LỌC -->
            <div class="bg-white p-4 rounded-2xl border border-customBeige shadow-sm mb-6 flex flex-col sm:flex-row gap-4 justify-between items-center">
                <div class="relative w-full sm:w-80">
                    <input type="text" id="search-input" onkeyup="filterCategories()" placeholder="Tìm danh mục theo tên..." class="w-full pl-10 pr-4 py-2.5 bg-customBeige/20 border border-customBeige rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-earthOrange/40">
                    <svg class="w-4 h-4 text-warmGray absolute left-3.5 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                    <select id="filter-attr" onchange="filterCategories()" class="px-4 py-2.5 bg-customBeige/20 border border-customBeige rounded-xl text-xs font-medium text-warmBrown focus:outline-none">
                        <option value="all">Tất cả danh mục</option>
                        <option value="has_attrs">Có thuộc tính động</option>
                        <option value="no_attrs">Chưa có thuộc tính</option>
                        <option value="has_products">Có sản phẩm</option>
                    </select>
                </div>
            </div>

            <!-- BẢNG DANH MỤC -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-customBeige overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[750px]" id="categories-table">
                        <thead>
                            <tr class="bg-customBeige/30 border-b border-customBeige text-warmBrown text-xs uppercase tracking-wider font-bold">
                                <th class="py-4 px-6 w-20">ID</th>
                                <th class="py-4 px-6">Tên danh mục</th>
                                <th class="py-4 px-6 text-center">Thuộc tính động</th>
                                <th class="py-4 px-6 text-center">Sản phẩm</th>
                                <th class="py-4 px-6 text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-customBeige/50 text-sm font-medium">
                            <?php if (empty($categories)): ?>
                                <tr id="empty-row"><td colspan="5" class="py-12 text-center text-warmGray">Chưa có danh mục nào.</td></tr>
                            <?php else: ?>
                                <?php foreach ($categories as $cat): ?>
                                    <tr class="cat-row hover:bg-customBeige/10 transition" 
                                        data-name="<?= htmlspecialchars(mb_strtolower($cat['name'])) ?>"
                                        data-attrs="<?= (int)($cat['total_attributes'] ?? 0) ?>"
                                        data-products="<?= (int)($cat['total_products'] ?? 0) ?>">
                                        
                                        <td class="py-4 px-6 font-bold text-earthOrange">#<?= $cat['id'] ?></td>
                                        <td class="py-4 px-6 text-textMain font-semibold cat-name-text"><?= htmlspecialchars($cat['name']) ?></td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center px-3 py-1 bg-customBeige/40 text-warmBrown rounded-xl text-xs font-bold border border-customBeige">
                                                <?= (int)($cat['total_attributes'] ?? 0) ?> thuộc tính
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-bold border border-emerald-200">
                                                <?= (int)($cat['total_products'] ?? 0) ?> sản phẩm
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center space-x-1.5 whitespace-nowrap">
                                            <!-- 1. Chỉnh sửa tên danh mục -->
                                            <a href="/admin/editCategory/<?= $cat['id'] ?>" class="inline-flex items-center justify-center px-3 py-1.5 bg-customBeige hover:bg-warmBrown hover:text-white text-warmBrown rounded-xl text-xs font-bold transition">Chỉnh sửa</a>
                                            
                                            <!-- 2. Quản lý thuộc tính động (Mở Modal AJAX) -->
                                            <button type="button" onclick="openAttributeModal(<?= $cat['id'] ?>, '<?= htmlspecialchars(addslashes($cat['name'])) ?>')" class="inline-flex items-center justify-center px-3 py-1.5 bg-earthOrange hover:bg-earthHover text-white rounded-xl text-xs font-bold transition">Thuộc tính</button>
                                            
                                            <!-- 3. Xóa danh mục (Kiểm tra sản phẩm liên quan) -->
                                            <button type="button" onclick="confirmDeleteCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars(addslashes($cat['name'])) ?>', <?= (int)($cat['total_products'] ?? 0) ?>)" class="inline-flex items-center justify-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-bold transition">Xóa</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <footer class="text-center text-warmGray/70 text-xs font-semibold pb-4">&copy; 2026 hoa&amp;em boutique. Hệ thống quản trị nội bộ.</footer>
        </main>
    </div>

    <!-- MODAL QUẢN LÝ THUỘC TÍNH ĐỘNG NÂNG CAO -->
    <div id="attribute-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] max-w-2xl w-full p-6 sm:p-8 shadow-2xl space-y-6 max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center border-b border-customBeige pb-4 shrink-0">
                <div>
                    <h3 class="font-serif text-xl font-bold text-warmBrown">Quản lý thuộc tính động</h3>
                    <p class="text-xs text-warmGray mt-0.5" id="modal-cat-name">Danh mục: ...</p>
                </div>
                <button type="button" onclick="closeAttributeModal()" class="text-warmGray hover:text-earthOrange p-2 rounded-lg text-lg">✕</button>
            </div>

            <!-- Danh sách thuộc tính động -->
            <div id="modal-attr-list" class="space-y-4 overflow-y-auto flex-grow pr-1">
                <!-- Nội dung được nạp qua AJAX -->
            </div>

            <!-- Nút thêm thuộc tính mới & Lưu -->
            <div class="pt-4 border-t border-customBeige flex justify-between items-center shrink-0">
                <button type="button" onclick="addNewAttrRow()" class="px-4 py-2 bg-customBeige text-warmBrown hover:bg-warmBrown hover:text-white rounded-xl text-xs font-bold transition">+ Thêm thuộc tính mới</button>
                <div class="flex gap-2">
                    <button type="button" onclick="closeAttributeModal()" class="px-4 py-2 bg-gray-100 text-warmGray rounded-xl text-xs font-bold hover:bg-gray-200">Đóng</button>
                    <button type="button" onclick="saveAttributes()" class="px-6 py-2 bg-earthOrange text-white rounded-xl text-xs font-bold hover:bg-earthHover shadow-sm">Lưu thuộc tính</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentModalCategoryId = null;

        // 1. TÌM KIẾM & LỌC REAL-TIME
        function filterCategories() {
            const query = document.getElementById('search-input').value.toLowerCase().trim();
            const filter = document.getElementById('filter-attr').value;
            const rows = document.querySelectorAll('.cat-row');

            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const attrs = parseInt(row.getAttribute('data-attrs'));
                const products = parseInt(row.getAttribute('data-products'));

                let matchesSearch = name.includes(query);
                let matchesFilter = true;

                if (filter === 'has_attrs') matchesFilter = attrs > 0;
                else if (filter === 'no_attrs') matchesFilter = attrs === 0;
                else if (filter === 'has_products') matchesFilter = products > 0;

                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // 2. XÁC NHẬN XÓA DANH MỤC (KIỂM TRA DỮ LIỆU SẢN PHẨM)
        function confirmDeleteCategory(id, name, productCount) {
            if (productCount > 0) {
                alert(`KHÔNG THỂ XÓA!\nDanh mục "${name}" hiện đang có ${productCount} sản phẩm liên kết.\nBạn cần xóa hoặc chuyển các sản phẩm này sang danh mục khác trước khi xóa danh mục này!`);
                return;
            }

            if (confirm(`Bạn có chắc chắn muốn xóa danh mục "${name}"?\nToàn bộ cấu hình thuộc tính động của danh mục này sẽ bị dọn dẹp!`)) {
                window.location.href = `/admin/deleteCategory/${id}`;
            }
        }

        // 3. XỬ LÝ MODAL QUẢN LÝ THUỘC TÍNH (AJAX)
        function openAttributeModal(catId, catName) {
            currentModalCategoryId = catId;
            document.getElementById('modal-cat-name').innerText = "Danh mục: " + catName;
            document.getElementById('attribute-modal').classList.remove('hidden');

            const container = document.getElementById('modal-attr-list');
            container.innerHTML = '<div class="text-center py-6 text-warmGray text-xs">Đang tải danh sách thuộc tính...</div>';

            fetch('/admin/getCategoryAttributes/' + catId)
                .then(res => res.json())
                .then(attrs => {
                    container.innerHTML = '';
                    if (attrs && attrs.length > 0) {
                        attrs.forEach(attr => renderAttrRow(attr));
                    } else {
                        addNewAttrRow();
                    }
                })
                .catch(err => {
                    container.innerHTML = '<div class="text-center py-6 text-red-500 text-xs">Không thể nạp thuộc tính. Vui lòng thử lại!</div>';
                });
        }

        function closeAttributeModal() {
            document.getElementById('attribute-modal').classList.add('hidden');
            currentModalCategoryId = null;
        }

        let newAttrCounter = 1000;
        function renderAttrRow(data = {}) {
            const container = document.getElementById('modal-attr-list');
            const key = data.id || ('new_' + newAttrCounter++);
            const name = data.attribute_name || '';
            const type = data.data_type || 'string';
            const required = data.is_required ? 'checked' : '';
            const options = data.options ? data.options.join(', ') : '';

            const row = document.createElement('div');
            row.className = "attr-item p-4 bg-customBeige/10 border border-customBeige rounded-2xl space-y-3 relative";
            row.setAttribute('data-id', key);

            row.innerHTML = `
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <input type="text" class="attr-name flex-grow px-3.5 py-2 bg-white border border-customBeige rounded-xl text-xs font-medium focus:ring-2 focus:ring-earthOrange/40" placeholder="Tên thuộc tính (VD: Chiều cao, Màu sắc...)" value="${name}">
                    <select class="attr-type px-3 py-2 bg-white border border-customBeige rounded-xl text-xs font-medium text-warmBrown" onchange="toggleOptionInput(this)">
                        <option value="string" ${type==='string'?'selected':''}>Văn bản</option>
                        <option value="integer" ${type==='integer'?'selected':''}>Số nguyên</option>
                        <option value="decimal" ${type==='decimal'?'selected':''}>Số thập phân</option>
                        <option value="select" ${type==='select'?'selected':''}>Danh sách lựa chọn</option>
                    </select>
                    <label class="flex items-center gap-1.5 text-xs text-warmBrown font-bold cursor-pointer whitespace-nowrap">
                        <input type="checkbox" class="attr-required rounded text-earthOrange focus:ring-earthOrange" ${required}> Bắt buộc
                    </label>
                    <button type="button" onclick="this.closest('.attr-item').remove()" class="px-2.5 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold transition">Xóa</button>
                </div>
                <div class="options-box ${type==='select'?'':'hidden'}">
                    <input type="text" class="attr-options w-full px-3.5 py-2 bg-white border border-customBeige rounded-xl text-xs" placeholder="Các lựa chọn (phân cách bằng dấu phẩy, VD: Đỏ, Xanh, Vàng...)" value="${options}">
                </div>
            `;
            container.appendChild(row);
        }

        function addNewAttrRow() {
            renderAttrRow();
        }

        function toggleOptionInput(selectEl) {
            const optionsBox = selectEl.closest('.attr-item').querySelector('.options-box');
            if (selectEl.value === 'select') {
                optionsBox.classList.remove('hidden');
            } else {
                optionsBox.classList.add('hidden');
            }
        }

        // LƯU DỮ LIỆU THUỘC TÍNH ĐỘNG VÀO DATABASE QUA AJAX
        function saveAttributes() {
            if (!currentModalCategoryId) return;

            const items = document.querySelectorAll('#modal-attr-list .attr-item');
            const payload = [];

            let isValid = true;
            items.forEach(item => {
                const name = item.querySelector('.attr-name').value.trim();
                const type = item.querySelector('.attr-type').value;
                const isRequired = item.querySelector('.attr-required').checked ? 1 : 0;
                const optionsVal = item.querySelector('.attr-options').value.trim();

                if (!name) {
                    alert('Vui lòng điền đầy đủ tên thuộc tính!');
                    isValid = false;
                    return;
                }

                let optionsArr = [];
                if (type === 'select' && optionsVal) {
                    optionsArr = optionsVal.split(',').map(s => s.trim()).filter(s => s.length > 0);
                }

                payload.push({
                    id: item.getAttribute('data-id'),
                    name: name,
                    type: type,
                    is_required: isRequired,
                    options: optionsArr
                });
            });

            if (!isValid) return;

            fetch('/admin/saveCategoryAttributes/' + currentModalCategoryId, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ attributes: payload })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Lưu thuộc tính thành công!');
                    location.reload();
                } else {
                    alert(data.message || 'Lưu thất bại!');
                }
            })
            .catch(err => {
                alert('Có lỗi xảy ra khi lưu dữ liệu!');
            });
        }

        // JS Sidebar Toggle
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const edgeBtn = document.getElementById('edge-toggle-btn');
            const edgeIcon = document.getElementById('edge-toggle-icon');
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileCloseBtn = document.getElementById('mobile-close-btn');
            const overlay = document.getElementById('mobile-overlay');

            if(edgeBtn) {
                edgeBtn.addEventListener('click', () => {
                    const isCollapsed = sidebar.classList.contains('w-[76px]');
                    sidebar.classList.toggle('w-[76px]', !isCollapsed);
                    sidebar.classList.toggle('w-64', isCollapsed);
                    edgeIcon.classList.toggle('rotate-180', !isCollapsed);
                    document.querySelectorAll('.sidebar-text').forEach(t => t.classList.toggle('hidden', !isCollapsed));
                });
            }
            if(mobileBtn) mobileBtn.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); });
            if(mobileCloseBtn) mobileCloseBtn.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); });
            if(overlay) overlay.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); });
        });
    </script>
</body>
</html>