<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liên Hệ - HoaEm Boutique</title>
    
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

    <!-- BẮT ĐẦU PHẦN BODY TRANG LIÊN HỆ -->
    <main class="flex-grow w-full relative z-10 contact-body-wrapper pb-10">
        
        <!-- CSS Scoped: Giới hạn nội bộ -->
        <style>
            .contact-body-wrapper .reveal-up {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.8s ease-out, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .contact-body-wrapper .reveal-up.active {
                opacity: 1;
                transform: translateY(0);
            }
        </style>

        <!-- Tối ưu padding tổng thể: py-8 thay vì py-16 để trang gọn hơn -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
            
            <!-- TIÊU ĐỀ TRANG (Giảm margin bottom từ mb-12 xuống mb-8) -->
            <div class="text-center max-w-2xl mx-auto mb-8 reveal-up">
                <span class="inline-flex items-center gap-2 bg-red-50 text-earthOrange text-[10px] font-bold px-3 py-1 rounded-full border border-earthOrange/20 uppercase tracking-widest mb-3">
                    ✦ KẾT NỐI VỚI CHÚNG MÌNH
                </span>
                <h1 class="font-serif text-3xl lg:text-4xl font-bold text-warmBrown mb-3 leading-tight">
                    Liên hệ với chúng tôi
                </h1>
                <p class="text-warmGray text-sm leading-relaxed">
                    HoaEm Boutique luôn sẵn sàng lắng nghe và đồng hành cùng bạn để biến mọi tâm tư thành những bó hoa rực rỡ và ý nghĩa nhất.
                </p>
            </div>

            <!-- BỐ CỤC 2 CỘT: Cột Trái (Thông tin) & Cột Phải (Form) - Giảm gap giữa 2 cột -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 reveal-up" style="transition-delay: 150ms;">
                
                <!-- CỘT TRÁI: THÔNG TIN LIÊN HỆ -->
                <div class="lg:col-span-5 flex flex-col space-y-6">
                    <!-- Tối ưu padding box (p-6 lg:p-8) để thu gọn chiều cao -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-[28px] p-6 lg:p-8 border border-earthOrange/15 shadow-sm flex-grow">
                        <h3 class="font-serif text-xl font-bold text-warmBrown mb-5">Ghé thăm tiệm hoa</h3>
                        
                        <!-- Tối ưu khoảng cách giữa các dòng thông tin (space-y-4 thay vì space-y-6) -->
                        <div class="space-y-4">
                            <!-- Địa chỉ -->
                            <div class="flex items-start gap-3 group">
                                <div class="w-10 h-10 bg-customBeige text-earthOrange rounded-full flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-warmBrown">Địa chỉ cửa hàng</h4>
                                    <p class="text-xs text-warmGray mt-0.5 leading-relaxed">Quận 1, TP. Hồ Chí Minh</p>
                                </div>
                            </div>

                            <!-- Điện thoại -->
                            <div class="flex items-start gap-3 group">
                                <div class="w-10 h-10 bg-customBeige text-earthOrange rounded-full flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.864-1.041l-3.286-.481c-.526-.076-1.033.213-1.196.72l-.76 2.368c-2.83-1.42-5.11-3.7-6.53-6.53l2.368-.76c.507-.163.796-.67.72-1.196l-.481-3.286c-.075-.513-.525-.864-1.041-.864H4.5a2.25 2.25 0 00-2.25 2.25z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-warmBrown">Điện thoại</h4>
                                    <a href="tel:+84123456789" class="inline-block text-xs text-warmGray hover:text-earthOrange mt-0.5">0123 456 789</a>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start gap-3 group">
                                <div class="w-10 h-10 bg-customBeige text-earthOrange rounded-full flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-warmBrown">Email hỗ trợ</h4>
                                    <a href="mailto:hello@hoaem.vn" class="inline-block text-xs text-warmGray hover:text-earthOrange mt-0.5">hello@hoaem.vn</a>
                                </div>
                            </div>
                        </div>

                        <!-- Giảm chiều cao ảnh minh họa xuống 140px (giúp form bên phải không bị kéo dài thêm) -->
                        <div class="mt-6 rounded-[20px] overflow-hidden w-full h-[220px] border border-earthOrange/10 shadow-inner relative">
                            <img src="/assets/img/shop-space.png" onerror="this.onerror=null;" alt="Không gian tiệm hoa" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- CỘT PHẢI: FORM LIÊN HỆ -->
                <div class="lg:col-span-7 flex flex-col">
                    <div class="bg-white rounded-[28px] p-6 lg:p-8 border border-earthOrange/15 shadow-lg shadow-earthOrange/5 flex-grow">
                        <h3 class="font-serif text-xl font-bold text-warmBrown mb-1.5">Gửi lời nhắn cho chúng mình</h3>
                        <p class="text-xs text-warmGray mb-6">Vui lòng điền thông tin bên dưới, HoaEm sẽ phản hồi bạn sớm nhất có thể.</p>
                        
                        <form id="contactForm" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST" class="w-full space-y-4">
                            
                            <!-- Hàng 1: Họ tên & Số điện thoại (Chung 1 hàng trên desktop để tiết kiệm cao độ) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                                <div class="flex flex-col space-y-1 w-full">
                                    <label for="name" class="text-[11px] font-bold text-warmBrown uppercase tracking-wide">Họ và tên <span class="text-red-500">*</span></label>
                                    <input type="text" id="name" name="name" required placeholder="Nhập tên của bạn" class="w-full px-4 py-2.5 bg-[#FAF4EF]/50 border border-earthOrange/20 rounded-xl text-sm text-textMain outline-none focus:border-earthOrange transition">
                                </div>
                                
                                <div class="flex flex-col space-y-1 w-full">
                                    <label for="phone" class="text-[11px] font-bold text-warmBrown uppercase tracking-wide">Số điện thoại <span class="text-red-500">*</span></label>
                                    <input type="tel" id="phone" name="phone" required placeholder="Ví dụ: 0912345678" class="w-full px-4 py-2.5 bg-[#FAF4EF]/50 border border-earthOrange/20 rounded-xl text-sm text-textMain outline-none focus:border-earthOrange transition">
                                </div>
                            </div>

                            <!-- Hàng 2: Email -->
                            <div class="flex flex-col space-y-1 w-full">
                                <label for="email" class="text-[11px] font-bold text-warmBrown uppercase tracking-wide">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" required placeholder="Địa chỉ email của bạn" class="w-full px-4 py-2.5 bg-[#FAF4EF]/50 border border-earthOrange/20 rounded-xl text-sm text-textMain outline-none focus:border-earthOrange transition">
                            </div>

                            <!-- Hàng 3: Nội dung (Giảm rows từ 5 xuống 4) -->
                            <div class="flex flex-col space-y-1 w-full">
                                <label for="message" class="text-[11px] font-bold text-warmBrown uppercase tracking-wide">Nội dung lời nhắn <span class="text-red-500">*</span></label>
                                <textarea id="message" name="message" required rows="4" placeholder="Bạn muốn HoaEm tư vấn về dịch vụ nào?" class="w-full px-4 py-2.5 bg-[#FAF4EF]/50 border border-earthOrange/20 rounded-xl text-sm text-textMain outline-none focus:border-earthOrange transition resize-none"></textarea>
                            </div>

                            <!-- Nút Gửi (Giảm padding cho cân đối) -->
                            <div class="pt-1 w-full">
                                <button type="submit" class="w-full sm:w-auto bg-earthOrange text-white px-8 py-3 rounded-full text-sm font-bold hover:bg-earthHover transition shadow-lg shadow-earthOrange/20 inline-flex items-center justify-center gap-2">
                                    <span>Gửi tin nhắn</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
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
                }, { threshold: 0.1 });
                document.querySelectorAll('.contact-body-wrapper .reveal-up').forEach(el => observer.observe(el));
            });
        </script>
    </main>
    <!-- KẾT THÚC PHẦN BODY TRANG LIÊN HỆ -->

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