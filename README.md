## ②データベース準備
- 


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
