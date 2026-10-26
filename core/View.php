<?php
class View {
    public static function render($viewPath, $data = []) {
        extract($data);
        $file = '../app/views/' . $viewPath . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "Lỗi: Không tìm thấy View tại " . $file;
        }
    }
}