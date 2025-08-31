<head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <style>
    
    .title{
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffff;
        border: 1px solid #ddd;
        text-align: center;
    }

     </style>
</head>


@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">投稿内容の確認</h2>

    <form action="{{ route('instructor.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- タイトル --}}
        <div class="form-group row justify-content-center mb-3">
            <label for="title" class="col-sm-2 col-form-label mb-3">タイトル:</label>
            <div class="col-sm-6">{{ $inputs['title'] }}</div>
            <input type="hidden" name="title" value="{{ $inputs['title'] }}">
        </div>

        {{-- 顔タイプ --}}
        <div class="form-group row justify-content-center mb-3">
            <label  for="title" class="col-sm-2 col-form-label mb-3">顔タイプ:</label>
            <div class="col-sm-6">{{ $facetypes[$inputs['face_type_id']]->name ?? '未選択' }}</div>
            <input type="hidden" name="face_type_id" value="{{ $inputs['face_type_id'] }}">
        </div>

        {{-- パーソナルカラー --}}
        <div class="form-group row justify-content-center mb-3">
            <label  for="title" class="col-sm-2 col-form-label mb-3">パーソナルカラー:</label>
             <div class="col-sm-6">{{ $personalColors[$inputs['personal_color_id']]->name ?? '未選択' }}</div>
            <input type="hidden" name="personal_color_id" value="{{ $inputs['personal_color_id'] }}">
        </div>

        {{-- 本文 --}}
         <div class="form-group row justify-content-center mb-3">
           <label  for="title" class="col-sm-2 col-form-label mb-3">本文:</label>
            <div class="col-sm-6">{!! nl2br(e($inputs['content'])) !!}</div>
            <input type="hidden" name="content" value="{{ $inputs['content'] }}">
        </div>

        {{-- 画像 --}}
        @if (!empty($inputs['image_path']))
            <div class="form-group row justify-content-center mb-3">
                <label>画像:</label><br>
                <img src="{{ asset('storage/' . $inputs['image_path']) }}" alt="アップロード画像" style="max-width: 300px;">
                <input type="hidden" name="image_path" value="{{ $inputs['image_path'] }}">
            </div>
        @endif

        {{-- YouTube --}}
        @if (!empty($inputs['youtube_video_id']))
            <div class="form-group row justify-content-center mb-3">
                <label>選択した動画:</label><br>
                <iframe src="https://www.youtube.com/embed/{{ $inputs['youtube_video_id'] }}" style="width:400px; height:300px;" frameborder="0" allowfullscreen></iframe>
                <input type="hidden" name="youtube_video_id" value="{{ $inputs['youtube_video_id'] }}">
            </div>
        @endif

        {{-- ボタン --}}
        <div class="mt-4 d-flex gap-3 justify-content-center">
            <a href="{{ route('instructor.articles.create') }}" class="btn btn-secondary">修正する</a>
            <button type="submit" class="btn btn-primary">投稿する</button>
        </div>
    </form>
</div>
@endsection
