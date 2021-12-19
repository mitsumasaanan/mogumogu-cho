<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'body',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    public function isLikedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }

    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function searchRange()
    {
        return [
            'tags' => Tag::all(),
        ];
    }

    public function search($request)
    {
        // バリデーション済みのリクエストパラメーターの連想配列
        $search = [
            'tag' => intval($request->tag),
            'word' => $request->word,
        ];

        // リクエストパラメーターに該当するレコードの取得
        $articles = $this->query()
            ->when($search['tag'], function ($q) use ($search) {
                return $q->where('id', $search['tag']);
            })
            ->when($search['word'], function ($q) use ($search) {
                return $q->where('title', 'like', '%' . $this->escapeLike($search['word']) . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // 検索結果とページング時に検索条件を保持するための配列を値に持つ連想配列
        $searchData = [
            'articles' => $articles,
            'retentionParams' => [
                'tag' => $search['tag'] ?? null,
                'word' => $search['word'] ?? null,
            ],
        ];

        return $searchData;
    }

    public static function escapeLike($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }

    public function articleImgs()
    {
        return $this->hasMany(ArticleImg::class);
    }
}
