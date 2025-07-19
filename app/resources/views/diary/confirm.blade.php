@extends('layouts.app')

@section('content')
<div class="container">
  <h2>内容の確認</h2>

   <form action="{{ route('diary.store') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $inputs['date'] }}">
        <input type="hidden" name="title" value="{{ $inputs['title'] }}">
        <input type="hidden" name="memo" value="{{ $inputs['memo'] }}">
    
        <p><strong>日付</strong> {{ $inputs['date'] }}</p>
        <p><strong>タイトル</strong> {{ $inputs['title'] }}</p>
        <p><strong>メモ</strong><br> {!! n12br(e($inputs['memo'] )) !!}</p>

        <div class="mt-4">
          <button type="submit" class="btn btn-primary">投稿</button>
          <a href="{{ url()->previous() }}" class="btn btn-secondary">←戻る</a>
        </div>
    </form>
</div>
@endsection

