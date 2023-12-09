<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // レシピテーブルからレシピIDを取得して配列に格納
        $categories = DB::table('categories')->pluck('id')->toArray();
        // ユーザーテーブルからユーザーIDを取得して配列に格納
        $users = DB::table('users')->pluck('id')->toArray();

        // 画像の種類を配列に格納
        $image_types = ['food', 'recipe', 'cooking', 'dinner', 'lunch', 'breakfast', 'healthy', 'delicious', 'tasty', 'cake', 'coffee'];

        for ($i = 0; $i < 20; $i++) {
            // レシピテーブルにダミーデータを挿入
            DB::table('recipes')->insert([
                // Str::uuid()で、ランダムなIDを生成
                'id' => Str::uuid(),
                // array_rand()で、配列の中からランダムな値を取得
                'user_id' => $users[array_rand($users)],
                // array_rand()で、配列の中からランダムな値を取得
                'category_id' => $categories[array_rand($categories)],
                // Str::random()で、ランダムな文字列を生成
                'title' => 'Recipe of ' . Str::random(10),
                // Str::random()で、ランダムな文字列を生成
                'description' => 'This is a sample recipe description for ' . Str::random(10),
                // https://source.unsplash.com/random/?foodからランダムな画像を取得
                'image' => 'https://source.unsplash.com/random/?' . $image_types[rand(0, 10)],
                // rand()で、ランダムな数値を生成
                'views' => rand(0, 500),
                // now()で、現在時刻を取得
                'created_at' => now(),
                // now()で、現在時刻を取得
                'updated_at' => now(),
            ]);
        }
    }
}
