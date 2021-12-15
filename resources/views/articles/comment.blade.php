@if(Auth::check())
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form method="POST" action="{{ route('comments.store') }}">
                @csrf
                <div class="mt-3">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <label for="comment">コメントする <i class="fas fa-pen"></i></label>
                    <textarea id="comment" type="text" name="comment" class="form-control" rows="5">{{ old('comment') }}</textarea>
                </div>
                <div class="text-danger">
                    <p>{{ $errors->first('comment') }}</p>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        コメントを送信
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-5">
                <div class="border-bottom mt-3">
                    <h3>コメント</h3>
                </div>

                @forelse($article->comments as $comment)
                <p><i class="fas fa-user mr-2 text-dark"></i>{{ $comment->user->name }}（投稿日時：{{ $comment->created_at }} ）</p>
                <p>　{{ $comment->comment }}</p>
                <hr class="mb-0">
                @empty
                <p>コメントはありません</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>