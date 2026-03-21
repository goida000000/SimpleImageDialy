@extends('layouts.common')

@section('content')
<div class="body_container">
    <h1>新規投稿</h1>

    @error('body')
        <div class="error">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('diaries.confirm') }}" enctype="multipart/form-data">
        @csrf
        @if(isset($diary))
            @method('PUT')
        @endif

        <!-- 画像 -->
        <div class="form-group">
            <label for="image">画像:</label>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">

            @error('image')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- テキスト入力 -->
        <div class="form-group">
            <label for="body">1行:</label>
            <input type="text" id="body" name="body" value="{{ old('body', $diary->body ?? '') }}">

            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="post">
            {{ isset($diary) ? '更新確認' : '確認する' }}
        </button>
    </form>
</div>
@endsection