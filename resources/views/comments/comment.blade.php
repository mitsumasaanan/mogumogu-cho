@if(Auth::check())
<div class="row">
    <div class="col-md-8">
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
                <button type="submit" class="btn base-bg">
                    コメントを送信
                </button>
            </div>
        </form>
        @endif
        <div class="mb-5">
            <div class="border-bottom mt-3">
                <h3>コメント</h3>
            </div>
            @forelse($article->comments as $comment)
            <div class="dropdown"><i class="fas fa-user mr-2 text-dark"></i>
                {{ $comment->user->name }}（投稿日時：{{ $comment->created_at }} ）
                @if( Auth::id() === $comment->user_id )
                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route("comments.edit", ['comment' => $comment]) }}">
                        <i class="fas fa-pen mr-1"></i>コメントを更新する
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $comment->id }}">
                        <i class="fas fa-trash-alt mr-1"></i>コメントを削除する
                    </a>
                </div>
                @endif
            </div>
            <div id="modal-delete-{{ $comment->id }}" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('comments.destroy', ['comment' => $comment]) }}">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                このコメントを削除します。よろしいですか？
                            </div>
                            <div class="modal-footer justify-content-between">
                                <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                                <button type="submit" class="btn btn-danger">削除する</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <p>　{{ $comment->comment }}</p>
            <hr class="mb-0">
            @empty
            <p>コメントはありません</p>
            @endforelse
        </div>
    </div>
</div>