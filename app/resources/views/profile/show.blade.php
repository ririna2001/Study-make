@extends('layouts.app')


@section('content')
<div class="container">
    <h2 class="mb-4">マイプロフィール</h2>

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

       {{-- プロフィール画像（メイク講師のみ） --}}
       @if ($profile->instructor && $profile->$profile_image)
           <div class="mb-3">
               <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="プロフィール画像" style="max-width: 200px;">
           </div> 
       @endif

       {{-- 名前 --}}
       <div class="mb-3">
            <strong>■名前</strong>
            <p>{{ $profile->user->name }}</p>
        </div>

       {{-- 年齢 --}}
       <div class="mb-3">
            <strong>■年齢</strong>
            <p>{{ $profile->age }}</p>
        </div>

       {{-- 性別 --}}
       <div class="mb-3">
           <strong>■性別</strong>
           <p>{{ $profile->gender ?? '未設定' }}</p>
       </div>

       {{-- 職業 --}}
       <div class="mb-3">
           <strong>■職業</strong>
           <p>{{ $profile->occupation }}</p>
       </div>

       {{-- メールアドレス --}}
       <div class="mb-3">
           <strong>■メールアドレス</strong>
            <p>{{ $profile->user->email }}</p>
       </div>

       {{-- 顔タイプ --}}
       <div class="mb-3">
           <strong>■顔タイプ</strong>
           <p>{{ $profile->faceType->name ?? '未設定' }}</p>
       </div>

        {{-- パーソナルカラー --}}
       <div class="mb-3">
           <strong>■パーソナルカラー</strong>
           <p>{{ $profile->personalColor->name ?? '未設定' }}</p>
       </div>

{{-- 戻る・編集ボタン --}}
       <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('mypage.index') }}" class="btn btn-secondary">戻る</a>
            <a href="{{ route('profile.edit', $profile->id) }}" class="btn btn-primary">編集</a>
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