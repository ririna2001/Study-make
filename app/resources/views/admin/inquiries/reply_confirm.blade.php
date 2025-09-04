<head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <style>
    .content{
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffff;
        border: 1px solid #ddd;
        text-align: center;
    }

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
    <h2 class="text-center mb-4">お問い合わせ返信確認</h2>
</div>

    <form method="POST" action="{{ route('admin.inquiries.storeReply', $inquiry->id) }}">
        @csrf

        <div class="content card mx-auto p-4" style="max-width: 700px;">
            {{-- 件名 --}}
            <div class="mb-3">
                <label>件名</label>
                <div class="form-control-plaintext">{{ $title }}</div>
            </div>

            {{-- 本文 --}}
            <div class="mb-3">
                <label>返信内容</label>
                <div class="form-control-plaintext">{{ $reply }}</div>
            </div>

             {{-- 内容を保持 --}}
            <input type="hidden" name="title" value="{{ $title }}">
            <input type="hidden" name="reply" value="{{ $reply }}">

        </div>
            {{-- ボタン --}}
        <div class="d-flex justify-content-center gap-5 mt-5">
            <a href="{{ route('admin.inquiries.reply_form', $inquiry->id) }}" class="btn btn-secondary">戻る</a>
            <button type="submit" class="btn btn-primary">返信</button>
        </div>
    </form>

@endsection