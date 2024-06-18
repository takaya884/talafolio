# localhost起動コマンド
``` bash
# docker起動(バックグランド)
 ./vendor/bin/sail up -d
 or
 docker compose up -d

# docker停止
 ./vendor/bin/sail down
or
docker compose down

# dockerビルド
docker compose build

# dockerキャッシュクリア
docker compose build --no-cache

# フロントエンドリソースビルド
npm run dev
```


# 開発環境構築メモ
``` bash
# Laravelプロジェクトインストール
curl -s "https://laravel.build/プロジェクト名" | bash

# Githubにソース管理追加
https://tech.amefure.com/web-github-laravel-push

# Breezeをインストール
./vendor/bin/sail composer require laravel/breeze

# Breezeのインストールが完了したら、Breezeのインストールスクリプトを実行
./vendor/bin/sail artisan breeze:install

# データベースをマイグレーション
./vendor/bin/sail artisan migrate

# Userモデル作成
./vendor/bin/sail artisan make:model Models\\User
```


# エラー対処
``` bash
# tailwindcssモジュールをインストール(PostCSSの設定が正しく読み込めていない場合)
npm install tailwindcss

# .envのAPP_KEYを生成(Laravelプロジェクトに暗号化キーが未設定)
php artisan key:generate

# SQLSTATE[HY000] [2002] Connection refused
# ログイン時に、上記のエラーが発生。ターミナルからmysqlに接続できないからpasswordが間違ってる可能性がある。
```

# つまづいたポイント
``` bash
# bladeにtailwindcssを適用できなかった
　　　　</head>の上に
@vite(['resources/css/app.css', 'resources/js/app.js'])を追加する

```
