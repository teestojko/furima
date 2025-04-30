FROM php:8.3.8-fpm

# カスタムphp.iniファイルをPHPの設定ディレクトリにコピー
COPY php.ini /usr/local/etc/php/

# パッケージリストを更新し、必要なツールやライブラリをインストール
RUN apt update \
  && apt install -y \
      curl \
      git \
      unzip \
      zip \
      default-mysql-client \
      zlib1g-dev \
      libzip-dev \
      libpng-dev \
      libjpeg-dev \
      libfreetype6-dev \
      gnupg \
      ca-certificates \
      lsb-release \
      software-properties-common \
  # GD拡張をJPEGとFreetype対応で構成
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  # 必要なPHP拡張（MySQL、zip、GD）をインストール
  && docker-php-ext-install pdo_mysql zip gd \
  # 不要なキャッシュなどを削除してイメージサイズを削減
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Node.js v20のセットアップスクリプトを取得して実行
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
  # Node.jsとnpmをインストール
  && apt-get install -y nodejs \
  # npmの最新版をインストール（バグ修正や機能追加に対応）
  && npm install -g npm@latest

# Composer（PHPのパッケージ管理ツール）をインストール
RUN curl -sS https://getcomposer.org/installer | php \
  # composerをグローバルに使えるようパスを通す
  && mv composer.phar /usr/local/bin/composer \
  # Composerの最新版に更新
  && composer self-update \
  # キャッシュをクリアして容量削減
  && composer clear-cache

# 作業ディレクトリを /var/www に設定（Laravelのソース配置先）
WORKDIR /var/www

# エントリーポイントスクリプトをコンテナ内にコピー
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
# スクリプトに実行権限を付与
RUN chmod +x /usr/local/bin/entrypoint.sh

# コンテナ起動時に実行するスクリプトを指定
ENTRYPOINT ["entrypoint.sh"]
