<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    /**
     * idをuuidに変更したため
     * uuidだとstring型になるので、明示的にキャストを追加した
     */
    protected $casts = [
        'id' => 'string'
    ];
}
