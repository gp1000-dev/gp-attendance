# Laravel実習 勤怠管理システム（gp-attendance）

## システムの概要

Laravelの実習として、GIFT PLACEの勤怠管理システムを作成していきます。

- Dockerによる動作環境もプロジェクトに含まれます。

## 前提

下記がインストールされていること。

- WSL2（Windowsの場合）
- Docker
- PHP （8.0以上推奨）
- composer
- npm （sassコンパイルする場合。後でもいい）

## 環境構築

作業フォルダにて下記を実行する。

1. GitHubよりプロジェクトをダウンロード

    ```bash
    git clone git@github.com:gp1000-dev/gp-attendance.git
    cd gp-attendance
    ```

1. .env.sample ファイルをコピーし、.env ファイルを生成する。

    ```bash
    cp .env.sample .env
    ```

1. 必要があれば .env ファイルを編集する。

    - HTTPポートは8880を使用するので、別プロジェクトと競合する場合は.envファイルの下記部分を書き換える。

        ```
        APP_URL=http://localhost:8880
        APP_PORT=8880
        ```

1. composer実行

    PHPパッケージをインストールする。

    ```bash
    composer install
    ```

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

    テーブルの構築と初期データの投入を行う。Dockerコンテナが起動した状態で行う）。

    ```bash
    php artisan migrate:fresh --seed
    ```

## 動作確認

1. ブラウザで http://localhost:8880 にアクセスし、トップページの表示を確認する。

1. Login画面でテストユーザーでログインできることを確認する。（seederによりユーザーのデータが作成されている）

   - email: creator1@example.com
   - password: P@ssw0rd
