<?php
class Router {
    protected $controller = 'HomeController';
    protected $action = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Kiểm tra tồn tại và gán Controller
        if (isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }
        
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Kiểm tra Action (hàm trong Controller)
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->action = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];
        
        // Gọi hàm và truyền tham số
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    public function parseUrl() {
        // Fix lỗi chuỗi rỗng trên PHP 8+
        if (isset($_GET['url']) && rtrim($_GET['url'], '/') !== '') {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return ['home']; 
    }
}