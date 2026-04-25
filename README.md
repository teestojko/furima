# furima

PHP/Laravel/Reactを用いて、多機能かつUI/UXを重視したネットショッピングアプリ

## 作成した目的

・自社独自のECサイトの運営を目的とし、ジャンルを問わず販売が可能なアプリ

・累計登録者数100万人を目標とする

## 構成

- PHP 8.2
- Laravel 10.x
- Nginx
- MySQL 8.0
- phpMyAdmin
- MailHog

## 必要条件

- Docker
- Docker Compose
- Make

## セットアップ手順

### 1. リポジトリのクローン

```bash
git clone git@github.com:teestojko/furima.git
cd furima
```

### 2. 環境構築

以下のコマンドで環境構築を行います：

```bash
make install
```

`make install` コマンドは以下の処理を自動的に実行します：

- Docker イメージのビルド (`make build`)
- コンテナの起動 (`make up`)
- .env ファイルの作成
- データベース設定の変更
- 権限設定
- データベースのマイグレーションとシード (`make fresh`)

## アクセス情報

- Laravel: http://localhost:8000
- phpMyAdmin: http://localhost:8080
  - サーバー: mysql
  - ユーザー名: root
  - パスワード: root_password

## データベース接続情報

- ホスト: mysql (内部ネットワーク) または localhost (ホストマシンから)
- ポート: 3306
- データベース名: laravel
- ユーザー名: laravel_user
- パスワード: password

## Make コマンド一覧

このプロジェクトでは以下の Make コマンドが利用可能です：

| コマンド              | 説明                                             |
| --------------------- | ------------------------------------------------ |
| `make install`        | 環境のビルド、起動、初期設定を行います           |
| `make build`          | Docker イメージをビルドします                    |
| `make up`             | コンテナを起動します                             |
| `make stop`           | コンテナを停止します                             |
| `make down`           | コンテナを削除します                             |
| `make down-v`         | コンテナとボリュームを削除します                 |
| `make restart`        | コンテナを再起動します                           |
| `make destroy`        | 全てのイメージ、コンテナ、ボリュームを削除します |
| `make tinker`         | Laravel の tinker を実行します                   |
| `make test`           | テストを実行します                               |
| `make migrate`        | マイグレーションを実行します                     |
| `make fresh`          | データベースをリフレッシュしシーディングします   |
| `make seed`           | シーディングを実行します                         |
| `make optimize`       | キャッシュを最適化します                         |
| `make optimize-clear` | 最適化キャッシュをクリアします                   |
| `make cache`          | 各種キャッシュを生成します                       |
| `make cache-clear`    | 各種キャッシュをクリアします                     |
| `make pint`           | コードスタイルを整形します                       |

## 初期設定スクリプト (init.sh)

環境構築の過程で実行される `init.sh` スクリプトは以下の処理を行います：

- Composer の依存関係のインストール
- Laravel アプリケーションキーの生成
- データベース接続設定の変更
- Mailhog 設定の適用
- ストレージディレクトリの権限設定

## 開発作業の開始

環境構築後、以下のコマンドでコンテナを起動または停止できます：

```bash
# コンテナを起動
make up

# コンテナを停止
make stop
```

## 機能一覧

### ユーザー

・fortifyログイン機能

・メール認証機能

・レビュー機能

・stripe決済機能

・商品出品、購入機能

・クーポン、ポイント割引機能

・商品検索機能

### 管理者

・クーポン作成機能

・カテゴリー用CRUD機能

・通報一覧管理機能

