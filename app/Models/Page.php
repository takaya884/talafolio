<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Note; // Noteモデルをインポート

class Page extends Model
{
    use HasFactory;

    /**
     * 一括代入可能な属性
     */
    protected $fillable = [
        'user_id',
        'note_id',
        'page_title',
        'page_contents',
    ];

    /**
     * このページが属するノートを取得
     */
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
