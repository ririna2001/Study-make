@extends('layouts.app')

@section('content')
<div class="container">

<h2>日記作成</h2>

 {{-- バリデーションエラー --}}
   @if($errors->any())
       <div class="alert alert-danger">
           <ul>
                 @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                 @endforeach
           </ul>
       </div>
    @endif

    {{-- 投稿フォーム --}}
    <form action="{{ route('diary.confirm') }}" method="POST">
        @csrf

     {{-- 日付自動入力 --}}
      <div class="form-group">
        <label for="nickname">日付</label>
        <input type="date" name="date" value="{{ old('date_from', \Carbon\Carbon::today()->format('Y-m-d')) }}">
      </div>

      {{-- タイトル --}}
      <div class="form-group">
        <label for="content">タイトル</label>
        <textarea name="title" id="title" class="form-control">{{ old('title') }}</textarea>
      </div>

     {{-- 日記内容--}}
      <div class="form-group">
        <label for="content">メモ</label><br>
        <textarea name="memo" id="memo" class="form-control">{{ old('memo') }}</textarea>
      </div>

     {{-- ボタン --}}
      <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">戻る</a>
        <button type="submit" class="btn btn-primary">確認</button>
      </div>
    </form>
</div>
@endsection

