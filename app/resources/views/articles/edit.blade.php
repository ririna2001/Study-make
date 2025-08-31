@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('instructor.articles.update',$article->id) }}" method="POST" enctype="multipart/form-data">
        <div class="container">
           <h2 class="text-center">記事編集</h2>
        </div>
       @csrf
       @method('PUT')

        <div class="mb-4 row align-items-center">
            <label for="title" class="col-sm-2 col-form-label">タイトル</label>
            <div class="col-sm-6">
               <input type="text" id="title" name="title" class="form-control" value="{{ old('title',$article->title) }}" required>
            </div> 
        </div>

        <div class="mb-4 row align-items-center">
            <label for="face_type_id" class="col-sm-2 col-form-label">顔タイプ</label>
            <div class="col-sm-3">
                <select name="face_type_id" id="face_type_id" class="form-select">
                   @foreach ($facetypes as $facetype)
                     <option value="{{ $facetype->id }}" {{ $article->face_type_id == $facetype->id ? 'selected' : '' }}>
                      {{ $facetype->name }}
                     </option>
                   @endforeach
                </select>
            </div>
        </div>

        <div class="mb-4 row align-items-center">
            <label for="personal_color_id" class="col-sm-2 col-form-label">パーソナルカラー</label>
            <div class="col-sm-6">
                <select name="personal_color_id" id="personal_color_id" class="form-select">
                 @foreach ($personalcolors as $color)
                  <option value="{{ $color->id }}" {{ $article->personal_color_id == $color->id ? 'selected' : '' }}>
                    {{ $color->name }}
                  </option>
                 @endforeach
               </select>
             </div>
       </div>

        <div class="mb-4 row align-items-center">
           <label for="content" class="col-sm-2 col-form-label">本文内容</label>
           <div class="col-sm-8">
              <textarea name="content" id="content" class="form-control" rows="8">{{ old('content', $article->content) }}</textarea>
           </div>
        </div>

        <div class="mb-5 row align-items-center">
          <label for="image" class="col-sm-2 col-form-label">画像</label>
          <div class="col-sm-6">
            @if($article->image_path)
            <div>
                <img src="{{ asset('storage/' . $article->image_path) }}" alt="現在の画像" width="150"><br>
                <small>画像を変更する場合は再選択してください</small>
            </div>
            @endif
            <input type="file" name="image" id="image" class="form-control"><br><br>
          </div>
        </div>

        <div class="mb-3 row align-items-center">
            <label class="col-sm-2 col-form-label">動画検索</label>
            <div class="col-sm-6 d-flex gap-2">
                <input type="text" id="youtubeSearch" class="form-control" placeholder="メイク ベース" />
                <button type="button" class="btn btn-outline-primary" onclick="searchYouTube()">検索</button>
            </div>
        </div>

        <div id="youtubeResults" class="mb-3"></div>

        <input type="hidden" name="youtube_video_id" id="youtubeVideoId" value="{{ $article->youtube_video_id }}">
        @if($article->youtube_video_id)
            <p>現在の動画ID: {{ $article->youtube_video_id }}</p>
            <iframe width="300" height="200" src="https://www.youtube.com/embed/{{ $article->youtube_video_id }}" frameborder="0" allowfullscreen></iframe>
        @endif

        {{-- ボタン --}}
        <div class="mt-4 d-flex gap-3 justify-content-center">
            <a href="{{ route('articles.show',$article->id) }}" class="btn btn-secondary">戻る</a>
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
                div.classList.add('mb-3');
                div.innerHTML = `
                    <img src="${thumbnail}" alt="${title}" class="me-2" style="vertical-align:middle;">
                    <span>${title}</span>
                    <button type="button" class="btn btn-sm btn-outline-primary ms-3" onclick="selectVideo('${videoId}')">この動画を選択</button>
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
