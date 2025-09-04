<head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <style>
    .titlebox{
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffff;
        border: 5px solid #ddd;
        text-align: center;
    }

    .buttonbox{
       max-width: 370px;
       margin: 50px auto;
       padding: 20px;
       text-align: center;
    }


 </style>
</head>


@extends('layouts.app')

@section('content')
<div class="titlebox">
    <h2 class="text-center mb-4">お問い合わせ返信</h2>
</div>

<form method="POST" action="{{ route('admin.inquiries.confirm', $inquiry->id) }}">
        @csrf

<div class="card mx-auto p-4" style="max-width: 900px;">
    {{-- ユーザーが送った内容（表示専用） --}}
    <div class="mb-3">
        <label>お問い合わせ項目</label>
        <div class="border p-3 bg-light rounded" style="white-space: pre-wrap;">
            {{ $inquiry->category }}
        </div>
        <input type="hidden" name="inquiry_category" value="{{ $inquiry->category }}">
    </div>

    <div class="mb-3">
        <label>お問い合わせ本文</label>
        <div class="border p-3 bg-light rounded" style="white-space: pre-wrap;">
            {{ $inquiry->content }}
        </div>
        <input type="hidden" name="inquiry_content" value="{{ $inquiry->content }}">
    </div>

    {{-- 管理者が入力する返信件名 --}}
    <div class="mb-3">
        <label for="title">返信件名</label>
        <input type="text" id="title" name="title" class="form-control"
               value="{{ old('title') }}">
    </div>

    {{-- 管理者が入力する返信本文 --}}
    <div class="mb-3">
        <label for="reply">返信本文</label>
        <textarea id="reply" name="reply" class="form-control" rows="10">{{ old('reply') }}</textarea>
    </div>
</div>


            {{-- ボタン --}}
    <div class="d-flex justify-content-center gap-5 mt-5">
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">戻る</a>
        <button type="submit" class="btn btn-primary">確認</button>
    </div>

</form>

@endsection