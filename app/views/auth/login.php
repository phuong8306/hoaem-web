<?php
$error = isset($error) ? $error : null;
$username = isset($username) ? $username : '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - hoa&amp;em</title>
    
    <!-- Google Fonts: Be Vietnam Pro & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Nhúng Tailwind CSS qua CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Cấu hình bảng màu Cam đất ấm áp -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Be Vietnam Pro"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                        logo: ['"Dancing Script"', 'cursive'],
                    },
                    colors: {
                        earthOrange: '#C96F4E', // Cam đất chủ đạo
                        earthHover: '#b55f3e',  // Cam đất đậm khi hover
                        warmBrown: '#8B5E3C',   // Nâu ấm
                        customBeige: '#F3E7D9', // Beige viền
                        warmGray: '#686B6B',    // Chữ phụ
                        textMain: '#382A32',    // Chữ chính
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
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-earthOrange selection:text-white relative overflow-x-hidden">

    <!-- Nội dung Form Đăng nhập -->
    <main class="flex-grow flex items-center justify-center px-4 py-12 relative z-10">
        <div class="max-w-md w-full bg-white/95 backdrop-blur-md rounded-[2.5rem] p-8 md:p-10 shadow-lg border border-customBeige">
            
            <!-- Tiêu đề -->
            <div class="text-center mb-8">
                <span class="text-earthOrange text-sm font-bold tracking-widest uppercase">Chào mừng trở lại</span>
                <h1 class="font-serif text-3xl font-bold text-warmBrown mt-1">Đăng nhập tài khoản</h1>
                <span class="block text-xs text-earthOrange mt-1.5">✦ ── ✦ ── ✦</span>
            </div>

            <!-- Hiển thị thông báo lỗi nếu có -->
            <?php if (!empty($error)): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-sm font-medium text-center">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Form xử lý -->
            <form action="/auth/login" method="POST" class="space-y-5">
                
                <div>
                    <label class="block text-xs font-bold text-warmGray uppercase tracking-wider mb-2">Tên đăng nhập hoặc Email</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required 
                           class="w-full px-5 py-3.5 bg-customBeige/20 rounded-2xl border border-customBeige focus:outline-none focus:ring-2 focus:ring-earthOrange/40 focus:border-earthOrange text-sm text-textMain font-medium placeholder-gray-400 transition"
                           placeholder="Nhập tên đăng nhập của bạn...">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold text-warmGray uppercase tracking-wider">Mật khẩu</label>
                        <a href="/auth/forgot" class="text-xs font-semibold text-earthOrange hover:underline">Quên mật khẩu?</a>
                    </div>
                    
                    <!-- Ô nhập mật khẩu tích hợp nút ẩn/hiện -->
                    <div class="relative">
                        <input type="password" name="password" id="password-input" required 
                               class="w-full px-5 py-3.5 pr-12 bg-customBeige/20 rounded-2xl border border-customBeige focus:outline-none focus:ring-2 focus:ring-earthOrange/40 focus:border-earthOrange text-sm text-textMain font-medium placeholder-gray-400 transition"
                               placeholder="••••••••">
                        
                        <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-warmGray hover:text-earthOrange transition focus:outline-none">
                            <!-- Icon con mắt mặc định (Trạng thái ẩn mật khẩu) -->
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-earthOrange hover:bg-earthHover text-white py-4 rounded-2xl font-bold text-sm md:text-base transition shadow-md shadow-earthOrange/20 mt-2">
                    Đăng nhập
                </button>

            </form>

            <!-- Chuyển hướng sang trang đăng ký -->
            <div class="mt-8 text-center text-sm font-medium text-warmGray">
                Bạn chưa có tài khoản? 
                <a href="/auth/register" class="text-earthOrange font-bold hover:underline ml-1">Đăng ký ngay</a>
            </div>

        </div>
    </main>

    <!-- Footer nhỏ -->
    <footer class="w-full py-6 text-center text-warmGray/70 text-xs font-semibold z-10">
        &copy; <?= date('Y') ?> hoa&amp;em. Tất cả quyền được bảo lưu.
    </footer>

    <!-- JavaScript xử lý ẩn/hiện mật khẩu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password-input');
            const eyeIcon = document.getElementById('eye-icon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    if (type === 'text') {
                        // Icon con mắt mở (Hiển thị mật khẩu rõ chữ)
                        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                    } else {
                        // Icon con mắt gạch chéo (Ẩn mật khẩu thành dấu •••••)
                        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
                    }
                });
            }
        });
    </script>

</body>
</html>