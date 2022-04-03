# Laravel実習 勤怠管理システム（gp-attendance）

## システムの概要

Laravelの実習として、GIFT PLACEの勤怠管理システムを作成していきます。

- Dockerによる動作環境もプロジェクトに含まれます。

## 前提

下記がインストールされていること。

- WSL2環境（Windowsの場合）
- Docker
- PHP （8.0以上推奨）
- composer

## インストール方法

作業フォルダにて下記を実行する。

1. GitHubよりプロジェクトをダウンロード

    ```bash
    git clone git@github.com:gp1000-dev/gp-attendance.git
    ```

1. .env.sample ファイルをコピーし、.env という名前で生成する。

    ```bash
    cd gp-attendance
    cp .env.sample .env
    ```

1. 必要があれば .env ファイルを編集する。

    - HTTPポートは8880を使用します。別プロジェクトと重複する場合は.envファイルの下記部分を書き換えてください。

        ```
        APP_URL=http://localhost:8880
        APP_PORT=8880
        ```

## 実行

1. docker-composeの環境構築

    初回、及び.envファイルdocker設定が変更された場合のみ）

    ```bash
    docker-compose build
    ```

1. dockerコンテナの起動

    ```bash
    docker-compose up -d
    ```

    - 正しく動作しない場合は -d を付けないで動かしログを確認

1. ブラウザで http://localhost:8880 にアクセス
