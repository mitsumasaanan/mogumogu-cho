<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    //いいねされているかを判定するメソッドのテスト
    public function testIsLikedByNull()
    {
        $article = factory(Article::class)->create();

        $result = $article->isLikedBy(null);

        $this->assertFalse($result);
    }

    //いいねされているかを判定するメソッド
    public function testIsLikedByTheUser()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $article->likes()->attach($user);

        $result = $article->isLikedBy($user);

        $this->assertTrue($result);
    }

    //いいねをしていないケースのテスト
    public function testIsLikedByAnother()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();
        $article->likes()->attach($another);

        $result = $article->isLikedBy($user);

        $this->assertFalse($result);
    }

    //ログイン前ユーザーが記事更新ページに行くとログイン画面にリダイレクトされるかテスト
    public function testGuestUpdate()
    {
        $article = factory(Article::class)->create();

        $response = $this->get(route("articles.edit", ['article' => $article]));

        $response->assertRedirect(route('login'));
    }
}
