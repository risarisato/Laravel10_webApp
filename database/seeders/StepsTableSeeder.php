<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // レシピテーブルからレシピIDを取得して配列に格納
        $recipes = DB::table('recipes')->pluck('id')->toArray();

        // レシピテーブルからレシピIDを取得して配列に格納
        foreach ($recipes as $recipeId) {
            // レビューテーブルにダミーデータを挿入
            $numberOfSteps = rand(3, 6);

            // レビューテーブルにダミーデータを挿入
            for ($i = 1; $i <= $numberOfSteps; $i++) {
                DB::table('steps')->insert([
                    'recipe_id' => $recipeId,
                    'step_number' => $i,
                    // Str::random()で、ランダムな文字列を生成
                    'description' => 'Step ' . $i . ' description for recipe ' . $recipeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}