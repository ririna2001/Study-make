@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('articles.confirm') }}" method="POST">
       @csrf

         <label>タイトル</label><br>
         <input type="text" name="title" required><br>

         <laravel>顔タイプ</laravel><br>
          <select name="face_type_id">
            @foreach ($facetypes as $facetype)
                <option value="{{ $faceType->id }}">{{ $facetype->name }}</option>
            @endforeach
           </select>

         <laravel>パーソナルカラー</laravel><br>
          <select name="personal_color_id">
            @foreach ($personalColors as $Color)
                <option value="{{ $color->id }}">{{ $color->name }}</option>
            @endforeach
         </select>

         <laravel>本文</laravel><br>
         <textarea name="content"></textarea>

         <laravel>画像</laravel>
         <input type="file" name="image">

         <laravel>動画検索</laravel>
         <input type="text" id="youtubeSearch" placeholder="メイク ベース" />
         <button type="button" onclick="searchYouTube()">検索</button>

          <div id="youtubeResuluts">
            <input type="hidden" name="youtube_video_id" id="youtubeVideoId">
          </div>

          {{-- ボタン --}}
    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">戻る</a>
        <button type="submit" class="btn btn-primary">確認</button>
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
                div.innerHTML = `
                    <img src="${thumbnail}" alt="${title}">
                    <p>${title}</p>
                    <button type="button" onclick="selectVideo('${videoId}')">この動画を選択</button>
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






















</div>