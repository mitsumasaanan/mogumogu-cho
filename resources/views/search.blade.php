<form class="d-flex align-items-center mt-4" action="{{ route('articles.search') }}">
    <select name="tag" id="tag" class="form-control" style="border-radius: 0.25rem 0 0 0.25rem;">
        <option value=''></option>
        @foreach($tags as $tag)
        @if($tag->id === ($retentionParams['tag'] ?? ''))
        <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
        @else
        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endif
        @endforeach
    </select>
    <input placeholder="フリーワード" type="text" name="word" id="word" maxlength="100" class="form-control" value="{{ $retentionParams['word'] ?? '' }}" style="border-radius: unset">
    <button type="submit" class="btn base-bg text-white d-block mx-auto blue-gradient" style="border-radius: 0 0.25rem 0.25rem 0; border: 1px solid #ced4da;height: 40px;">
        <i class="fa fa-search d-flex justify-content-center"></i>
    </button>
</form>