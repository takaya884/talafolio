<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * 一括代入可能な属性
     */
    protected $fillable = [
        'user_id',
        'note_title',
    ];

    /**
     * このノートに関連するページを取得
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
