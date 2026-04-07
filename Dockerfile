# 使用 PHP 8.1 + Apache 镜像
FROM php:8.1-apache

# 安装数据库扩展（如果不需要可以删掉）
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

# 启用 Apache 重写模块
RUN a2enmod rewrite

# 设置 Apache 的 DocumentRoot 到 public 目录（如果你的入口在 public 里）
# 如果你的 index.php 在根目录，就删掉下面这行
# RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# 设置工作目录
WORKDIR /var/www/html

# 复制所有代码
COPY . /var/www/html

# 暴露端口
EXPOSE 80

# 启动 Apache
CMD ["apache2-foreground"]