@extends('layouts.app')

@section('content')
<div class="container">
    <h2>マイページ</h2>

    {{-- フラッシュメッセージ --}}

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif



 <div class="container">

    {{-- メインカードエリア --}}
    <div class="row text-center">

    {{-- 記事 --}}
  


    {{-- お気に入り数 --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-4">
            <div style="font-size: 40px;">⭐</div>
             <p class="mt-2">総お気に入り数：<strong>{{ $totalFavorites }}</strong></p>
                <a href="{{ route('favorites.index') }}" class="btn btn-outline-primary mt-2">お気に入り</a>
            </div>
        </div>

    {{-- お知らせ --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-4">
            <div style="font-size: 40px; position: relative;">
                    ✉
    {{-- 未読数がある場合だけ表示 --}}
            @if($unreadCount > 0)
                <span class="badge bg-danger" style="position: absolute; top: -10px; right: -10px;">
                     {{ $unreadCount }}
                </span>
            @endif
            </div>
              <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary mt-2">お知らせ</a>
        </div>
    </div>


    {{-- プロフィール --}}
    <div class="col-md-6 mb-4">
            <div class="card shadow-sm p-4">
                <div style="font-size: 40px;">👤</div>
                <a href="{{ route('profile.show', ['profile' => auth()->guard('instructor')->user()->profile->id])}}" class="btn btn-outline-primary mt-2">プロフィール</a>
            </div>
        </div>
    </div>

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

