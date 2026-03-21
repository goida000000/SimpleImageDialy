# SimpleImageDialy - README

## 概要

シンプルな1行日記Webアプリ
　・画像はjpg,jpeg,png,web,webp,gifをアップロード可能
　・また、画像をアップロードしないで文章のみでの投稿も可能
　・文章は20文字以内の制限有り

Docker: 4.64.0
php: 8.5.4
Laravel: 13.1.1
MySQL: 9.6.0

---

# 環境構築手順

## ① Dockerコンテナ起動

```bash
docker-compose up -d --build
```

## ② Laravelと依存関係インストール

```bash
docker-compose exec app composer install
```

## ③ envファイルの設定

```bash
docker-compose exec app cp .env.example .env
```

設定内容

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=diary
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

## ④ アプリケーションキーの作成

```bash
docker-compose exec app php artisan key:generate
```

## ⑤ DB設定 & マイグレーション

```bash
docker-compose exec app php artisan migrate
```

## ⑥ ストレージリンク作成（画像表示用）

```bash
docker-compose exec app php artisan storage:link
```

---

# 各種アクセスリンク

* メイン画面
  http://localhost:8000

---

# テスト実行方法

## ① テスト用DB準備（SQLite）

```bash
cd src
touch database/testing.sqlite
```

## ② `.env.testing` 設定

```env
APP_ENV=test

DB_CONNECTION=sqlite
DB_DATABASE=database/testing.sqlite

SESSION_DRIVER=file
CACHE_STORE=array
QUEUE_CONNECTION=sync
```

## ③ phpunit.xml 内容変更

DB_CONNECTIONとDB_DATABASEが以下の値になっていること

```xml
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value="database/testing.sqlite"/>
```

## ④ キャッシュクリア

```bash
docker-compose exec app php artisan config:clear
```

## ⑤ テスト実行

```bash
docker-compose exec app php artisan test
```

---

# テスト内容

* 一覧ページ表示確認
* 日記投稿処理
* バリデーション（20文字制限）
* 日記削除処理

---

# トラブルシューティング

## ❗ no such table エラー

```text
no such table: diaries
```

原因：

* テストDBにマイグレーション未適用

対策：

* `RefreshDatabase` を使用
* DB設定を確認

---

## ❗ APP_KEY エラー

```text
No application encryption key has been specified
```

対策：

```bash
docker-compose exec app php artisan key:generate --env=testing
```

---

# 補足

* テスト環境ではDB・セッション・キャッシュの依存を減らすことで安定性を向上
* 実務でもSQLite（ファイル）＋RefreshDatabaseの構成が一般的

---