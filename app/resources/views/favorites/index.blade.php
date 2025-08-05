<head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


 <style>
    .search-box {
      max-width: 950px;
      margin: 50px auto;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      text-align: center;
      }
    
    .search-row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 10px;
    gap: 35px;
    }

    .search-item {
    min-width: 180px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .search-item label {
    white-space: nowrap;
  }

  .search-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 10px;

    
  }

    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      text-align: center;
    }

 </style>
</head>

@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-4 text-center">お気に入り記事一覧ページ</h2>
</div>

    {{-- フラッシュメッセージ（10秒で消える） --}}
    @if (session('success'))
        <div class="alert alert-success" id="flash-message">
            {{ session('success') }}
        </div>
    @endif

    {{-- 検索・絞り込み --}}
<div class="search-box">
    <form method="GET" action="{{ route('favorites.index') }}" class="mb-4 border p-3 rounded">
      <div class="search-row">
        <div class="search-item">
           <label for="keyword" class="form-label mr-auto">キーワード：</label>
           <input type="text" name="keyword" placeholder="キーワード" value="{{ request('keyword') }}">
        </div>

        <div class="search-item">
           <label for="keyword" class="form-label mr-auto">講師名：</label>
           <input type="text" name="keyword" placeholder="instructor" value="{{ request('instructor') }}">
        </div>

            <br>
 
      <div class="search-row">
        <div class="search-item">
          <label class="form-label">投稿日：</label>
              <input type="date" name="date_from" value="{{ request('date_from') }}">
              ～
              <input type="date" name="date_to" value="{{ request('date_to') }}">
        </div>

        <div class="search-item">
          <label class="form-label">顔タイプ：</label>
              <select name="face_type_id">
                <option value="">選択</option>
                @foreach ($faceTypes as $faceType)
                  <option value="{{ $faceType->id }}" {{ request('face_type_id') == $faceType->id ? 'selected' : ''}}>
                    {{ $faceType->name }}
                  </option>
                @endforeach        
              </select>
        </div>

        <div class="search-item">
          <label class="form-label">パーソナルカラー：</label>
              <select name="personal_color_id">
                <option value="">選択</option>
                @foreach ($personalColors as $personalColor)
                  <option value="{{ $personalColor->id }}" {{ request('personal_color_id') == $personalColor->id ? 'selected' : ''}}>
                    {{ $personalColor->name }}
                  </option>
                @endforeach        
              </select>
        </div>
      </div>

        <br>

        <div class="search-actions">
            <a href="{{ route('favorites.index') }}" class="btn btn-secondary">リセット</a>
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </form>
</div>

    {{-- 一覧テーブル --}}
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>記事タイトル</th>
                <th>講師</th>
                <th>お気に入り</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($favorites as $index => $favorite)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $favorite->article->title }}</td>
                    <td>{{ $favorite->article->instructor->name ?? '―' }}</td>
                    <td class="text-center">
                    <form method="POST" action="{{ route('favorites.toggle', $article->id) }}">
                        @csrf
                        <button type="submit"
                                class="btn btn-link p-0 border-0 bg-transparent"
                                title="お気に入り切り替え">
                            {{-- 好きな表示方法を選択 --}}
                            @if($isFav)
                                <span style="font-size:1.3rem;">❤️</span>
                            @else
                                <span style="font-size:1.3rem;">🤍</span>
                            @endif
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    {{-- 戻るボタン --}}
    <div class="mt-4 text-center">
        <a href="{{ route('mypage.index') }}" class="btn btn-secondary">戻る</a>
    </div>
</div>

{{-- フラッシュメッセージ自動非表示 --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            setTimeout(() => {
                flash.style.transition = 'opacity 0.5s ease';
                flash.style.opacity = '0';
                setTimeout(() => flash.style.display = 'none', 500);
            }, 10000); // 10秒後に非表示
        }
    });
</script>
@endsection
