#!/bin/bash
set -e

# 必要な権限を設定
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 明示的にPHP-FPMを実行
exec php-fpm