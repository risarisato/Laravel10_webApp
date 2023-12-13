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
}
