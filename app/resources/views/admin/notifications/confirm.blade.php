@extends('layouts.app')

@section('content')
<div class="container">
    <div class="titlebox text-center mb-4">
        <h2>お知らせ確認</h2>
</div>

    <form method="POST" action="{{ route('admin.notifications.store') }}">
        @csrf

        <div class="card mx-auto p-4" style="max-width: 700px;">
            <div class="mb-3">
                <label>件名</label>
                <div class="form-control-plaintext">{{ $inputs['title'] }}</div>
            </div>

            <div class="mb-3">
                <label>日付</label>
                <div class="form-control-plaintext">{{ $inputs['date']  }}</div>
            </div>

            <div class="mb-3">
                <label>お知らせ内容</label>
                <div class="form-control-plaintext">{{ $inputs['content'] }}</div>
            </div>

            <input type="hidden" name="title" value="{{ $inputs['title'] }}">
            <input type="hidden" name="date" value="{{ $inputs['date'] }}">
            <input type="hidden" name="content" value="{{ $inputs['content'] }}">

            <div class="d-flex justify-content-between">
                <a href="{{route('admin.notifications.create')}}" class="btn btn-secondary">戻る</a>
                <button type="submit" class="btn btn-success">送信</button>
            </div>
        </div>
    </form>
</div>
@endsection
