<?php
class Database {
    public $pdo;

    public function __construct() {
        $host = 'db';          // Tên dịch vụ (service name) của MySQL là db
        $port = '3306';        
        $dbname = 'hoavaem';   // Tên database là hoavaem
        $username = 'root';      
        $password = 'root';    // Mật khẩu root là root

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