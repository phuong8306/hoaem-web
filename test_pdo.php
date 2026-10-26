<?php
$host = 'hoaem-db';
$port = '3306';
$dbname = 'hoavaem'; // Hoặc 'mvc_db' tùy ý cậu
$username = 'root';
$password = 'root'; // Khớp với MYSQL_ROOT_PASSWORD: root trong docker-compose.yml

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "<h2 style='color:green; text-align:center; margin-top:50px;'>🎉 KẾT NỐI THÀNH CÔNG THÀNH CÔNG RỰC RỠ!</h2>";
} catch (PDOException $e) {
    echo "<h2 style='color:red; text-align:center; margin-top:50px;'>❌ LỖI KẾT NỐI: " . $e->getMessage() . "</h2>";
}