@extends('layouts.app')

@section('content')
<div class="container">
    <h2>投稿内容の確認</h2>

    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- タイトル --}}
        <div class="mb-3">
            <label>タイトル:</label>
            <div>{{ $inputs['title'] }}</div>
            <input type="hidden" name="title" value="{{ $inputs['title'] }}">
        </div>

        {{-- 顔タイプ --}}
        <div class="mb-3">
            <label>顔タイプ:</label>
            <div>{{ $facetypes[$inputs['face_type_id']] ?? '未選択' }}</div>
            <input type="hidden" name="face_type_id" value="{{ $inputs['face_type_id'] }}">
        </div>

        {{-- パーソナルカラー --}}
        <div class="mb-3">
            <label>パーソナルカラー:</label>
            <div>{{ $personalColors[$inputs['personal_color_id']] ?? '未選択' }}</div>
            <input type="hidden" name="personal_color_id" value="{{ $inputs['personal_color_id'] }}">
        </div>

        {{-- 本文 --}}
        <div class="mb-3">
            <label>本文:</label>
            <div>{!! nl2br(e($inputs['content'])) !!}</div>
            <input type="hidden" name="content" value="{{ $inputs['content'] }}">
        </div>

        {{-- 画像 --}}
        @if (isset($image_path))
            <div class="mb-3">
                <label>画像:</label><br>
                <img src="{{ asset('storage/temp/' . $image_path) }}" alt="アップロード画像" width="200">
                <input type="hidden" name="image_path" value="{{ $image_path }}">
            </div>
        @endif

        {{-- YouTube --}}
        @if (!empty($inputs['youtube_video_id']))
            <div class="mb-3">
                <label>選択した動画:</label><br>
                <iframe width="300" height="200" src="https://www.youtube.com/embed/{{ $inputs['youtube_video_id'] }}" frameborder="0" allowfullscreen></iframe>
                <input type="hidden" name="youtube_video_id" value="{{ $inputs['youtube_video_id'] }}">
            </div>
        @endif

        {{-- ボタン --}}
        <div class="mt-4 d-flex gap-3">
            <button type="submit" class="btn btn-primary">投稿する</button>
            <button type="submit" formaction="{{ route('articles.create') }}" class="btn btn-secondary">修正する</button>
        </div>
    </form>
</div>
@endsection
