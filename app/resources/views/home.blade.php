@extends('layout')
@section('content')
<div class="container mt-4">

    {{-- 絞り込み --}}
    <form method="GET" action="{{ route('articles.index') }}">
        <div class = "filter-box">
            <input type="text" name="keyword" placeholder="キーワード" value="{{ request('keyword') }}">

            性別
            <label><input type="radio" name="gender" value="male"> 男性</label>
            <label><input type="radio" name="gender" value="female"> 女性</label>

            お気に入り
            <label><input type="radio" name="favorite" value="1"> 済</label>
            <label><input type="radio" name="favorite" value="0"> 未</label>

            <br>

            投稿日
            <input type="date" name="date_from" value="{{ request('date_from') }}">
            ～
            <input type="date" name="date_to" value="{{ request('date_to') }}">

            顔タイプ
            <select name="face_type_id">
                <option value="">選択</option>
                @foreach ($faceTypes as $faceType)
                  <option value="{{ $faceType->id }}" {{ request('face_type_id') == $faceType->id ? 'selected' : ''}}>
                    {{ $faceType->name }}
                  </option>
                @endforeach        
            </select>

            パーソナルカラー
            <select name="personal_color_id">
                <option value="">選択</option>
                @foreach ($personalColors as $personalColor)
                  <option value="{{ $personalColor->id }}" {{ request('personal_color_id') == $personalColor->id ? 'selected' : ''}}>
                    {{ $personalColor->name }}
                  </option>
                @endforeach        
            </select>

            <br>
            <button type="submit" class="btn btn-primary">検索</button>
            <a href="{{ route('articles.index') }}" class="btn btn-secondary">リセット</a>
        </div>
    </form>

    {{-- お知らせや記事一覧などをここに表示 --}}
    <div class="article-grid" style="display: flex; flex-wrap: wrap; gap: 16px; margin-top: 20px;">
        @forelse ($articles as $article)
           <div class="article-card" style="width: 30%; border: 1px solid #ccc; padding: 10px;">
               <div><strong>投稿者</strong>{{ $article->user->name }}</div>
               <div><strong>タイトル</strong>{{ $article->title }}</div>
           </div>
        @empty
            <p>記事が見つかりませんでした。</p>
        @endforelse
    </div>

     {{-- ページネーション --}}
     <div class="pagination mt-4">
        {{ $articles->links() }}
     </div>
</div>

@endsection


    
  