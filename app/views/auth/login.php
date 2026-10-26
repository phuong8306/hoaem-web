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

    <!-- Header đơn giản cho trang đăng nhập -->
    <header class="w-full bg-white/90 backdrop-blur-md border-b border-customBeige py-4 px-6 md:px-12 flex justify-between items-center z-10">
        <a href="/" class="flex items-center gap-2 group">
            <span class="text-2xl">🌸</span>
            <span class="font-serif text-2xl font-bold text-warmBrown tracking-tight group-hover:opacity-90 transition">hoa&amp;em</span>
        </a>
        <a href="/" class="text-sm font-semibold text-warmGray hover:text-earthOrange transition flex items-center gap-1">
            ← Quay về trang chủ
        </a>
    </header>

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
                    <input type="password" name="password" required 
                           class="w-full px-5 py-3.5 bg-customBeige/20 rounded-2xl border border-customBeige focus:outline-none focus:ring-2 focus:ring-earthOrange/40 focus:border-earthOrange text-sm text-textMain font-medium placeholder-gray-400 transition"
                           placeholder="••••••••">
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

</body>
</html>