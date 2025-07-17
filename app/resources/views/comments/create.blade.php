@extends('layouts.app')

@section('content')
<div class="container">
   <h2>コメント投稿</h2>

   {{-- バリデーションエラー --}}
   @if($errors->any())
       <div class="alert alert-danger">
           <ul>
                 @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
           </ul>
       </div>
    @endif

    {{-- 投稿フォーム --}}
    <form action="{{ route('comments.store') }}" method="POST">
            @csrf

     {{-- ニックネーム --}}
      <div class="form-group">
        <label for="nickname">ニックネーム</label>
        <input type="text" name="nickname" id="nickname" class="form-control" value="{{ old('nickname') }}">
      </div>

     {{-- コメント内容 --}}
      <div class="form-group">
        <label for="content">ニックネーム</label>
        <textarea name="nickname" id="content" class="form-control" row="5">{{ old('content') }}</textarea>
      </div>

     {{-- ボタン --}}
      <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">戻る</a>
        <button type="submit" class="btn btn-primary">投稿する</button>
      </div>
    </form>
</div>
@endsection