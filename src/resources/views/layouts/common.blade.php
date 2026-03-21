<!DOCTYPE html>
<html>
    <head>
        <title>日記アプリ</title>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        @if (!request()->routeIs('diaries.index'))
            <link href="{{ asset('css/post.css') }}" rel="stylesheet">
        @endif
    </head>
    <body>

        <div class="body_container">

            @if (!request()->routeIs('diaries.index') || request()->get('page') > 1)
                <div class="back-link">
                    <a href="{{ route('diaries.index') }}">← トップへ戻る</a>
                </div>
            @endif

            {{-- ページごとの中身 --}}
            @yield('content')

        </div>

    </body>
</html>