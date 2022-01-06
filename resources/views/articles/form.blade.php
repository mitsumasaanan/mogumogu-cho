@csrf
<div class="md-form">
    <label>タイトル</label>
    <input type="text" name="title" class="form-control" required value="{{ $article->title ?? old('title') }}">
</div>
<div class="form-group">
    <article-tags-input :initial-tags='@json($tagNames ?? [])' :autocomplete-items='@json($allTagNames ?? [])'> </article-tags-input>
</div>
<div class="form-group">
    <label></label>
    <textarea name="body" required class="form-control" rows="16" placeholder="本文">{{ $article->body ?? old('body') }}</textarea>
</div>
<div class="form-group">
    <label>画像投稿</label>
    <input id="article_img" type="file" name="article_img">
    <p class="small text-muted">ファイル形式はjpg、png、gifにしてください。</p>
</div>
<div class="form-group">
    <input type="text" name="url" class="form-control" placeholder="参考URL" required value="{{ $article->url ?? old('url') }}">
</div>