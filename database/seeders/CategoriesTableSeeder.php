<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * このダミーデータを作成する
     * run()メソッドで、カテゴリーのダミーデータを作成
     * insert()メソッドで、カテゴリーのダミーデータをデータベースに挿入
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'メイン'],
            ['name' => '副菜'],
            ['name' => 'デザート'],
        ];
        foreach ($categories as $c) {
            DB::table('categories')->insert($c);
        }
    }
}
