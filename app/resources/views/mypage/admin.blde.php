@extends('layouts')

@section('content')

<div class="container">
    <h2 class="mb-4">マイページ</h2>

    {{-- フラッシュメッセージ --}}

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif


    {{-- 利用状況 --}}
    <div class="row">
        {{-- 月の利用者数 --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">月の利用者数</div>
                <div class="card-body">
                    <p>一般ユーザー：{{ $userCount }}人</p>
                    <p>メイク講師　：{{ $instructorCount }}人</p>
                    <p>管理者　　　：{{ $adminCount }}人</p>
                </div>
            </div>
        </div>

        {{-- ユーザーの男女比 --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">ユーザーの男女比</div>
               <div class="card-body">
                    <p>男性：{{ $maleCount }}人</p>
                    <p>女性：{{ $femaleCount }}人</p>
                </div>
            </div>
        </div>

        {{-- 記事投稿数 --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">今月の投稿記事数</div>
                <div class="card-body">
                    <p>{{ $articleCount }} 件</p>
                </div>
            </div>
        </div>

        {{-- 今月の新規登録者数 --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">今月の新規登録者数</div>
                <div class="card-body">
                    <p>{{ $newRegistrations }}人</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 管理ボタン --}}
    <div class="mt-4 d-flex justify-content-around">
        <a href="{{ route('articles.index') }}" class="btn btn-outline-primary">記事一覧</a>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">ユーザー一覧</a>
        <a href="{{ route('admin.register') }}" class="btn btn-outline-success">管理者新規登録</a>
    </div>
</div>
@endsection