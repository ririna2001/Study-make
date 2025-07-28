@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">お知らせ作成</h2>

    <form method="POST" action="{{ route('admin.inquiries.confirm') }}">
        @csrf

        <div class="card mx-auto p-4" style="max-width: 700px;">
            {{-- 件名 --}}
            <div class="mb-3">
                <label for="title">件名</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            {{-- 日付（自動入力） --}}
            <div class="mb-3">
                <label for="date">日付</label>
                <input type="text" id="date" name="date" class="form-control" value="{{ now()->format('Y-m-d') }}" readonly>
            </div>

            {{-- お知らせ内容 --}}
            <div class="mb-4">
                <label for="content">お知らせ内容</label>
                <textarea id="content" name="content" class="form-control" rows="6" required>{{ old('content') }}</textarea>
            </div>

            {{-- ボタン --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('mypage.admin') }}" class="btn btn-secondary">←戻る</a>
                <button type="submit" class="btn btn-primary">確認</button>
            </div>
        </div>
    </form>
</div>
@endsection
