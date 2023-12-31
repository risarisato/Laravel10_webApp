<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe; // Recipeモデルを使えるようにする
use App\Models\Category; // Categoryモデルを使えるようにする

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
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
