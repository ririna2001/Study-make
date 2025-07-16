@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">マイプロフィール確認</h2>

    <form action="{{ route('profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
       @csrf
       @method('PUT')

       {{-- プロフィール画像（メイク講師のみ） --}}
       @if ($profile->instructor && $profile->$profile_image)
           <div class="mb-3">
               <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="プロフィール画像" style="max-width: 200px;">
           </div> 
       @endif

       {{-- 名前 --}}
       <div class="mb-3">
            <strong>■名前</strong>
            <p>{{ old('name') }}</p>
            <input type="hidden" name="name" value="{{ old('name') }}">
        </div>

       {{-- 年齢 --}}
       <div class="mb-3">
            <strong>■年齢</strong>
            <p>{{ old('age') }}</p>
            <input type="hidden" name="age" value="{{ old('age') }}">

        </div>

       {{-- 性別 --}}
       <div class="mb-3">
           <strong>■性別</strong>
           <p>{{ old('gender') == 'male' ? '男性' : '女性' }}</p>
           <input type="hidden" name="gender" value="{{ old('gender') }}">
       </div>

       {{-- 職業 --}}
       <div class="mb-3">
           <strong>■職業</strong>
           <p>{{ old('job') }}</p>
           <input type="hidden" name="job" value="{{ old('job') }}">

       </div>

       {{-- メールアドレス（編集不可） --}}
       <div class="mb-3">
           <strong">■メールアドレス</strong>
           <p>{{ old('email') }}</p>
           <input type="hidden" name="email" value="{{ old('email') }}">

       </div>

       {{-- 顔タイプ --}}
       <div class="mb-3">
           <strong>■顔タイプ</strong>
           <p>{{ $faceTypes->firstWhere('id', old('face_type_id'))->name ?? '' }}</p>
           <input type="hidden" name="face_type_id" value="{{ old('face_type_id') }}">
       </div>

        {{-- パーソナルカラー --}}
       <div class="mb-3">
           <strong>■パーソナルカラー</strong>
           <p>{{ $personalColors->firstWhere('id', old('personal_color_id'))->name ?? '' }}</p>
           <input type="hidden" name="personal_color_id" value="{{ old('personal_color_id') }}">
       </div>

{{-- 戻る・保存--ボタン --}}
       <div class="mt-4 d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">← 修正する</a>
            <button type="submit" class="btn btn-primary">更新する</button>
       </div>
    </form>
</div>
@endsection