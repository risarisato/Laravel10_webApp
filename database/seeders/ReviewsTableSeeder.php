<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // レシピテーブルからレシピIDを取得して配列に格納
        $recipes = DB::table('recipes')->pluck('id')->toArray();
        // ユーザーテーブルからユーザーIDを取得して配列に格納
        $users = DB::table('users')->pluck('id')->toArray();
        // コメントの種類を配列に格納
        $comments = ['うまうま素晴らしいレシピ！', '気に入ったかんじ！', 'またやってみるなりー', '好きでないーよ', '簡単に作れて美味しいかも'];

        // レシピテーブルからレシピIDを取得して配列に格納
        foreach ($recipes as $recipe) {
            // レビューテーブルにダミーデータを挿入
            for ($i = 0; $i < rand(1, 3); $i++) { 
                // レビューテーブルにダミーデータを挿入
                DB::table('reviews')->insert([
                    // Str::uuid()で、ランダムなIDを生成
                    'user_id' => $users[array_rand($users)],
                    // array_rand()で、配列の中からランダムな値を取得
                    'recipe_id' => $recipe,
                    // rand()で、ランダムな数値を生成
                    'rating' => rand(1, 5),
                    // array_rand()で、配列の中からランダムな値を取得
                    'comment' => $comments[array_rand($comments)],
                    // now()で、現在時刻を取得
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}