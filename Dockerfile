FROM php:8.2-apache

# 必要な PHP 拡張をインストール
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Composer インストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Laravel アプリのコピー
COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Apache の設定（Laravel 用）
RUN chown -R www-data:www-data /var/www/html \
&& a2enmod rewrite

# ポート指定
EXPOSE 8083

# Apache のドキュメントルートを Laravel の public に変更
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
