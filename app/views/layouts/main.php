<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'hoa&em') ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a href="/" class="logo">hoa&amp;em</a>
            <nav class="nav">
                <a href="/">Trang chủ</a>
                <a href="/san-pham">Sản phẩm</a>
                <a href="/gio-hang">Giỏ hàng</a>
                <a href="/dang-nhap">Đăng nhập</a>
            </nav>
        </div>
    </header>

    <main class="site-main">
        <div class="container">
            <?= $content ?>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> hoa&amp;em — Chuyện hoa, chuyện mình.</p>
        </div>
    </footer>
</body>
</html>