## イメージ
![image](https://github.com/risarisato/Laravel10_webApp/assets/88628553/fb0ab9e9-10e7-4eea-9d96-3f609c483c13)

## レビュー機能
- `sail php artisan make:controller ReviewController --resource`:レビュー用のコントローラー作成
- ログインしてないと投稿できない
- 自分の投稿にはレビューできない→解除してもおもしろいかも
- blade表示の`@`は特殊記号なので`&#64;`とやると表示できる
- タイポ＝＞　`<from`フロム　と `</form>`フォームに気を付けて！

## 編集機能
- update
    - `put`は１行まるまる更新
    - `patch`は１行の中のタイトルだけとか一部を更新
    - web.phpのpatchで、view側の編集画面の @methodが('PATCH')の箇所を探してupdateで更新される
#### AWS_S3に画像があるかないか判定する
```
// 更新用の空配列を作成
$update_array = [];
if ( $request->hasFile('image') ) {
    // 画像がある場合
    $image = $request->file('image'); // 画像ファイルを取得
    //dd($image);
    // s3に画像をアップロード
    $path = Storage::disk('s3')->putFile('recipe', $image, 'public');
    // dd($path);
    // s3のURLを取得
    $url = Storage::disk('s3')->url($path);
    // dd($url);
    // DBにURLを保存
    $update_array['image'] = $url;
}
Recipe::where('id', $id)->update($update_array); 
```

## セッション⑨レシピ投稿機能
- AWSアカウント作成：s3を使えるようにしておく
- `.env`に`AWS_ACCESS_KEY_ID`など値を入力する
- ストレージハザードを使ってS3にアップをする
    - `sail composer require league/flysystem-aws-s3-v3`
- 画面遷移をドラッグ＆ドロップでできるようにJSの`sortable`ライブラリを使用する
- 削除ボタンSVGにstep-deleteを`steps.addEventListener('click', function(evt)`にした
    - 親要素xmlnsと子要素pathの両方に || が条件にするとクリック反応が良くなった。
    - `if (evt.target.classList.contains('step-delete') || evt.target.closest('.step-delete')) {`
- `バックこーテンション`で囲むと、変数が使える！
```
step.innerHTML = `
        <p class="step-number w-16">手順${stepCount + 1}</p>
`;
```
- `sail composer require josegus/laravel-flash`:flashメッセージ
- バリデーション専用のクラスファイルを作ってLaravelバリデーション作成する
    - `sail php artisan make:request RecipeCreateRequest`
    - app\Http\Requests\RecipeCreateRequest.phpはvalidationファイル
- `sail php artisan lang:publish`で日本語化フォルダ
    - https://github.com/askdkc/breezejp jaとja.jsonをlangファイルでパスを通す

## ⑥レシピ一覧
- 省略
## ⑤レシピ投稿一覧表示ページ作成
- 51:パンくずリストは`sail composer require diglactic/laravel-breadcrumbs`からインストールが必要
    - https://github.com/diglactic/laravel-breadcrumbs

- 48:％あいまい検索％
- 47:カテゴリーテーブルはDBから取得する！コードを増やさくなていい！メリット
```
// カテゴリーテーブルから全てのデータを取得
$categories = Category::all()
// カテゴリーをwithメソッドでviewに渡す
return view('recipes.index', compact('recipes', 'categories'));
```
```
@foreach($categories as $category)
    <div>
        <!-- categoryのidを配列でないと受け取れないので、配列にする -->
        <input type="checkbox" name="categories[]" value="{{$category['id']}}" id="category{{$category['id']}}"/>
        <label for="category{{$category['id']}}">{{$category['name']}}</label>
    </div>
@endforeach
```
## ④home画面実装
- `sail php artisan make:controller RecipeController --resource`ですべてメソッド定義できる
    - `$recipes`と`$popular`を`Recipesテーブル`から`select`で抽出する
    - コントローラーからモデルを呼び出して、そのモデルが実際にデータを取る方法
### RecipeControllerで扱うモデルを作成する
- `sail php artisan make:model Recipe`
- `sail php artisan make:model Review`
- `sail php artisan make:model Category`
- `sail php artisan make:model Ingredient`
- `sail php artisan make:model Step`

#### {{ $slot }}でレイアウト継承
```
resources\views\layouts\app.blade.php
            <main>
                {{ $slot }}
            </main>
<x-app-layout>ここが共通になる</x-app-layout>
```

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
- https://dbdiagram.io/d/CookpadLaravel10-6517b108ffbf5169f0c5f3c0

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
