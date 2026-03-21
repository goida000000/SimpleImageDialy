<!DOCTYPE html>
<html>
    <head>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/post.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="body_container">
            <h1>新規投稿</h1>

            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{ isset($diary) ? '/diaries/'.$diary->id : '/diaries' }}" enctype="multipart/form-data">
                @csrf
                @if(isset($diary))
                    @method('PUT')
                @endif

                <!-- テキスト入力 -->
                <div class="form-group">
                    <label for="body">1行:</label>
                    <input 
                        type="text" 
                        id="body"
                        name="body" 
                        value="{{ old('body', $diary->body ?? '') }}"
                    >

                    @error('body')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 画像 -->
                <div class="form-group">
                    <label for="image">画像:</label>
                    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">

                    @error('image')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="post">
                    {{ isset($diary) ? '更新' : '投稿' }}
                </button>
            </form>
        </div>
    </body>
</html>
