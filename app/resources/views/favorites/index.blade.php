@extends('layouts.app')

@section('content')
<div class="container">

    {{-- タイトル --}}
    <h2 class="mb-4 text-center">お気に入り記事一覧ページ</h2>

    {{-- フラッシュメッセージ（10秒で消える） --}}
    @if (session('success'))
        <div class="alert alert-success" id="flash-message">
            {{ session('success') }}
        </div>
    @endif

    {{-- 検索・絞り込み --}}
    <form method="GET" action="{{ route('favorites.index') }}" class="mb-4 border p-3 rounded">
        <div class="mb-2">
            <label>キーワード</label>
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control">
        </div>

        <div class="mb-2">
            <label>講師名</label>
            <input type="text" name="instructor" value="{{ request('instructor') }}" class="form-control">
        </div>

        <br>

        <div class="mb-2">
            <label>投稿日</label><br>
            <input type="date" name="date_from" value="{{ request('date_from') }}">
            〜
            <input type="date" name="date_to" value="{{ request('date_to') }}">
        </div>

        <div class="mb-2">
            <label>顔タイプ</label>
            <select name="face_type" class="form-select">
                <option value="">選択してください</option>
            </select>
        </div>

        <div class="mb-2">
            <label>パーソナルカラー</label>
            <select name="personal_color" class="form-select">
                <option value="">選択してください</option>
            </select>
        </div>

        <br>

        <div class="d-flex justify-content-between">
            <a href="{{ route('favorites.index') }}" class="btn btn-secondary">リセット</a>
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </form>

    {{-- 一覧テーブル --}}
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>記事タイトル</th>
                <th>講師</th>
                <th>お気に入り</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($favorites as $index => $favorite)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $favorite->article->title }}</td>
                    <td>{{ $favorite->article->instructor->name ?? '―' }}</td>
                    <td class="text-center">
                    <form method="POST" action="{{ route('favorites.toggle', $article->id) }}">
                        @csrf
                        <button type="submit"
                                class="btn btn-link p-0 border-0 bg-transparent"
                                title="お気に入り切り替え">
                            {{-- 好きな表示方法を選択 --}}
                            @if($isFav)
                                <span style="font-size:1.3rem;">❤️</span>
                            @else
                                <span style="font-size:1.3rem;">🤍</span>
                            @endif
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    {{-- 戻るボタン --}}
    <div class="mt-4 text-center">
        <a href="{{ route('mypage.index') }}" class="btn btn-secondary">←戻る</a>
    </div>
</div>

{{-- フラッシュメッセージ自動非表示 --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            setTimeout(() => {
                flash.style.transition = 'opacity 0.5s ease';
                flash.style.opacity = '0';
                setTimeout(() => flash.style.display = 'none', 500);
            }, 10000); // 10秒後に非表示
        }
    });
</script>
@endsection
