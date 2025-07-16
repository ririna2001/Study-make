@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">マイプロフィール</h2>

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
            <label for="name" class="form-label">■名前</label>
            <input type="text" name="name" id="name" value="{{ old('name', $profile->name) }}" class="form-control">
       </div>

       {{-- 年齢 --}}
       <div class="mb-3">
            <label for="age" class="form-label">■年齢</label>
            <input type="number" name="age" id="age" value="{{ old('age', $profile->age) }}" class="form-control">
       </div>

       {{-- 性別 --}}
       <div class="mb-3">
           <label class="form-label">■性別</label><br>
           <label><input type="radio" name="gender" value="male" {{ $profile->gender == 'male' ? 'checked' : '' }}> 男性</label>
           <label><input type="radio" name="gender" value="female" {{ $profile->gender == 'female' ? 'checked' : '' }}> 女性</label>
       </div>

       {{-- 職業 --}}
       <div class="mb-3">
           <label for="job" class="form-label">■職業</label>
           <input type="text" name="job" id="job" value="{{ old('job', $profile->job) }}" class="form-control">
       </div>

       {{-- メールアドレス（編集不可） --}}
       <div class="mb-3">
           <label class="form-label">■メールアドレス</label>
           <input type="email" class="form-control" value="{{ $user->email }}" disabled>
       </div>

       {{-- 顔タイプ --}}
       <div class="mb-3">
           <label for="face_type_id" class="form-label">■顔タイプ</label>
           <select name="face_type_id" id="face_type_id" class="form-control">
                @foreach($faceTypes as $type)
                    <option value="{{ $type->id }}" {{ $profile->face_type_id == $type->id ? 'selected' : '' }}>
                       {{ $type->name }}
                    </option>
                @endforeach
           </select>
       </div>

        {{-- パーソナルカラー --}}
       <div class="mb-3">
           <label for="personal_color_id" class="form-label">■パーソナルカラー</label>
           <select name="personal_color_id" id="personal_color_id" class="form-control">
                @foreach($personalColors as $color)
                    <option value="{{ $color->id }}" {{ $profile->personal_color_id == $color->id ? 'selected' : '' }}>
                       {{ $color->name }}
                    </option>
                @endforeach
           </select>
       </div>

{{-- 戻る・確認ボタン --}}
       <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('mypage.index') }}" class="btn btn-secondary">← 戻る</a>
            <button type="submit" class="btn btn-primary">確認</button>
       </div>
    </form>
</div>
@endsection