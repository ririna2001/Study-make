<head>
     <meta charset="UTF-8">
     <title>@yield('title','Studymake')</title>
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <style>
    .filter-box {
      max-width: 950px;
      margin: 50px auto;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      text-align: center;
      }
    
    .container{
        max-width: 1100px;
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


   {{-- フラッシュメッセージ --}}
   @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- タイトル --}}

       <h2 style="text-align: center;">記事一覧</h2>

   {{-- 絞り込み --}}
    <div class="d-flex justify-content-center align-items-center ">
       <form method="GET" action="{{ route('instructor.articles.my_articles') }}" class="w-75">
        <div class = "container" >

        <div class="search-box">
             <div class="search-row">
                     <div class="search-item">
                       <label for="keyword" class="form-label mr-auto">キーワード：</label>
                       <input type="text" name="keyword" placeholder="キーワード" value="{{ request('keyword') }}">
                   </div>

            投稿日:
            <input type="date" name="date_from" value="{{ request('date_from') }}">
            ～
            <input type="date" name="date_to" value="{{ request('date_to') }}">

            <br>

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
            <div class="search-actions mb-3">
              <a href="{{ route('instructor.articles.my_articles') }}" class="btn btn-secondary pt-2">リセット</a>
              <button type="submit" class="btn btn-primary pt-2">検索</button>
           </div>  
    </form>
  </div>

    {{-- 一覧 --}}
    <ul class="list-group">
      @foreach($articles as $article)
        <li class="list-group-item d-flex justify-content-between align-item-center">
              <div>
                <small>{{ $article->created_at->format('y/m/d') }}</small>
                <strong>{{ $article->title }}</strong>
              </div>
              <a href="{{ route('instructor.articles.show', $article->id) }}" class="btn btn-outline-primary">▶</a>
        </li>
      @endforeach
  </ul>

   <a href="{{ route('instructor.mypage.index') }}" class="btn btn-secondary mt-3">戻る</a>
   

    {{-- ページネーション --}}
   <div class="mt-3">
     {{ $articles->links() }}
   </div>
</div>
@endsection