@extends('layouts.admin')

@section('content')
<h2>記事一覧</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('articles.index') }}">
    <input type="text" name="keyword" placeholder="キーワード" value="{{ request('keyword') }}">

    講師名
    <input type="text" name="teacher_name" value="{{ request('teacher_name') }}">

    削除
    <label><input type="radio" name="delete" value="1" {{ request('delete') == '1' ? 'checked' : '' }}> 済</label>
    <label><input type="radio" name="delete" value="0" {{ request('delete')  == '0' ? 'checked' : '' }}> 未</label>

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
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">リセット</a>
        </div>
    </form>
  </div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>タイトル</th>
            <th>講師</th>
            <th>作成日</th>
            <th>削除</th>
            <th>復元</th>
            <th>完全削除</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articles as $index => $article)
            <tr>
                <td>{{ $index + $articles->firstItem() }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->instructor->name ?? '未設定' }}</td>
                <td>{{ $article->created_at->format('Y-m-d') }}</td>
                <td>
                    @if(!$article->trashed())
                        <form method="POST" action="{{ route('admin.articles.softDelete', $article->id) }}">
                            @csrf
                            <button type="submit">削除</button>
                        </form>
                    @else
                        削除済み
                    @endif
                </td>
                <td>
                    @if($article->trashed())
                        <form method="POST" action="{{ route('admin.articles.restore', $article->id) }}">
                            @csrf
                            <button type="submit">復元</button>
                        </form>
                    @endif
                </td>
                <td>
                    @if($article->trashed())
                        <form method="POST" action="{{ route('admin.articles.forceDelete', $article->id) }}">
                            @csrf
                            <button type="submit">完全削除</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $articles->links() }}

<a href="{{ route('articles.index') }}">戻る</a>

@endsection