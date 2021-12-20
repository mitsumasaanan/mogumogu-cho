<?php

namespace Tests\Feature;

use App\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedByNull()
    {
        $article = factory(Article::class)->create();

        $result = $article->isLikedBy(null);

        $this->assertFalse($result);
    }

    public function testGuestUpdate()
    {
        $article = factory(Article::class)->create();

        $response = $this->get(route("articles.edit", ['article' => $article]));

        $response->assertRedirect(route('login'));
    }
}
