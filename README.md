# coachtech お問い合わせフォーム

## アプリケーション概要

お問い合わせフォームから送信された内容をデータベースへ保存し、管理画面から問い合わせ内容の確認・検索・削除を行うことができるお問い合わせ管理システムです。

---

## 使用技術

- PHP 8.2
- Laravel 10
- MySQL 8.4
- Laravel Sail
- Tailwind CSS 3.4
- Vite
- phpMyAdmin
- Docker

---

## 環境構築

### 1. Laravelプロジェクトの作成

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer create-project laravel/laravel:^10.0 coachtech-contact-form
```

### 2. プロジェクトディレクトリへ移動

```bash
cd coachtech-contact-form
```

### 3. Laravel Sailのインストール

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer require laravel/sail --dev
```

### 4. Sailの設定ファイルを作成

MySQLを選択してSailの設定ファイルを作成します。

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    php artisan sail:install --with=mysql
```

### 5. Sailの起動

```bash
sail up -d
```

### 6. NPM依存パッケージのインストール

```bash
sail npm install
```

### 7. Tailwind CSSのインストール

```bash
sail npm install -D tailwindcss@^3.4.0 postcss autoprefixer
```

### 8. Tailwind CSS設定ファイルの作成

```bash
sail npx tailwindcss init -p
```

### 9. Tailwind CSSのテンプレートパス設定

`tailwind.config.js`

```js
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
```

### 10. Tailwind CSSディレクティブの追加

`resources/css/app.css`

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### 11. Vite開発サーバーの起動

新しいターミナルを開いて実行します。

```bash
sail npm run dev
```

### 12. .envファイルの設定

`.env`

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

### 13. phpMyAdminの追加

`compose.yaml` または `docker-compose.yml` の `mysql` サービスの後に以下を追加します。

```yaml
phpmyadmin:
    image: "phpmyadmin:latest"
    ports:
        - "${FORWARD_PHPMYADMIN_PORT:-8080}:80"
    environment:
        PMA_HOST: mysql
        PMA_USER: "${DB_USERNAME}"
        PMA_PASSWORD: "${DB_PASSWORD}"
    networks:
        - sail
    depends_on:
        - mysql
```

### 14. Sailの再起動

```bash
sail down
sail up -d
```

### 15. アプリケーションキーの生成

```bash
sail artisan key:generate
```

### 16. Laravelの動作確認

ブラウザで以下にアクセスします。

```text
http://localhost
```

### 17. phpMyAdminの動作確認

ブラウザで以下にアクセスします。

```text
http://localhost:8080
```

ログイン情報

```text
ユーザー名：sail
パスワード：password
```

### 18. マイグレーションの実行

```bash
sail artisan migrate
```

---

## ER図

ER図を添付

---

## URL

### 開発環境

- Laravel：http://localhost
- phpMyAdmin：http://localhost:8080
