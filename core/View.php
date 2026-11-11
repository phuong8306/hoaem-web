<?php
class View {
    public static function render($viewPath, $data = []) {
        extract($data);
        $file = '../app/views/' . $viewPath . '.php';
        
        if (!file_exists($file)) {
            echo "Lỗi: Không tìm thấy View tại " . $file;
            return;
        }

        // 1. Gom nội dung của trang view vào bộ đệm
        ob_start();
        require $file;
        $content = ob_get_clean();

        // 2. Nếu là trang admin thì hiển thị trực tiếp giao diện quản trị
        if (strpos($viewPath, 'admin/') === 0) {
            echo $content;
        } else {
            // 3. Các trang frontend sẽ tự động được bọc vào layout tổng main.php
            $layoutFile = '../app/views/layouts/main.php';
            if (file_exists($layoutFile)) {
                require_once $layoutFile;
            } else {
                echo $content;
            }
        }
    }
}