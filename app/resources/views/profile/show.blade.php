@extends('layouts.app')


@section('content')
<div class="container">
    <h2 class="mb-4">マイプロフィール編集</h2>

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
            <p>{{ $profile->name }}</p>
        </div>

       {{-- 年齢 --}}
       <div class="mb-3">
            <strong>■年齢</strong>
            <p>{{ $profile->age }}</p>
        </div>

       {{-- 性別 --}}
       <div class="mb-3">
           <strong>■性別</strong>
           <p>
             @if($profile->gender === 'male')
             男性
             @elseif($profile->gender === 'female')
             女性
            </p>
       </div>

       {{-- 職業 --}}
       <div class="mb-3">
           <strong>■職業</strong>
           <p>{{ $profile->job }}</p>
       </div>

       {{-- メールアドレス（編集不可） --}}
       <div class="mb-3">
           <strong">■メールアドレス</strong>
            <p>{{ $user->email }}</p>

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
            <a href="{{ route('mypage.index') }}" class="btn btn-secondary">← 戻る</a>
            <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-primary">編集</a>
       </div>
</div>
@endsection