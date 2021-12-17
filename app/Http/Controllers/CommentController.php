<?php

namespace App\Http\Controllers;

use App\User;
use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Comment $comment)
    {
        $comment->fill($request->all())->save();
        $article = Article::find($request->article_id);
        //return redirect()->route('article.show', compact('article'));
        return redirect()->back();
    }

    public function edit(Comment $comment)
    {
        return view('comments.edit', ['comment' => $comment]);
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->fill($request->all())->save();
        return redirect()->route('articles.show', ['article' => $comment->article_id]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back();
    }
}
