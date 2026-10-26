CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    price DECIMAL(12,0) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    description TEXT,
    stock INT DEFAULT 0,
    active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, slug, price, stock) VALUES
('Bó hoa hồng đỏ', 'bo-hoa-hong-do', 350000, 10),
('Giỏ hoa hướng dương', 'gio-hoa-huong-duong', 450000, 5),
('Hộp hoa tulip', 'hop-hoa-tulip', 550000, 8);