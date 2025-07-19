@extends('layouts.app')

@section('content')
<div class="container">

<h2>日記</h2>


    {{-- 日付自動入力 --}}
    <div class="mb-3">
        <strong>日付</strong>
        <p>{{ $diary->date }}</p>
    </div>

      {{-- タイトル --}}
    <div class="mb-3">
        <strong>タイトル</strong>
        <p>{{ $diary->title }}</p>
    </div>

     {{-- 日記内容--}}
    <div class="mb-3">
        <strong>メモ</strong>
        <p>{{ $diary->memo }}</p>
    </div>

     {{-- ボタン --}}
    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">←戻る</a>
    </div>
</div>
@endsection

