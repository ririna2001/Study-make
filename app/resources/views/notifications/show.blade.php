@extends('layouts.app')

@section('content')
<div class="container">
    <h2>お知らせ</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ $notification->title }}</h2>
             <span>{{ $notification->created_at->format('Y年m月d日') }}</span>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p>{!! nl2br(e($notification->body)) !!}</p>
        </div>
    </div>

    <a href="{{ route('notifications.index') }}" class="btn btn-secondary"><-戻る</a>
</div>
@endsection
