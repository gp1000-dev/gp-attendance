# Laravel実習 勤怠管理システム（gp-attendance）

## 概要

Laravelの実習として、GIFT PLACEの勤怠管理システムを作成していきます。

## 内容

- 勤怠管理システムソース（Laravel）
- Docker動作環境
    - Nginx
    - PHP-FPM
    - MySQL（ノーマル＆テスト用）
    - Mailhog（メール送信テストサーバ）

## 前提

下記が設定・インストールされていること。

- Linux/Unix開発環境
    - Windows：WSL2（Ubuntu）、curlのインストール
    - Mac：HomeBrew
- Docker
- PHP
    - デフォルトでインストールされる7.4.xでOKだが、できれば8.0以上推奨。
    - WSL2の場合、合わせてphp-dom、php-mysqlライブラリもインストールしておく。
        ```bash
        sudo apt install -y php php-dom php-curl php-mysql
        ```
- composer
- npm （sassコンパイルする場合。後でもいい）

## 環境構築

作業フォルダにて下記を実行する。

1. GitHubよりプロジェクトをダウンロード

    ```bash
    git clone git@github.com:gp1000-dev/gp-attendance.git
    cd gp-attendance
    ```

1. .env.example ファイルをコピーし、.env ファイルを生成する。

    ```bash
    cp .env.example .env
    ```

1. 必要があれば .env ファイルを編集する。

    - HTTPポートは8880を使用するので、別プロジェクトと競合する場合は.envファイルの下記部分を書き換える。

        ```
        APP_URL=http://localhost:8880
        APP_PORT=8880
        ```

1. composerを実行し、PHPパッケージをインストールする。

    ```bash
    composer install
    ```

1. APPキーを生成する。

    ```bash
    php artisan key:generate
    ```

    -  これを行わないと起動時に「No application encryption key has been specified.」エラーが表示される。

1. Docker環境構築

    初回、及びenvファイルdocker設定が変更された場合に実行する。

    ```bash
    docker-compose build
    ```

1. Dockerコンテナの起動

    ```bash
    docker-compose up -d
    ```

    - 正しく動作しない場合は -d を付けないで動かしログを確認

1. migrationとseeederの実行

    Dockerコンテナ上で、テーブルの構築と初期データの投入を行う。

    ```bash
    docker-compose exec php-fpm bash
    php artisan migrate
    php artisan db:seed
    exit
    ```

## 動作確認

1. ブラウザで http://localhost:8880 にアクセスし、トップページの表示を確認する。

1. Login画面でテストユーザーでログインできることを確認する。（seederによりユーザーのデータが作成されている）

    - email: creator1@example.com
    - password: P@ssw0rd

1. Mailhog（メールテストサーバ）の動作確認

    - ブラウザで http://localhost:8025 にアクセス
