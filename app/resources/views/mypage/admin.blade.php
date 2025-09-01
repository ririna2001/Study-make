@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="text-center">マイページ</h2>

    <a href="{{route('admin.inquiries.index')}}" class="btn btn-link" style="font-size: 30px;">✉</a>
    <a href="{{route('admin.notifications.create')}}" class="btn btn-primary">お知らせの作成</a>

    {{-- フラッシュメッセージ --}}
    @if (session('message'))
        <div class="titlebox alert alert-success">
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
                    <p>管理者　　：{{ $adminCount }}人</p>
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
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-primary">記事一覧</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">ユーザー一覧</a>
        <a href="{{ route('admin.users.register') }}" class="btn btn-outline-success">管理者新規登録</a>
    </div>
</div>

<script>
    // ページ読み込み後、10秒でフェードアウトして非表示にする
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500); 
            }, 10000); 
        }
    });
</script>

@endsection