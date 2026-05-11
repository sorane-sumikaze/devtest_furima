![CI](https://github.com/sorane-sumikaze/devtest_furima/actions/workflows/ci.yml/badge.svg?branch=main)

# coachtech_furima

## このアプリについて

- 仮想のフリマサイト「COACHTECH フリマ」を構築した。

- この作成物はCOACHTECH 実践学習タームの模擬案件開発実習によるものである。与えられた機能要件書・デザイン案に従って作業を行った。応用機能まで実装。
- 作業内容：アプリケーションの基本設計、DB設計、コーディング、動作テストの実装
- 実装期間：2026年3月27日〜同4月25日、同5月9日〜5月10日

## 技術スタック

### アプリケーション

![PHP](https://img.shields.io/badge/PHP-8.5.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12.53.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![nginx](https://img.shields.io/badge/nginx-1.29.5-009639?style=for-the-badge&logo=nginx&logoColor=white)


### 開発基盤

![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![GitHub Actions](https://img.shields.io/badge/GitHub%20Actions-CI-2088FF?style=for-the-badge&logo=github-actions&logoColor=white)
![mailhog](https://img.shields.io/badge/mailhog-1.0.1-952225?style=for-the-badge&logo=Gmail&logoColor=white)

## 環境構築手順

### 前提

- Git、Docker（Docker Compose 同梱）がインストール済みであること。
- Docker Desktop が起動していること。

### 1. リポジトリのクローンと Docker ビルド

```shell
git clone https://github.com/halpha1503/coachtech_furima
cd coachtech_furima
docker-compose up -d --build
cp src/.env.example src/.env
```

### 2. .env の編集

(1) .envに以下のDB・API情報を設定する。

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
(2) Stripe APIの動作確認試験を実施する場合には、各自のお手元のStripeアカウントでサンドボックス用のキーを取得し、.envに記入すること。
```
STRIPE_PUBLIC_KEY={your_key_here}
STRIPE_SECRET_KEY={your_key_here}
```

### 3. Laravel 環境のセットアップ

```shell
docker-compose exec php bash
```

```shell
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
```

---

## 開発環境 URL

| 用途       | URL                    |
| ---------- | ---------------------- |
| メイン画面 | http://localhost/      |
| phpMyAdmin | http://localhost:8080/ |
| mailhog    | http://localhost:8025/ |

---

## ER図

<img src=erd.drawio.png>

---

## ディレクトリ構成

<!-- 主要なディレクトリのみ記載する。全ファイルの列挙は不要 -->

```
{{ 例:
src/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   ├── Models/
│   └── Services/
├── resources/
│   ├── views/
│   └── css/
└── database/
    ├── migrations/
    ├── factories/
    └── seeders/
}}
```
