<?php
session_start();

// --- 1. LỚP DATABASE & VIEW KẾT NỐI CHUẨN ---
if (!class_exists('Database')) {
    class Database {
        public $pdo;
        public function __construct() {
            $host = 'hoaem-db';
            $port = '3306';
            $dbname = 'hoavaem';
            $username = 'root';
            $password = 'root';
            
            try {
                $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
                $this->pdo = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("<h3 style='color:red; text-align:center; margin-top:50px;'>Lỗi kết nối CSDL: " . $e->getMessage() . "</h3>");
            }
        }
    }
}

if (!class_exists('View')) {
    class View {
        public static function render($viewName, $data = []) {
            extract($data);
            $viewFile = __DIR__ . '/../app/views/' . $viewName . '.php';
            if (!file_exists($viewFile)) {
                $viewFile = __DIR__ . '/app/views/' . $viewName . '.php';
            }
            
            if (file_exists($viewFile)) {
                ob_start();
                require_once $viewFile;
                $content = ob_get_clean();

                if (strpos($viewName, 'admin/') === 0) {
                    echo $content;
                } else {
                    $layoutFile = __DIR__ . '/../app/views/layouts/main.php';
                    if (!file_exists($layoutFile)) {
                        $layoutFile = __DIR__ . '/app/views/layouts/main.php';
                    }

                    if (file_exists($layoutFile)) {
                        require_once $layoutFile;
                    } else {
                        echo $content;
                    }
                }
            } else {
                echo "<h3 style='color:red;'>Không tìm thấy tệp giao diện: views/{$viewName}.php</h3>";
            }
        }
    }
}

// --- 2. GỌI ROUTER ĐIỀU HƯỚNG ---
require_once __DIR__ . '/../core/Router.php';
$router = new Router();
$router->dispatch();