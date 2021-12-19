<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleImg extends Model
{
    protected $fillable = [
        'img_path',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
