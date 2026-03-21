@extends('layouts.common')

@section('content')
<div class="body_container">
    <h1>確認画面</h1>

    <!-- 画像 -->
    <div class="form-group">
        <label>画像:</label>

        @if(!empty($image_path))
            <img src="{{ asset('storage/' . $image_path) }}" class="diary-image">
        @else
            <div class="no-image">No Image</div>
        @endif
    </div>

    <!-- テキスト -->
    <div class="form-group">
        <label>1行:</label>
        <div class="confirm-value">
            {{ $body }}
        </div>
    </div>

    <div class="confirm-actions">
        <!-- 戻る -->
        <form method="GET" action="{{ isset($diary_id) ? route('diaries.edit', $diary_id) : route('diaries.create') }}">
            <button type="submit" class="back">戻る</button>
        </form>

        <!-- 登録 / 更新 -->
        <form method="POST" action="{{ isset($diary_id) ? route('diaries.update', $diary_id) : route('diaries.store') }}">
            @csrf

            @if(isset($diary_id))
                @method('PUT')
            @endif

            <input type="hidden" name="body" value="{{ $body }}">
            <input type="hidden" name="image_path" value="{{ $image_path }}">

            <button type="submit" class="post">
                {{ isset($diary_id) ? '更新' : '登録' }}
            </button>
        </form>
    </div>
</div>
@endsection