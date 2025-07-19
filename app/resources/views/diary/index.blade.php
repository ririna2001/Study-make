@extends('layouts.app')

@section('content')
<div class="container">

   {{-- フラッシュメッセージ --}}
   @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

   {{-- 絞り込み --}}
    <div class="d-flex justify-content-center align-items-center min-vh-100">
       <form method="GET" action="{{ route('diary.index') }}" class="w-75">
          <div class = "filter-box" >

            投稿日
            <input type="date" name="date_from" value="{{ request('date_from') }}">
            ～
            <input type="date" name="date_to" value="{{ request('date_to') }}">

            <br>

            キーワード
            <input type="text" name="keyword" placeholder="キーワード" value="{{ request('keyword') }}">

            <button type="submit" class="btn btn-primary">検索</button>
            <a href="{{ route('diary.index') }}" class="btn btn-secondary">リセット</a>
          </div>
       </form>
    </div>



    {{-- 一覧 --}}
    <ul class="list-group">
      @foreach($diaries as $diary)
        <li class="list-group-item d-flex justify-content-between align-item-center">
              <div>
                <small>{{ $diary->created_at->format('y/m/d') }}</small>
                <strong>{{ $diary->title }}</strong>
              </div>
              <a href="{{ route('diary.show', $diary->id) }}" class="btn btn-outline-primary">▶</a>
        </li>
      @endforeach
  </ul>

   <a href="{{ route('mypage.user') }}" class="btn btn-secondary">← 戻る</a>

    {{-- ページネーション --}}
    <div class="pagination mt-4">
        {{ $articles->links() }}
    </div>

   <a href="{{ route('diary.create') }}" class="btn btn-secondary">新規作成</a>

</div>
<script>
    // ページ読み込み後、10秒でフェードアウトして非表示にする
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500); 
            }, 10000); 
        }
    });
</script>
@endsection





















</div>