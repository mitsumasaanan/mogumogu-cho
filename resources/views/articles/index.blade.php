@extends('app')

@section('title', '記事一覧')

@section('content')
@include('nav')
<img class="top-img" src="{{ asset('https://mogumogucho-bucket.s3.ap-northeast-1.amazonaws.com/pf-images/mogumogu_top_1280x847.jpg') }}">
<div class="top-message">
    <h3>あなただけのレシピを</h3>
    <div>もぐもぐ帳はあなたの得意料理のレシピを共有する場です。</div>
</div>
<div class="container">
    @include('search')
    @foreach($articles as $article)
    @include('articles.card')
    @endforeach
    <div class="mt-4">
        {{ $articles->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection