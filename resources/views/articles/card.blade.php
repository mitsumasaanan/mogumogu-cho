<div class="card mt-3">
    <div class="card-header d-flex flex-row">
        <a href="{{ route('users.show', ['name' => $article->user->name]) }}" class="text-dark">
            <i class="fas fa-user-circle fa-3x mr-1"></i>
        </a>
        <div>
            <div class="font-weight-bold">
                <a href="{{ route('users.show', ['name' => $article->user->name]) }}" class="text-dark">
                    {{ $article->user->name }}
                </a>
            </div>
            <div class="font-weight-lighter">{{ $article->created_at->format('Y/m/d H:i') }}</div>
        </div>
        @if( Auth::id() === $article->user_id )
        <!-- dropdown -->
        <div class="ml-auto card-text">
            <div class="dropdown">
                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route("articles.edit", ['article' => $article]) }}">
                        <i class="fas fa-pen mr-1"></i>記事を更新する
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $article->id }}">
                        <i class="fas fa-trash-alt mr-1"></i>記事を削除する
                    </a>
                </div>
            </div>
        </div>
        <!-- dropdown -->
    </div>

    <!-- modal -->
    <div id="modal-delete-{{ $article->id }}" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('articles.destroy', ['article' => $article]) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        {{ $article->title }}を削除します。よろしいですか？
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                        <button type="submit" class="btn btn-danger">削除する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal -->
    @endif

    <!-- </div> -->
    <div class="row">
        <div class="col-md-6">
            @forelse ($article->articleImgs as $articleImg)
            <img src="{{ asset('https://mogumogucho-bucket.s3.ap-northeast-1.amazonaws.com/'.$articleImg->img_path) }}" class="show-img">
            @empty
            <img src="{{ asset('https://mogumogucho-bucket.s3.ap-northeast-1.amazonaws.com/pf-images/no_image_square.jpeg')}}" class="show-img">
            @endforelse
        </div>
        <div class="col-md-6 card-body">
            <h3 class="h4 card-title">
                <a class="text-dark" href="{{ route('articles.show', ['article' => $article]) }}">
                    {{ $article->title }}
                </a>
            </h3>
            <div class="card-text my-3">
                {!! nl2br(e( $article->body )) !!}
            </div>
            <div class="card-text my-3">
                <article-like :initial-is-liked-by='@json($article->isLikedBy(Auth::user()))' :initial-count-likes='@json($article->count_likes)' :authorized='@json(Auth::check())' endpoint="{{ route('articles.like', ['article' => $article]) }}">
                </article-like>
            </div>
            @foreach($article->tags as $tag)
            @if($loop->first)
            <div class="card-text line-height">
                @endif
                <a href="{{ route('tags.show', ['name' => $tag->name]) }}" class="border p-1 mr-1 mt-1 text-muted">
                    {{ $tag->hashtag }}
                </a>
                @if($loop->last)
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>