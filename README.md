# デプロイするブランチはmasterとする
``` bash
git branch master #ブランチ確認コマンド
```

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

# artisanコマンド
``` bash
# 一般的なコマンド
php artisan list - 利用可能なすべてのArtisanコマンドを表示
php artisan --version - Laravelのバージョンを表示
php artisan serve - 開発用サーバーを起動
php artisan tinker - Tinker対話型シェルを起動

# 生成コマンド
php artisan make:controller ControllerName - コントローラを生成
php artisan make:model ModelName - モデルを生成
php artisan make:migration MigrationName - マイグレーションファイルを生成
php artisan make:seeder SeederName - シーダーファイルを生成
php artisan make:middleware MiddlewareName - ミドルウェアを生成
php artisan make:command CommandName - カスタムArtisanコマンドを生成

# データベース関連
php artisan migrate - マイグレーションを実行
php artisan migrate:rollback - 最後のマイグレーションをロールバック
php artisan db:seed - シーダーを実行

# キャッシュとオプティマイズ
php artisan cache:clear - アプリケーションキャッシュをクリア
php artisan config:cache - 設定ファイルをキャッシュ
php artisan route:cache - ルート定義をキャッシュ
php artisan view:cache - ビューをキャッシュ
php artisan optimize - アプリケーションを最適化

# その他
php artisan route:list - 定義されているすべてのルートを表示
php artisan storage:link - public/storageシンボリックリンクを作成
php artisan vendor:publish - ベンダーのアセットを公開
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

## Vue.js（Composition API）によるSPA化対応（2024年6月対応）

- **フロントエンドをVue3（Composition API）＋ViteでSPA化**
  - `resources/js/app.ts` をエントリーポイントにSPA構成
  - ルーティングは `vue-router` で管理
  - 状態管理は `pinia` を導入
  - 認証・API通信はLaravelバックエンドの既存コントローラーを活用
- **主な画面・機能**
  - ログイン画面（SPA化）
  - ダッシュボード画面（青基調のデザインに刷新）
  - メモ、ニュース、セッション、メール、Cron管理画面（SPAルーティング対応）
- **デザイン**
  - ヘッダー・ダッシュボードを青系グラデーションでモダンに
  - Tailwind CSSでスタイリング
- **起動方法**
  1. 依存パッケージインストール  
     `npm install --legacy-peer-deps`
  2. Vite開発サーバー起動  
     `npm run dev`
  3. Docker（Laravelサーバー）は別途起動しておくこと
  4. ブラウザで [http://localhost:5173](http://localhost:5173) にアクセス

---

## 今回のSPA化対応で編集・追加した主なファイル一覧

- `resources/js/app.ts`  
  Vue3 SPAエントリーポイント。ルーティングやPinia導入、画面遷移の制御を実装。
- `resources/js/App.vue`  
  全体レイアウト・ナビゲーションバー（ヘッダー）・ユーザー名表示・ログアウト処理など。
- `resources/js/views/Dashboard.vue`  
  ダッシュボード画面。青基調のデザインに刷新し、各機能・新規ユーザー作成へのリンクカードを配置。
- `resources/js/views/auth/Login.vue`  
  ログイン画面。中央配置・大きめ・青基調でモダンなデザインに。
- `resources/js/views/auth/Register.vue`  
  新規ユーザー登録画面。バリデーション・エラー表示・登録API連携。
- `resources/js/views/memo/Index.vue`  
  メモ機能画面（SPAルーティング用のプレースホルダー）。
- `resources/js/views/news/Index.vue`  
  ニュース機能画面（SPAルーティング用のプレースホルダー）。
- `resources/js/views/session/Index.vue`  
  セッション管理画面（SPAルーティング用のプレースホルダー）。
- `resources/js/views/email/Index.vue`  
  メール送信画面（SPAルーティング用のプレースホルダー）。
- `resources/js/views/cron/Index.vue`  
  Cron管理画面（SPAルーティング用のプレースホルダー）。
- `routes/api.php`  
  認証・ユーザー登録・各種APIルートの追加。
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`  
  API用ログイン・ログアウトメソッド追加。
- `app/Http/Controllers/Auth/RegisteredUserController.php`  
  API用ユーザー登録メソッド追加。
- `resources/views/layouts/app.blade.php`  
  SPA用にViteエントリーポイントを修正。
- `package.json` `tsconfig.json` `vite.config.js`  
  Vue3, Vite, TypeScript, Pinia, vue-router などSPA用依存パッケージ導入・設定。

---

