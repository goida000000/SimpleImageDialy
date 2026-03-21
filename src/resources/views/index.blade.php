<!DOCTYPE html>
<html>
    <head>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="body_container">
            <h1>日記一覧</h1>

            <a href="/diaries/create" class="link-button new">新規投稿</a>

            @foreach($diaries as $diary)

            <div class="diary-item">

                <!-- 上段 -->
                <div class="diary-header">
                    <div class="diary-date">
                        投稿日：{{ $diary->created_at->format('Y/m/d H:i') }}
                    </div>

                    <div class="diary-actions">
                        <a href="/diaries/{{ $diary->id }}/edit" class="link-button edit">編集</a>

                        <form method="POST" action="/diaries/{{ $diary->id }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete">削除</button>
                        </form>
                    </div>
                </div>

                <!-- 下段 -->
                <div class="diary-body">
                    @if($diary->image_path)
                        <img src="/storage/{{ $diary->image_path }}" class="diary-image">
                    @endif

                    <p class="diary-text">{{ $diary->body }}</p>
                </div>

            </div>

            @endforeach

            <div class="d-flex justify-content-center mt-4">
                {{ $diaries->links() }}
            </div>
        </div>
    </body>
</html>
