<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * ここで、各Seederクラスを呼び出す
     * 各Seederクラスのrun()メソッドが実行される
     * 順番が大事:外部キー制約があるため、レシピテーブルを先に作成する必要がある
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            RecipesTableSeeder::class,
            StepsTableSeeder::class,
            IngredientsTableSeeder::class,
            ReviewsTableSeeder::class
        ]);
    }
}
