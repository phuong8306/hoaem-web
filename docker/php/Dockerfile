FROM php:8.2-apache

# Kích hoạt URL Rewrite
RUN a2enmod rewrite

# Cài đặt các extension kết nối Database (PDO, MySQLi)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Chuyển DocumentRoot mặc định sang thư mục public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html