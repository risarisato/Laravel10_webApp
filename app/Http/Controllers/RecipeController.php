<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe; // Recipeモデルを使えるようにする
use App\Models\Category; // Categoryモデルを使えるようにする
use App\Models\Ingredient; // Ingredientモデルを使えるようにする
use Illuminate\Support\Str; // Strクラスを使えるようにする
use Illuminate\Support\Facades\Auth; // Authクラスを使えるようにする
use Illuminate\Support\Facades\Storage; // Storageクラスを使えるようにする
use App\Models\Step; // Stepモデルを使えるようにする
use Illuminate\Support\Facades\DB; // DBクラスを使えるようにする
use App\Http\Requests\RecipeCreateRequest; // RecipeCreateRequestクラスを使えるようにする
use App\Http\Requests\RecipeUpdateRequest; // 編集のバリデーションを適用させる


class RecipeController extends Controller
{

    //コントローラーからモデルを呼び出して、データ取得≠直接DBにアクセスはNG
    public function home()
    {
        $recipes = Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.image', 'users.name')
            ->join('users', 'recipes.user_id', '=', 'users.id') // usersテーブルと結合
            ->orderBy('recipes.created_at', 'desc') // 作成日時の降順:新しい順
            ->limit(3) // 3件だけ取得
            ->get(); // get()は、データを取得するメソッド
        
        //dd($recipes);

        $popular = Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.image', 'recipes.views', 'users.name')
            ->join('users', 'recipes.user_id', '=', 'users.id')
            ->orderBy('recipes.views', 'desc') // viewの多い順=人気順
            ->limit(2)
            ->get();

        //dd($popular);

        // view関数の第2引数にcompact関数を使うと、連想配列のキーと同じ名前の変数をviewに渡せる
        return view('home', compact('recipes', 'popular'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all(); // リクエストパラメータを全て取得
        //dd($filters);

        $query = Recipe::query()->select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.image', 'users.name', \DB::raw('AVG(reviews.rating) as rating')) // レビューの平均値を取得
            ->join('users', 'recipes.user_id', '=', 'users.id') // usersテーブルと結合
            ->leftjoin('reviews', 'recipes.id', '=', 'reviews.recipe_id') // レビューテーブルと結合
            ->groupBy('recipes.id') // レシピIDでグループ化
            ->orderBy('recipes.created_at', 'desc'); // 作成日時の降順:新しい順

        if ( !empty($filters) ) {
            // もし、カテゴリーが選択されていたら
            if ( !empty($filters['categories']) ) {
                // カテゴリーで絞り込み選択されたカテゴリーIDが含まれているレシピを取得
                $query->whereIn('recipes.category_id', $filters['categories']);
            }

            if ( !empty($filters['rating']) ) {
                // レビューの平均値で絞り込み：指定されたレビューの平均値以上のレシピを取得
                $query->havingRaw('AVG(reviews.rating) >= ?', [$filters['rating']]);
            }

            if ( !empty($filters['title']) ) {
                // タイトルで絞り込み：％あいまい検索％
                $query->where('recipes.title', 'like', '%'.$filters['title'].'%');
            }
        }
        //$recipes = $query->get();
        // ページネーションを使う
        $recipes = $query->paginate(5); // 1ページに6件表示
        
        //dd($recipes);

        // カテゴリーテーブルから全てのデータを取得
        $categories = Category::all();

        // カテゴリーをwithメソッドでviewに渡す
        return view('recipes.index', compact('recipes', 'categories', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // カテゴリーテーブルから全てのデータを取得

        return view('recipes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecipeCreateRequest $request)
    {
        $posts = $request->all(); // リクエストパラメータを全て取得
        //dd($posts['steps']);
        $uuid = Str::uuid()->tostring(); // UUIDを生成
        //dd($posts);
        $image = $request->file('image'); // 画像ファイルを取得
        //dd($image);
        // s3に画像をアップロード
        $path = Storage::disk('s3')->putFile('recipe', $image, 'public');
        // dd($path);
        // s3のURLを取得
        $url = Storage::disk('s3')->url($path);
        // dd($url);
        // DBにURLを保存
        //dd($recipe);

        // トランザクション処理(Transaction)を行う
        try {
            DB::beginTransaction(); // トランザクション開始
            Recipe::insert([
                //'id' => \Str::uuid(), // \はuse文を使わずにクラスを呼び出す方法
                'id' => $uuid, // \はuse文を使わずにクラスを呼び出す方法
                'title' => $posts['title'],
                'description' => $posts['description'],
                'category_id' => $posts['category'],
                //'user_id' => \Auth::id(), // ログインしているユーザーのIDを取得
                'image' => $url, // シングルクォーテーションにする！
                'user_id' => Auth::id() // \Auth::id()は、use文を使わずにクラスを呼び出す方法
            ]);
            $ingredients = []; // 空の配列を作成
            foreach($posts['ingredients'] as $key => $ingredient){
                $ingredients[$key] = [
                    'recipe_id' => $uuid, // レシピID
                    'name' => $ingredient['name'], // 材料名
                    'quantity' => $ingredient['quantity'] // 分量
                ];
            }
            Ingredient::insert($ingredients); // 材料を保存
            $steps = []; // 空の配列を作成
            foreach($posts['steps'] as $key => $step){
                $steps[$key] = [
                    'recipe_id' => $uuid, // レシピID
                    'step_number' => $key + 1, // 順番
                    'description' => $step // 手順
                ];
            }
            STEP::insert($steps); // 手順を保存
            DB::commit(); // トランザクション確定
        } catch (\Throwable $th) {
            DB::rollback(); // トランザクション取り消し
            \Log::debug(print_r($th->getMessage(), true)); // ログにエラーを残す
            throw $th; // 例外を投げる
        }
        //dd($steps);
        flash()->success('レシピを投稿しました(^^♪'); // フラッシュメッセージを表示
        return redirect()->route('recipe.show', ['id' => $uuid]); // レシピ詳細ページにリダイレクト
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $recipe = Recipe::with(['ingredients', 'steps', 'reviews.user', 'user'])
            ->where('recipes.id', $id)
            //->get();
            ->first(); // 1件だけ取得するので、first()を使う

        //$recipe = $recipe[0]; // 1件だけ取得するので、配列の0番目を取得これはオブジェクトなので、配列に変換する
        $recipe_recode = Recipe::find($id); // レシピIDでレシピを取得
        $recipe_recode->increment('views'); // 閲覧数を1増やす
        //$ingredients = Ingredient::where('recipe_id', $recipe['id'])->get(); // レシピIDで材料を取得
        //$steps = Step::where('recipe_id', $recipe['id'])->get(); // レシピIDで手順を取得
        //dd($recipe);

        // 投稿者とログインユーザーが一致しているかどうかを判定
        $is_my_recipe = false; // 初期値はfalse
        if ( Auth::check() && (Auth::id() === $recipe['user_id'] )) {
            $is_my_recipe = true; // 投稿者とログインユーザーが一致していればtrue
        }
        // 投稿できるのは1回まで
        $is_reviewed = false; // 初期値はfalse
        if ( Auth::check() ) {
            $is_reviewed = $recipe->reviews->contains('user_id', Auth::id()); // レビュー済みかどうかを判定
            
            // やってることは、下記のコードと同じ
            // containsメソッドは、コレクションの中に指定した値が含まれているかどうかを判定する
            //foreach($recipe->reviews as $review) {
            //    if ( $review->user_id === Auth::id() ) {
            //        $is_reviewed = true; // レビュー済みならtrue
            //    }
            //}
        }

        return view('recipes.show', compact('recipe', 'is_my_recipe', 'is_reviewed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $recipe = Recipe::with(['ingredients', 'steps', 'reviews.user', 'user'])
            ->where('recipes.id', $id)
            ->first()->toArray(); // 1件だけ取得するので、first()を使う

             // 投稿者とログインユーザーが一致しているかどうかを判定
        if( !Auth::check() || (Auth::id() !== $recipe['user_id']) ) {
            abort(403); // 403表示：他人の人のレシピのURLにeditでアクセスできないようにする
            
        }
        $categories = Category::all();
        
        return view('recipes.edit', compact('recipe', 'categories'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(RecipeUpdateRequest $request, string $id)
    {
        $posts = $request->all(); // リクエストパラメータを全て取得
        //dd($posts);
        // 更新用の空配列を作成
        $update_array = [
            'title' => $posts['title'],
            'description' => $posts['description'],
            'category_id' => $posts['category_id']
        ];
        // AWS S3に画像有る無しの分岐処理
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
        try {
            DB::beginTransaction(); // トランザクション開始
            Recipe::where('id', $id)->update($update_array); // $update_arrayでレシピを更新
            Ingredient::where('recipe_id', $id)->delete(); // 材料を削除
            STEP::where('recipe_id', $id)->delete(); // 手順を削除
            $ingredients = []; // 空の配列を作成
            foreach($posts['ingredients'] as $key => $ingredient){
                $ingredients[$key] = [
                    'recipe_id' => $id, // レシピID
                    'name' => $ingredient['name'], // 材料名
                    'quantity' => $ingredient['quantity'] // 分量
                ];
            }
            Ingredient::insert($ingredients); // 材料を保存
            $steps = []; // 空の配列を作成
            foreach($posts['steps'] as $key => $step){
                $steps[$key] = [
                    'recipe_id' => $id, // レシピID
                    'step_number' => $key + 1, // 順番
                    'description' => $step // 手順
                ];
            }
            STEP::insert($steps); // 手順を保存
            DB::commit(); // トランザクション確定
        } catch (\Throwable $th) {
            DB::rollback(); // トランザクション取り消し
            \Log::debug(print_r($th->getMessage(), true)); // ログにエラーを残す
            throw $th; // 例外を投げる
        }
        flash()->success('レシピをトランザクション処理で更新しました(^^♪'); // フラッシュメッセージを表示

        return redirect()->route('recipe.show', ['id' => $id]); // レシピ詳細ページにリダイレクト
    }

    // レシピを削除
    public function destroy(string $id)
    {
        Recipe::where('id', $id)->delete();
        //やっていることは、論理削除と同じ
        //Recipe::where('recipe_id', $id)->update(['deleted_at' => now()]);

        // フラッシュメッセージを表示
        flash()->warning('レシピを削除しました。サヨナラ～。。。'); 

        return redirect()->route('recipe.index'); // レシピ一覧ページにリダイレクト
    }
}
