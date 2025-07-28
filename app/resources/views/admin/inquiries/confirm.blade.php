@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">お知らせ確認</h2>

    <form method="POST" action="{{ route('admin.inquiries.store') }}">
        @csrf

        <div class="card mx-auto p-4" style="max-width: 700px;">
            <div class="mb-3">
                <label>件名</label>
                <div class="form-control-plaintext">{{ $title }}</div>
            </div>

            <div class="mb-3">
                <label>日付</label>
                <div class="form-control-plaintext">{{ $date }}</div>
            </div>

            <div class="mb-3">
                <label>お知らせ内容</label>
                <div class="form-control-plaintext">{{ $content }}</div>
            </div>

            <input type="hidden" name="title" value="{{ $title }}">
            <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="content" value="{{ $content }}">

            <div class="d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">←戻る</a>
                <button type="submit" class="btn btn-success">登録</button>
            </div>
        </div>
    </form>
</div>
@endsection
