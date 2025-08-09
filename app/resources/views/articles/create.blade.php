<head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <style>
    .container{
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        text-align: center;
       }

    .card{
        width:600px;
        height: 600px;
        text-align: center;
    }

 </style>
</head>

@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('articles.confirm') }}" method="POST" enctype="multipart/form-data">
       @csrf

      <div class="container">
        <h2>メイク記事新規作成</h2>
      </div>

       <div class="form-group row">
           <label for="title" class="col-sm-2 col-form-label mb-3">タイトル</label>
           <div class="col-sm-6">
               <input type="text" name="title" id="title" class="form-control" required>
           </div>
       </div>

       <div class="form-group row">
           <label for="face_type_id" class="col-sm-2 col-form-label  mb-3">顔タイプ</label>
           <div class="col-sm-3">
               <select name="face_type_id" id="face_type_id" class="form-control">
                <option value="" disabled selected>選択してください</option>
                   @foreach ($facetypes as $facetype)
                       <option value="{{ $facetype->id }}">{{ $facetype->name }}</option>
                   @endforeach
               </select>
           </div>
       </div>

       <div class="form-group row">
           <label for="personal_color_id" class="col-sm-2 col-form-label  mb-3">パーソナルカラー</label>
           <div class="col-sm-3">
               <select name="personal_color_id" id="personal_color_id" class="form-control">
                <option value="" disabled selected>選択してください</option>
                   @foreach ($personalColors as $color)
                       <option value="{{ $color->id }}">{{ $color->name }}</option>
                   @endforeach
               </select>
           </div>
       </div>

       <div class="form-group row">
           <label for="content" class="col-sm-2 col-form-label  mb-5">本文内容</label>
           <div class="col-sm-8">
               <textarea name="content" id="content" class="form-control" rows="8"></textarea>
           </div>
       </div>

       <div class="form-group row">
           <label for="image" class="col-sm-2 col-form-label  mb-3">画像</label>
           <div class="col-sm-6">
               <input type="file" name="image" id="image" class="form-control-file">
           </div>
       </div>

       <div class="form-group row">
           <label for="youtubeSearch" class="col-sm-2 col-form-label  mb-3">動画検索</label>
           <div class="col-sm-6 d-flex">
               <input type="text" id="youtubeSearch" placeholder="メイク ベース" class="form-control">
               <button type="button" class="btn btn-primary ml-2" onclick="searchYouTube()">検索</button>
           </div>
       </div>

       <div id="youtubeResults" class="mb-3 col-sm-8 offset-sm-2">
           <input type="hidden" name="youtube_video_id" id="youtubeVideoId">
       </div>

       <div class="form-group row">
           <div class="col-sm-8 offset-sm-2 d-flex justify-content-between">
               <a href="{{ url()->previous() }}" class="btn btn-secondary">戻る</a>
               <button type="submit" class="btn btn-primary">確認</button>
           </div>
       </div>
    </form>
</div>

<script>
const API_KEY = 'YOUR_YOUTUBE_API_KEY'; 

function searchYouTube() {
    const query = document.getElementById('youtubeSearch').value;
    const url = `https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=5&q=${encodeURIComponent(query)}&key=${API_KEY}`;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            const resultsDiv = document.getElementById('youtubeResults');
            resultsDiv.innerHTML = '';

            data.items.forEach(video => {
                const videoId = video.id.videoId;
                const title = video.snippet.title;
                const thumbnail = video.snippet.thumbnails.default.url;

                const div = document.createElement('div');
                div.style.border = '1px solid #ccc';
                div.style.padding = '5px';
                div.style.marginBottom = '5px';
                div.style.cursor = 'pointer';

                div.innerHTML = `
                    <img src="${thumbnail}" alt="${title}" style="vertical-align: middle;">
                    <span>${title}</span>
                    <button type="button" onclick="selectVideo('${videoId}')" class="btn btn-sm btn-outline-primary ml-2">この動画を選択</button>
                `;
                resultsDiv.appendChild(div);
           });
       });
}

function selectVideo(videoId) {
    document.getElementById('youtubeVideoId').value = videoId;
    alert('動画を選択しました');
}
</script>
@endsection
