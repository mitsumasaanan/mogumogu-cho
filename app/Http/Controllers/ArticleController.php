<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleImg;
use App\Tag;
use App\Comment;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SearchRequest;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index()
    {
        $articles = Article::with('user', 'articleImgs')->orderBy('created_at', 'desc')->paginate(5);
        $tags = Tag::orderBy('id', 'asc')->get();

        return view('articles.index', ['articles' => $articles], ['tags' => $tags]);
    }

    public function create()
    {
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.create', ['allTagNames' => $allTagNames,]);
    }

    public function store(ArticleRequest $request, Article $article, ArticleImg $article_img)
    {
        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $article->save();

        if ($request->hasFile('article_img')) {
            $article_img = $request->file('article_img');
            $url = Storage::disk('s3')->putFile('pf-images', $article_img, 'public');
            $article->articleImgs()->create(['img_path' => $url]);
        }

        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        $tagNames = $article->tags->map(function ($tag) {
            return ['text' => $tag->name];
        });

        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.edit', [
            'article' => $article,
            'tagNames' => $tagNames,
            'allTagNames' => $allTagNames,
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all())->save();

        $article->tags()->detach();
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }

    public function show(Article $article)
    {
        $articleImgs = Article::with('articleImgs')->get();
        return view('articles.show', compact('article', 'articleImgs'));
    }

    public function like(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    public function search(SearchRequest $request, Article $article)
    {
        // 検索結果を代入
        $searchData = $article->search($request);

        // 期とカテゴリーの検索範囲を定義したメソッドの戻り値を代入
        $searchRanges = $article->searchRange();

        return view('articles.index', $searchData, $searchRanges);
    }
}
