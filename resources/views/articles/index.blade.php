@extends('app')

@section('title', '記事一覧')

@section('content')
@include('nav')
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