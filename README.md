## ③共通のheader作成
- `resources\views\layouts\app.blade.php`が前ページ共通のレイアウト
　　- `@include('layouts.announce-header')`でログイン状態を読み込ませる
    - `@include('layouts.global-header')`でロゴを読み込ませる
    - resources\views\layouts\announce-header.blade.phpを作成
    - `<x-app-layout>`の`x`があれば何かしら読み込んでいる
- 波括弧２つはphp記述になる。route関数にするとpathが変わっても読み込める
- `<a href="{{route('profile.edit')}}" class="ml-auto">マイページ</a>`
- `<a href="http://localhost/profile" class="ml-auto">マイページ</a>`


## ②データベース準備
- UUIDのライブラリ(composer)を使いIDインクリメントをuuidにする
    - `sail composer require goldspecdigital/laravel-eloquent-uuid:^10.0`
    - 1⃣`sail php artisan make:migration create_categories_table `
    - 2⃣`sail php artisan make:migration create_recipes_table`
    - 3⃣`sail php artisan make:migration create_ingredients_table`
    - 4⃣`sail php artisan make:migration create_steps_table`
    - 5⃣`sail php artisan make:migration create_reviews_table`
- constrained()は外部キー制約を設定するメソッド。
- cascadeは親テーブルのレコードが削除されたら、子テーブルのレコードも削除する。
- `sail php artisan migrate:rollback`
- `sail php artisan migrate`

### ダミーデータの作成
- 1`sail php artisan make:seeder UsersTableSeeder`
- 2`sail php artisan make:seeder CategoriesTableSeeder`
- 3`sail php artisan make:seeder RecipesTableSeeder`
- 4`sail php artisan make:seeder IngredientsTableSeeder'
- 5`sail php artisan make:seeder StepsTableSeeder'
- 6`sail php artisan make:seeder ReviewsTableSeeder`
    - database\seeders\DatabaseSeeder.phpのrun()でダミーデータが実行される
- 実行`sail php artisan db:seed` 
https://dbdiagram.io/d/CookpadLaravel10-6517b108ffbf5169f0c5f3c0

## ①作業
- Dockerコマンドで、laravelsail/php81-composer:latestイメージを実行
  - `docker run -it -v $(pwd):/opt -w /opt laravelsail/php81-composer:latest /bin/bash`
  - `composer create-project 'laravel/laravel:10.*' Laravel10_webApp`
- Laravel10_webAppという名前のLaravelプロジェクト作成
- `php artisan sail:install`コマンド実行
- エイリアスの登録
    - cd でホームに行く
    - vi .bashrc
    - `alias sail=vendor/bin/sail`が`sail up -d`でOK
- 会員登録・ログイン機能の開発のために、laravel/breezeパッケージをsailコンテナに追加
- sail php artisan breeze:installコマンドを実行
- sail php artisan migrateコマンドを実行
