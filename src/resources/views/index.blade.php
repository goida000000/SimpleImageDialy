@extends('layouts.common')

@section('content')
<!-- 画像拡大用モーダル -->
<script src="{{ asset('js/imageModal.js') }}"></script>
<div id="image-modal" class="image-modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modal-image">
</div>

<div class="body_container">
    <h1>日記一覧</h1>

    <a href="{{ route('diaries.create') }}" class="link-button new">新規投稿</a>

    @foreach($diaries as $diary)

    <div class="diary-item">

        <!-- 上段 -->
        <div class="diary-header">
            <div class="diary-date">
                投稿日：{{ $diary->created_at->format('Y/m/d H:i') }}
            </div>

            <div class="diary-actions">
                <a href="{{ route('diaries.edit', $diary->id) }}" class="link-button edit">編集</a>

                <form method="POST" action="{{ route('diaries.destroy', $diary->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete">削除</button>
                </form>
            </div>
        </div>

        <!-- 下段 -->
        <div class="diary-body">
            @if($diary->image_path)
                <img 
                    src="{{ asset('storage/' . $diary->image_path) }}" 
                    class="diary-image preview-image"
                >
            @else
                <div class="no-image">No Image</div>
            @endif

            <p class="diary-text">{{ $diary->body }}</p>
        </div>

    </div>

    @endforeach

    <div class="d-flex justify-content-center mt-4">
        {{ $diaries->links() }}
    </div>
</div>
@endsection