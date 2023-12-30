<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 追加で論理削除を使えるようにする

class Recipe extends Model
{
    use HasFactory;
    use SoftDeletes; // 追加で論理削除を使えるようにする

    /**
     * idをuuidに変更したため
     * uuidだとstring型になるので、明示的にキャストを追加した
     */
    protected $casts = [
        'id' => 'string'
    ];

    public function category()
    {
       return $this->belongsTo(Category::class);
       //一つのレシピに対して一つのカテゴリーしかないので、1対1の関係
       //return $this->hasOne(Category::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    //public function reivews() AIの勘違いでした。reviewsです。
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
